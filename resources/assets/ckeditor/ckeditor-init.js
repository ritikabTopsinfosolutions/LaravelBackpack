// ckeditor-init.js
document.addEventListener("DOMContentLoaded", function () {
    // Initialize CKEditor on all textareas with the class 'ckeditor'
    const editorElements = document.querySelectorAll('.ckeditor');
    editorElements.forEach(element => {
        CKEDITOR.replace(element);
    });
});
