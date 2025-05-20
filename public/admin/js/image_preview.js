function previewImage(event) {
    const input = event.target;
    const currentImage = document.getElementById('currentImage');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            currentImage.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
