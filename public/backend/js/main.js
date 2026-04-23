// main.js — Product image preview + WebP conversion (multiple files)

let currentFiles = [];
const inputElement = document.getElementById('gambar_produk');
const previewContainer = document.getElementById('previewContainer');
const remainingImagesInput = document.getElementById('remainingImages');
let remainingImages = remainingImagesInput
    ? JSON.parse(remainingImagesInput.value)
    : [];

if (inputElement) {
    inputElement.addEventListener('change', function (event) {
        var newFiles = Array.from(event.target.files);

        // Convert each new file to WebP before adding to currentFiles
        Promise.all(newFiles.map(function (file) {
            return WebPConverter.convertFileToWebP(file);
        })).then(function (webpFiles) {
            currentFiles = currentFiles.concat(webpFiles);
            updateFileInput();
            createPreviews(webpFiles);
        });
    });
}

function removePreview(previewDiv, file) {
    currentFiles = currentFiles.filter(function (f) { return f !== file; });
    updateFileInput();
    previewDiv.remove();

    if (remainingImagesInput) {
        var imgSrc = previewDiv.querySelector('img').src;
        var filename = imgSrc.split('/').pop();
        remainingImages = remainingImages.filter(function (img) { return img !== filename; });
        remainingImagesInput.value = JSON.stringify(remainingImages);
    }
}

function createPreviews(files) {
    files.forEach(function (file) {
        var url = URL.createObjectURL(file);

        var previewDiv = document.createElement('div');
        previewDiv.className = 'preview-box';

        var img = document.createElement('img');
        img.src = url;
        img.className = 'preview-image';

        var removeBtn = document.createElement('button');
        removeBtn.innerHTML = '&times;';
        removeBtn.type = 'button';
        removeBtn.className = 'remove-btn';
        removeBtn.onclick = function () { removePreview(previewDiv, file); };

        previewDiv.appendChild(img);
        previewDiv.appendChild(removeBtn);
        previewContainer.appendChild(previewDiv);
    });
}

function updateFileInput() {
    if (!inputElement) return;
    var dataTransfer = new DataTransfer();
    currentFiles.forEach(function (file) { dataTransfer.items.add(file); });
    inputElement.files = dataTransfer.files;
}

// Render existing images (edit page)
if (remainingImages.length > 0) {
    remainingImages.forEach(function (filename) {
        var previewDiv = document.createElement('div');
        previewDiv.className = 'preview-box';

        var img = document.createElement('img');
        img.src = '/storage/gambar_produk/' + filename;
        img.className = 'preview-image';

        var removeBtn = document.createElement('button');
        removeBtn.innerHTML = '&times;';
        removeBtn.type = 'button';
        removeBtn.className = 'remove-btn';
        removeBtn.onclick = function () {
            remainingImages = remainingImages.filter(function (i) { return i !== filename; });
            remainingImagesInput.value = JSON.stringify(remainingImages);
            previewDiv.remove();
        };

        previewDiv.appendChild(img);
        previewDiv.appendChild(removeBtn);
        if (previewContainer) previewContainer.appendChild(previewDiv);
    });
}

// ─── Product Details Manager ──────────────────────────────────────────────────

class ProductDetailsManager {
    constructor() {
        this.detailsContainer = document.getElementById('detailsContainer');
        this.addDetailBtn = document.getElementById('addDetailBtn');
        this.detailCount = this.detailsContainer
            ? this.detailsContainer.children.length
            : 0;

        if (this.detailsContainer && this.addDetailBtn) {
            this.init();
        }
    }

    init() {
        this.initExistingRemoveButtons();
        this.addDetailBtn.addEventListener('click', () => this.addDetailField());
        this.detailsContainer.addEventListener('click', (e) => {
            if (e.target.closest('.remove-detail')) {
                e.target.closest('.detail-group').remove();
            }
        });
    }

    initExistingRemoveButtons() {
        this.detailsContainer.querySelectorAll('.remove-detail').forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.target.closest('.detail-group').remove();
            });
        });
    }

    addDetailField(key = '', value = '') {
        const detailId = `detail_${this.detailCount++}`;
        const fieldGroup = document.createElement('div');
        fieldGroup.className = 'detail-group input-group mb-2';
        fieldGroup.id = detailId;

        const keyInput = this.createInput('text', `details[${detailId}][key]`, 'Detail name (e.g., Color)', key);
        const valueInput = this.createInput('text', `details[${detailId}][value]`, 'Detail value (e.g., Red)', value);
        const removeBtn = this.createRemoveButton();

        const inputGroupAppend = document.createElement('div');
        inputGroupAppend.className = 'input-group-append';
        inputGroupAppend.appendChild(removeBtn);

        fieldGroup.appendChild(keyInput);
        fieldGroup.appendChild(valueInput);
        fieldGroup.appendChild(inputGroupAppend);
        this.detailsContainer.appendChild(fieldGroup);
    }

    createInput(type, name, placeholder, value) {
        const input = document.createElement('input');
        input.type = type;
        input.name = name;
        input.className = 'form-control';
        input.placeholder = placeholder;
        input.value = value;
        input.required = true;
        return input;
    }

    createRemoveButton() {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'btn btn-danger remove-detail';
        button.innerHTML = '<i class="feather icon-trash"></i>';
        return button;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ProductDetailsManager();
});
