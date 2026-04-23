/**
 * WebP Converter - Global Helper
 * Converts image files to WebP format client-side before upload.
 *
 * HOW IT WORKS:
 * 1. On form submit, all image file inputs are intercepted.
 * 2. Each image is drawn to a canvas and exported as image/webp blob.
 * 3. The blob is wrapped in a new File with .webp extension and type image/webp.
 * 4. The original input.files is replaced with the converted files via DataTransfer.
 * 5. The form is then submitted normally — server receives only WebP files.
 *
 * Inputs with data-skip-webp="true" are skipped (e.g. banner inputs that accept video).
 */

window.WebPConverter = (function () {
    var QUALITY = 0.78;

    // ─── Core conversion ────────────────────────────────────────────────────────

    /**
     * Convert a File to a WebP Blob via canvas.
     * Non-image files (video, etc.) are resolved as-is.
     * @param {File} file
     * @returns {Promise<Blob>}
     */
    function convertToWebP(file) {
        return new Promise(function (resolve, reject) {
            if (!file.type.startsWith('image/')) {
                resolve(file);
                return;
            }

            var reader = new FileReader();
            reader.onerror = function () { reject(new Error('FileReader error')); };
            reader.onload = function (e) {
                var img = new Image();
                img.onerror = function () { reject(new Error('Image load error')); };
                img.onload = function () {
                    var canvas = document.createElement('canvas');
                    canvas.width  = img.naturalWidth;
                    canvas.height = img.naturalHeight;
                    canvas.getContext('2d').drawImage(img, 0, 0);
                    canvas.toBlob(function (blob) {
                        if (!blob) { reject(new Error('canvas.toBlob returned null')); return; }
                        resolve(blob);
                    }, 'image/webp', QUALITY);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    /**
     * Convert a File to a new File with .webp extension and image/webp MIME type.
     * @param {File} file
     * @returns {Promise<File>}
     */
    function convertFileToWebP(file) {
        if (!file.type.startsWith('image/')) {
            return Promise.resolve(file);
        }
        return convertToWebP(file).then(function (blob) {
            var baseName = file.name.replace(/\.[^/.]+$/, '');
            return new File([blob], baseName + '.webp', { type: 'image/webp' });
        });
    }

    // ─── Form interception ───────────────────────────────────────────────────────

    /**
     * Attach WebP conversion to a form's submit event.
     * On submit:
     *   1. Prevent default.
     *   2. Convert all eligible image inputs to WebP.
     *   3. Replace input.files with converted files.
     *   4. Call form.submit() (native, bypasses our listener).
     *
     * @param {HTMLFormElement} form
     */
    function interceptForm(form) {
        if (form.dataset.webpIntercepted === 'true') return;
        form.dataset.webpIntercepted = 'true';

        form.addEventListener('submit', function handleSubmit(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var submitBtn = form.querySelector('[type="submit"]');
            var originalText = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>Converting to WebP…</span>';
            }

            var fileInputs = Array.from(form.querySelectorAll('input[type="file"]'));

            var conversions = fileInputs.map(function (input) {
                // Skip inputs explicitly marked (e.g. banner that accepts video)
                if (input.dataset.skipWebp === 'true') return Promise.resolve();

                var files = Array.from(input.files);
                if (!files.length) return Promise.resolve();

                return Promise.all(files.map(convertFileToWebP)).then(function (webpFiles) {
                    var dt = new DataTransfer();
                    webpFiles.forEach(function (f) { dt.items.add(f); });
                    input.files = dt.files;

                    // Debug: log what will be sent
                    webpFiles.forEach(function (f) {
                        console.log('[WebPConverter] Ready to upload:', f.name, f.type, (f.size / 1024).toFixed(1) + ' KB');
                    });
                });
            });

            Promise.all(conversions)
                .then(function () {
                    // Remove our listener so form.submit() doesn't re-trigger it
                    form.removeEventListener('submit', handleSubmit);
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                    form.submit(); // native submit — no event fired
                })
                .catch(function (err) {
                    console.error('[WebPConverter] Conversion failed, submitting original:', err);
                    form.removeEventListener('submit', handleSubmit);
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                    form.submit();
                });
        });
    }

    // ─── Preview helper ──────────────────────────────────────────────────────────

    /**
     * Bind a WebP preview to a single-image input.
     * @param {HTMLInputElement} input
     * @param {HTMLImageElement} imgEl
     */
    function bindSinglePreview(input, imgEl) {
        input.addEventListener('change', function () {
            var file = input.files[0];
            if (!file || !file.type.startsWith('image/')) return;
            convertToWebP(file).then(function (blob) {
                imgEl.src = URL.createObjectURL(blob);
                imgEl.style.display = 'block';
            });
        });
    }

    // ─── Auto-init ───────────────────────────────────────────────────────────────

    function init() {
        document.querySelectorAll('form[enctype="multipart/form-data"]').forEach(interceptForm);
    }

    // ─── Public API ──────────────────────────────────────────────────────────────
    return {
        init               : init,
        convertToWebP      : convertToWebP,
        convertFileToWebP  : convertFileToWebP,
        bindSinglePreview  : bindSinglePreview,
        interceptForm      : interceptForm,
    };
})();

document.addEventListener('DOMContentLoaded', function () {
    WebPConverter.init();
});
