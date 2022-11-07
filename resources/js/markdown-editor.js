/**
 * Handle image paste & drop.
 *
 * @param {HTMLTextAreaElement} textarea
 */
function setupPasteAndDropImage(textarea) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    textarea.addEventListener('dragover', (event) => {
        event.stopPropagation();
        event.preventDefault();
        // Style the drag-and-drop as a "copy file" operation.
        event.dataTransfer.dropEffect = 'copy';
    });

    textarea.addEventListener('drop', (event) => {
        event.stopPropagation();
        event.preventDefault();
        const fileList = event.dataTransfer.files;
        const images = [...fileList].filter((item) => item.type.startsWith('image/'));
        handle_upload(event.target, images);
    });

    textarea.addEventListener('paste', (event) => {
        const clipboardItems = event.clipboardData.items;
        const images = [...clipboardItems]
            .filter((item) => item.type.startsWith('image/'))
            .map((item) => item.getAsFile());

        if (!images.length) return;

        event.preventDefault();
        handle_upload(event.target, images);
    });

    function handle_upload(textarea, images) {
        images.forEach((image) => {
            const placeholder = `![Uploading ${image.name}…]()`;
            textarea.setRangeText(placeholder + "\n");

            const formData = new FormData();
            formData.append('image', image);
            fetch('/upload/image', {
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
                        alert(`Upload failed: ${JSON.stringify(json.errors, null, 2)}`);
                        return;
                    }

                    textarea.value =
                        textarea.value.replace(placeholder, `![${image.name}](${json.location})`);
                });
        });
    }
}

export {setupPasteAndDropImage};
