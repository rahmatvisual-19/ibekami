// main.js
let currentFiles = [];
const inputElement = document.getElementById("gambar_produk");
const previewContainer = document.getElementById("previewContainer");
const remainingImagesInput = document.getElementById("remainingImages");
let remainingImages = remainingImagesInput
    ? JSON.parse(remainingImagesInput.value)
    : [];

inputElement.addEventListener("change", function (event) {
    const newFiles = Array.from(event.target.files);
    currentFiles = [...currentFiles, ...newFiles];
    updateFileInput();
    createPreviews(newFiles);
});

function removePreview(previewDiv, file) {
    currentFiles = currentFiles.filter((f) => f !== file);
    updateFileInput();
    previewDiv.remove();

    if (remainingImagesInput) {
        const imgSrc = previewDiv.querySelector("img").src;
        const filename = imgSrc.split("/").pop();
        remainingImages = remainingImages.filter((img) => img !== filename);
        remainingImagesInput.value = JSON.stringify(remainingImages);
    }
}

function createPreviews(files) {
    files.forEach((file) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const previewDiv = document.createElement("div");
            previewDiv.className = "preview-box";

            const img = document.createElement("img");
            img.src = e.target.result;
            img.className = "preview-image";

            const removeBtn = document.createElement("button");
            removeBtn.innerHTML = "×";
            removeBtn.className = "remove-btn";
            removeBtn.onclick = () => removePreview(previewDiv, file);

            previewDiv.appendChild(img);
            previewDiv.appendChild(removeBtn);
            previewContainer.appendChild(previewDiv);
        };
        reader.readAsDataURL(file);
    });
}

function updateFileInput() {
    const dataTransfer = new DataTransfer();
    currentFiles.forEach((file) => dataTransfer.items.add(file));
    inputElement.files = dataTransfer.files;
}

if (remainingImages.length > 0) {
    remainingImages.forEach((filename) => {
        const previewDiv = document.createElement("div");
        previewDiv.className = "preview-box";

        const img = document.createElement("img");
        img.src = `/storage/gambar_produk/${filename}`; // Adjust path as needed
        img.className = "preview-image";

        const removeBtn = document.createElement("button");
        removeBtn.innerHTML = "×";
        removeBtn.className = "remove-btn";
        removeBtn.onclick = () => {
            remainingImages = remainingImages.filter((img) => img !== filename);
            remainingImagesInput.value = JSON.stringify(remainingImages);
            previewDiv.remove();
        };

        previewDiv.appendChild(img);
        previewDiv.appendChild(removeBtn);
        previewContainer.appendChild(previewDiv);
    });
}

class ProductDetailsManager {
    constructor() {
        this.detailsContainer = document.getElementById("detailsContainer");
        this.addDetailBtn = document.getElementById("addDetailBtn");
        this.detailCount = this.detailsContainer
            ? this.detailsContainer.children.length
            : 0;

        if (this.detailsContainer && this.addDetailBtn) {
            this.init();
        }
    }

    init() {
        this.initExistingRemoveButtons();

        this.addDetailBtn.addEventListener("click", () =>
            this.addDetailField()
        );

        this.detailsContainer.addEventListener("click", (e) => {
            if (e.target.closest(".remove-detail")) {
                e.target.closest(".detail-group").remove();
            }
        });
    }

    initExistingRemoveButtons() {
        const removeButtons =
            this.detailsContainer.querySelectorAll(".remove-detail");
        removeButtons.forEach((button) => {
            button.addEventListener("click", (e) => {
                e.target.closest(".detail-group").remove();
            });
        });
    }

    addDetailField(key = "", value = "") {
        const detailId = `detail_${this.detailCount++}`;
        const fieldGroup = document.createElement("div");
        fieldGroup.className = "detail-group input-group mb-2";
        fieldGroup.id = detailId;

        const keyInput = this.createInput(
            "text",
            `details[${detailId}][key]`,
            "Detail name (e.g., Color)",
            key
        );

        const valueInput = this.createInput(
            "text",
            `details[${detailId}][value]`,
            "Detail value (e.g., Red)",
            value
        );

        const removeBtn = this.createRemoveButton();

        const inputGroupAppend = document.createElement("div");
        inputGroupAppend.className = "input-group-append";
        inputGroupAppend.appendChild(removeBtn);

        fieldGroup.appendChild(keyInput);
        fieldGroup.appendChild(valueInput);
        fieldGroup.appendChild(inputGroupAppend);
        this.detailsContainer.appendChild(fieldGroup);
    }

    createInput(type, name, placeholder, value) {
        const input = document.createElement("input");
        input.type = type;
        input.name = name;
        input.className = "form-control";
        input.placeholder = placeholder;
        input.value = value;
        input.required = true;
        return input;
    }

    createRemoveButton() {
        const button = document.createElement("button");
        button.type = "button";
        button.className = "btn btn-danger remove-detail";
        button.innerHTML = '<i class="feather icon-trash"></i>';
        return button;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new ProductDetailsManager();
});