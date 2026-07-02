import Quill from 'quill';
import 'quill/dist/quill.snow.css';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-quill-editor]').forEach((editor) => {
        const input = editor.querySelector('[data-quill-input]');
        const surface = editor.querySelector('[data-quill-surface]');

        if (!input || !surface) {
            return;
        }

        const quill = new Quill(surface, {
            bounds: editor,
            modules: {
                toolbar: [
                    [{ header: [2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['blockquote', 'link'],
                    ['clean'],
                ],
            },
            placeholder: surface.dataset.placeholder || '',
            theme: 'snow',
        });

        if (input.value.trim() !== '') {
            quill.clipboard.dangerouslyPasteHTML(input.value);
        }

        const sync = () => {
            const html = quill.root.innerHTML.trim();
            input.value = html === '<p><br></p>' ? '' : html;
        };

        quill.on('text-change', sync);
        input.closest('form')?.addEventListener('submit', sync);
        sync();
    });
});
