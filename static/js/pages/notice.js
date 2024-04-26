function submitForm(event) {
    event.preventDefault();

    var id = document.getElementById('s-id').value;
    var notice = document.getElementById('editor').value;

    fetch('/admin/api/update_setting', {
        method: 'POST',
        body: JSON.stringify({
            id: id,
            value: notice
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(function(response) {
        if (response.ok) {
            console.log('Setting updated');
        } else {
            console.log('Setting update failed');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.forms-sample').addEventListener('submit', submitForm);
});


