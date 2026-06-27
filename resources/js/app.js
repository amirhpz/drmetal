document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            const isOpen = menu.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', () => {
            const button = form.querySelector('button[type="submit"]');

            if (button) {
                button.disabled = true;
                button.dataset.originalText = button.textContent;
                button.textContent = 'در حال ارسال...';
            }
        });
    });

    const priceSwiper = document.querySelector('[data-price-swiper]');

    if (priceSwiper) {
        const track = priceSwiper.querySelector('.swiper-wrapper');
        const slides = [...priceSwiper.querySelectorAll('.swiper-slide')];
        const previous = document.querySelector('[data-price-prev]');
        const next = document.querySelector('[data-price-next]');
        const pagination = document.querySelector('[data-price-pagination]');
        let activeIndex = 0;
        let perView = 4;
        let startX = 0;
        let dragX = 0;
        let isDragging = false;
        let slideStep = 0;
        let pageStarts = [0];

        const readPerView = () => {
            if (window.matchMedia('(max-width: 760px)').matches) {
                return 1;
            }

            if (window.matchMedia('(max-width: 900px)').matches) {
                return 2;
            }

            if (window.matchMedia('(max-width: 1180px)').matches) {
                return 3;
            }

            return 4;
        };

        const update = () => {
            perView = readPerView();
            const maxIndex = Math.max(slides.length - perView, 0);
            activeIndex = Math.min(activeIndex, maxIndex);
            pageStarts = [];

            for (let index = 0; index < slides.length; index += perView) {
                pageStarts.push(Math.min(index, maxIndex));
            }

            pageStarts = [...new Set(pageStarts)];

            if (!pageStarts.length) {
                pageStarts = [0];
            }

            const slideWidth = slides[0]?.getBoundingClientRect().width ?? 0;
            const gap = Number.parseFloat(getComputedStyle(track).gap) || 0;
            slideStep = slideWidth + gap;
            track.style.transform = `translateX(${activeIndex * slideStep}px)`;

            if (previous) {
                previous.disabled = activeIndex === 0;
            }

            if (next) {
                next.disabled = activeIndex >= maxIndex;
            }

            if (pagination) {
                pagination.innerHTML = '';
                pagination.hidden = pageStarts.length <= 1;
                const activePage = pageStarts.findIndex((start) => start === activeIndex);

                pageStarts.forEach((pageStart, index) => {
                    const dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = index === activePage ? 'is-active' : '';
                    dot.setAttribute('aria-label', `نمایش گروه ${index + 1}`);
                    dot.setAttribute('aria-current', index === activePage ? 'true' : 'false');
                    dot.addEventListener('click', () => {
                        moveTo(pageStart);
                    });
                    pagination.append(dot);
                });
            }
        };

        const moveTo = (index) => {
            const maxIndex = Math.max(slides.length - perView, 0);
            activeIndex = Math.max(0, Math.min(index, maxIndex));
            update();
        };

        previous?.addEventListener('click', () => {
            const currentPage = pageStarts.findIndex((start) => start === activeIndex);
            moveTo(pageStarts[Math.max(currentPage - 1, 0)] ?? 0);
        });

        next?.addEventListener('click', () => {
            const currentPage = pageStarts.findIndex((start) => start === activeIndex);
            moveTo(pageStarts[Math.min(currentPage + 1, pageStarts.length - 1)] ?? 0);
        });

        priceSwiper.addEventListener('pointerdown', (event) => {
            isDragging = true;
            startX = event.clientX;
            dragX = 0;
            priceSwiper.classList.add('is-dragging');
            priceSwiper.setPointerCapture(event.pointerId);
        });

        priceSwiper.addEventListener('pointermove', (event) => {
            if (!isDragging) {
                return;
            }

            dragX = event.clientX - startX;
            track.style.transform = `translateX(${(activeIndex * slideStep) + dragX}px)`;
        });

        const finishDrag = () => {
            if (!isDragging) {
                return;
            }

            isDragging = false;
            priceSwiper.classList.remove('is-dragging');

            if (Math.abs(dragX) > Math.max(slideStep * .18, 48)) {
                const currentPage = pageStarts.findIndex((start) => start === activeIndex);
                const nextPage = dragX > 0 ? currentPage + 1 : currentPage - 1;
                moveTo(pageStarts[Math.max(0, Math.min(nextPage, pageStarts.length - 1))] ?? 0);
                return;
            }

            update();
        };

        priceSwiper.addEventListener('pointerup', finishDrag);
        priceSwiper.addEventListener('pointercancel', finishDrag);
        window.addEventListener('resize', update);
        update();
    }
});
