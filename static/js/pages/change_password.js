function submitForm(event) {
    event.preventDefault();
    var old_password = document.getElementById('old-pass').value;
    var new_password = document.getElementById('new-pass').value;

    var url = '/admin/api/change_password';
    var data = {
        old_password: old_password,
        new_password: new_password
    };

    fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(function(response) {
        if (response.ok) {
            swal({
                title: "Password updated",
                text: "Your password has been updated successfully!",
                icon: "success",
                button: "OK",
            }).then(function() {
                window.location.reload();
            });
        } else {
            swal({
                title: "Password update failed",
                text: "Your password could not be updated. Please try again.",
                icon: "error",
                button: "OK",
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.forms-sample').addEventListener('submit', submitForm);
});
