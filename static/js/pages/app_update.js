function submitForm(event) {
    event.preventDefault(); // Prevent default form submission

    // Get the selected image file
    var version = document.getElementById('version').value;
    var link = document.getElementById('link').value;
    var log = document.getElementById('log').value;

    fetch('/admin/api/add_app_update', {
        method: 'POST',
        body: JSON.stringify({
            version: version,
            link: link,
            log: log
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(function(response) {
        if (response.ok) {
            console.log('App Update Pushed');
            window.location = '/admin/app_updates';
        } else {
            console.log('App Update Push failed');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.forms-sample').addEventListener('submit', submitForm);
});


function deleteAppUpdate(id) {
        fetch('/admin/api/delete_app_update?id=' + id, {
        method: 'POST',
        body: JSON.stringify({
            id: id
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(function(response) {
        if (response.ok) {
            console.log('App Update Deleted');
            window.location = '/admin/app_updates';
        } else {
            console.log('App Update Deleted');
            window.location = '/admin/app_updates';
        }
    });
}
