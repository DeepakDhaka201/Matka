function deleteSliderImage(url) {
    fetch('/admin/api/delete_image_slider?url=' + url, {
        method: 'POST'
    }).then(function (response) {
        console.log(response);
        if (response.ok) {
            console.log('Image deleted');
            swal('Success', 'Image deleted successfully', 'success').then(function () {
                window.location.reload();
            });
        } else {
            throw new Error('Error deleting image');
        }
    }).catch(function (error) {
        swal('Error', error.message, 'error');
    });
}


function submitForm(event) {
    event.preventDefault(); // Prevent default form submission

    // Get the selected image file
    var fileInput = document.getElementById('fileToUpload');
    var imageFile = fileInput.files[0];

    // Create a FormData object to store the file
    var formData = new FormData();
    formData.append('image', imageFile);

    // Make an AJAX request to upload the image
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/api/add_image_slider', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Image uploaded successfully
            swal('Success', 'Image uploaded successfully', 'success').then(function () {
                window.location.href = '/admin/image_slider';
            });
        } else {
            // Error uploading image
            swal('Error', 'Error uploading image. Please try again later.', 'error');
        }
    };
    xhr.onerror = function () {
        // Error occurred during AJAX request
        swal('Error', 'Error uploading image. Please try again later.', 'error');
    };
    xhr.send(formData);
}

document.addEventListener('DOMContentLoaded', function () {
    var ele = document.getElementById('slider-image-form');
    if (ele) {
        ele.addEventListener('submit', submitForm);
    }
});

