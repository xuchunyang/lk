// import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import {setupPasteAndDropImage} from "./markdown-editor";

document
    .querySelectorAll('.js-markdown-editor')
    .forEach(el => setupPasteAndDropImage(el));

const renderMarkdown = async (markdown) => {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const formData = new FormData();
    formData.append('markdown', markdown);
    return fetch('/render/markdown', {
        method: 'post',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token,
        },
    })
        .then((response) => response.json())
        .then((json) => {
            if (json.errors) {
                alert(`Render Markdown failed: ${JSON.stringify(json.errors, null, 2)}`);
                return;
            }

            return json.html;
        });
};

window.renderMarkdown = renderMarkdown;
