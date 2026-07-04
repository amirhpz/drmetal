document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('.site-header');
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            const isOpen = menu.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            header?.classList.remove('is-hidden');
        });
    }

    if (header) {
        let lastScrollY = window.scrollY;
        let ticking = false;

        const updateHeader = () => {
            const currentScrollY = window.scrollY;
            const isMenuOpen = menu?.classList.contains('is-open') ?? false;

            header.classList.toggle('is-scrolled', currentScrollY > 24);

            if (currentScrollY <= 24 || isMenuOpen) {
                header.classList.remove('is-hidden');
            } else if (currentScrollY > lastScrollY && currentScrollY > 120) {
                header.classList.add('is-hidden');
            } else if (currentScrollY < lastScrollY) {
                header.classList.remove('is-hidden');
            }

            lastScrollY = Math.max(currentScrollY, 0);
            ticking = false;
        };

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }, { passive: true });

        updateHeader();
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

    const setupCarousel = ({ rootSelector, trackSelector, slideSelector, previousSelector, nextSelector, paginationSelector, draggingClass, readPerView }) => {
        const root = document.querySelector(rootSelector);

        if (!root) {
            return;
        }

        const track = root.querySelector(trackSelector);
        const slides = [...root.querySelectorAll(slideSelector)];
        const previous = document.querySelector(previousSelector);
        const next = document.querySelector(nextSelector);
        const pagination = document.querySelector(paginationSelector);

        if (!track || slides.length === 0) {
            return;
        }

        let activeIndex = 0;
        let perView = readPerView();
        let startX = 0;
        let dragX = 0;
        let isDragging = false;
        let slideStep = 0;
        let pageStarts = [0];

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

        root.addEventListener('pointerdown', (event) => {
            isDragging = true;
            startX = event.clientX;
            dragX = 0;
            root.classList.add(draggingClass);
            root.setPointerCapture(event.pointerId);
        });

        root.addEventListener('pointermove', (event) => {
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
            root.classList.remove(draggingClass);

            if (Math.abs(dragX) > Math.max(slideStep * .18, 48)) {
                const currentPage = pageStarts.findIndex((start) => start === activeIndex);
                const nextPage = dragX > 0 ? currentPage + 1 : currentPage - 1;
                moveTo(pageStarts[Math.max(0, Math.min(nextPage, pageStarts.length - 1))] ?? 0);
                return;
            }

            update();
        };

        root.addEventListener('pointerup', finishDrag);
        root.addEventListener('pointercancel', finishDrag);
        window.addEventListener('resize', update);
        update();
    };

    const homepagePerView = () => {
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

    setupCarousel({
        rootSelector: '[data-price-swiper]',
        trackSelector: '.swiper-wrapper',
        slideSelector: '.swiper-slide',
        previousSelector: '[data-price-prev]',
        nextSelector: '[data-price-next]',
        paginationSelector: '[data-price-pagination]',
        draggingClass: 'is-dragging',
        readPerView: homepagePerView,
    });

    setupCarousel({
        rootSelector: '[data-client-swiper]',
        trackSelector: '.client-carousel-track',
        slideSelector: '.client-slide',
        previousSelector: '[data-client-prev]',
        nextSelector: '[data-client-next]',
        paginationSelector: '[data-client-pagination]',
        draggingClass: 'is-dragging',
        readPerView: homepagePerView,
    });

    const quoteModal = document.querySelector('[data-quote-modal]');
    const quoteForm = document.querySelector('[data-quote-form]');
    const toast = document.querySelector('[data-site-toast]');
    const openQuoteButtons = document.querySelectorAll('[data-quote-modal-open]');
    const closeQuoteButtons = document.querySelectorAll('[data-quote-modal-close]');
    const quoteProductSelect = document.querySelector('[data-quote-product-select]');
    const quoteModalTitle = document.querySelector('[data-quote-modal-title]');

    const showToast = (message, type = 'success') => {
        if (!toast) {
            return;
        }

        toast.textContent = message;
        toast.dataset.type = type;
        toast.classList.add('is-visible');

        window.clearTimeout(showToast.timeoutId);
        showToast.timeoutId = window.setTimeout(() => {
            toast.classList.remove('is-visible');
        }, 5200);
    };

    const setQuoteModalOpen = (isOpen) => {
        if (!quoteModal) {
            return;
        }

        quoteModal.classList.toggle('is-open', isOpen);
        quoteModal.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
        document.body.classList.toggle('has-open-modal', isOpen);

        if (isOpen) {
            quoteModal.querySelector('input[name="contact_person"]')?.focus();
        } else {
            openQuoteButtons[0]?.focus();
        }
    };

    openQuoteButtons.forEach((button) => {
        button.addEventListener('click', () => setQuoteModalOpen(true));
    });

    quoteProductSelect?.addEventListener('change', () => {
        if (!quoteModalTitle) {
            return;
        }

        quoteModalTitle.textContent = quoteProductSelect.selectedOptions[0]?.textContent?.trim() || 'ثبت سریع درخواست سفارش';
    });

    closeQuoteButtons.forEach((button) => {
        button.addEventListener('click', () => setQuoteModalOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && quoteModal?.classList.contains('is-open')) {
            setQuoteModalOpen(false);
        }
    });

    const clearQuoteErrors = () => {
        quoteForm?.querySelectorAll('[data-error-for]').forEach((errorElement) => {
            errorElement.textContent = '';
        });
    };

    const restoreQuoteSubmitButton = () => {
        const button = quoteForm?.querySelector('button[type="submit"]');

        if (!button) {
            return;
        }

        button.disabled = false;
        button.textContent = button.dataset.originalText || 'ثبت درخواست قیمت';
    };

    quoteForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearQuoteErrors();

        const submitButton = quoteForm.querySelector('button[type="submit"]');

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.dataset.originalText = submitButton.dataset.originalText || submitButton.textContent;
            submitButton.textContent = 'در حال ثبت...';
        }

        try {
            const response = await fetch(quoteForm.action, {
                method: 'POST',
                body: new FormData(quoteForm),
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const payload = await response.json().catch(() => ({}));

            if (response.ok) {
                quoteForm.reset();
                setQuoteModalOpen(false);
                showToast(payload.message || 'درخواست قیمت شما ثبت شد.', 'success');
                return;
            }

            if (response.status === 422 && payload.errors) {
                Object.entries(payload.errors).forEach(([field, messages]) => {
                    const errorElement = quoteForm.querySelector(`[data-error-for="${field}"]`);

                    if (errorElement) {
                        errorElement.textContent = messages[0] || '';
                    }
                });

                showToast('لطفا خطاهای فرم درخواست قیمت را بررسی کنید.', 'danger');
                return;
            }

            if (response.status === 429) {
                showToast('تعداد درخواست‌ها زیاد است. چند دقیقه بعد دوباره تلاش کنید.', 'danger');
                return;
            }

            showToast(payload.message || 'ثبت درخواست انجام نشد. دوباره تلاش کنید.', 'danger');
        } catch (error) {
            showToast('ارتباط با سرور برقرار نشد. دوباره تلاش کنید.', 'danger');
        } finally {
            restoreQuoteSubmitButton();
        }
    });
});
