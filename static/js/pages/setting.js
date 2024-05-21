
function submitForm(event) {
    console.log('Submitting form');
    event.preventDefault(); // Prevent default form submission
    // Initialize an empty map to store key-value pairs
    var formDataMap = {};

    // Get all form elements by their ids and add their values to the map
    formDataMap['WITHDRAW_OPEN_TIME'] = document.getElementById('w-open-time').value;
    formDataMap['WITHDRAW_CLOSE_TIME'] = document.getElementById('w-close-time').value;
    formDataMap['BANK_DETAILS'] = document.getElementById('bank-details').value;
    formDataMap['UPI_ID'] = document.getElementById('upi-id').value;
    formDataMap['MERCHANT'] = document.getElementById('mmc').value;
    formDataMap['MIN_DEPOSIT'] = document.getElementById('min-dep').value;
    formDataMap['MIN_WITHDRAW'] = document.getElementById('min-with').value;
    formDataMap['WHATSAPP'] = document.getElementById('whatsapp').value;
    formDataMap['REFERRAL_BONUS_PERCENT'] = document.getElementById('commission').value;
    formDataMap['UPI_GATEWAY_KEY'] = document.getElementById('upi-gw-key').value;

    console.log(formDataMap);


    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/api/update_settings', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function () {
        if (xhr.status === 200) {
            swal('Success', 'Settings updated successfully', 'success').then(function() {
                window.location.reload();
            });

        } else {
            swal('Error', 'Settings update failed', 'error');
        }
    };
    xhr.onerror = function () {
        swal('Error', 'Settings update failed', 'error');
    };
    xhr.send(JSON.stringify(formDataMap));
}


document.addEventListener('DOMContentLoaded', function() {
    console.log('Setting form submit listener added');
    document.querySelector('.forms-sample').addEventListener('submit', submitForm);
});

