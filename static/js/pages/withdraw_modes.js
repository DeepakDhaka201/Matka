function updateMode(id, active, name, hint_message) {
    if (!confirm('Are you sure you want to delete this mode?')) {
        return;
    }
    var url = '/admin/api/update_withdraw_mode?id=' + id'

    if active == 1 {
        url += '&active=YES';
    } else if active == 0 {
        url += '&active=NO';
    }

    if name != '' {
        url += '&name=' + name;
    }

    if hint_message != '' {
        url += '&hint_message=' + hint_message;
    }

    $.ajax({
        url: url
        type: 'POST',
        success: function(result) {
            window.location.reload();
        }
    });
}


function activeMode(id, active) {
    updateMode(id, active, '', '');
}

function submitForm(event) {
    event.preventDefault();
    var id = document.getElementById('m-id').value;
    var name = document.getElementById('m-name').value;
    var hint_message = document.getElementById('m-hint').value;

    updateMode(id, 1, name, hint_message);
}

document.querySelector('.forms-sample').addEventListener('submit', submitForm);
