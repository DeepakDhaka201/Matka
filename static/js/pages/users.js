function updateUser(userId, active) {
    $.ajax({
        url: `/admin/update_user?user_id=${userId}&active=${active}`,
        method: 'POST',
        success: function(response) {
            console.log(response);
            swal('Success', 'User updated successfully', 'success').then(function() {
                window.location.reload();
            });
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            swal('Error', 'Error updating user', 'error');
        }
    });
}

//function updateUserBalance() {
//    const urlParams = new URLSearchParams(window.location.search);
//
//    var userId = urlParams.get('user_id');
//    var amount = $('#mb-input-amount').val();
//    var walletType = $('#mb-input-wallet').val();
//    var remark = $('#mb-input-remark').val();
//    var action = $('#mb-input-action').val();
//
//    if (action === 1) {
//        action = 'Deduct';
//    } else {
//        action = 'Add';
//    }
//
//    console.log(userId, amount, walletType, action);
//
//    $.ajax({
//        url: `/admin/update_user_balance?user_id=${userId}&amount=${amount}&wallet_type=${walletType}&action=${action}&remark=${remark}`,
//        method: 'POST',
//        success: function(response) {
//            console.log(response);
//            swal('Success', 'User balance updated successfully', 'success').then(function() {
//                window.location.reload();
//            });
//        },
//        error: function(xhr, status, error) {
//            console.error('Error:', error);
//            swal('Error', 'Error updating user balance', 'error');
//        }
//    });
//}
//
//# convert above function to use XMLHttpRequest

function updateUserBalance() {
    const urlParams = new URLSearchParams(window.location.search);

    var userId = urlParams.get('user_id');
    var amount = $('#mb-input-amount').val();
    var walletType = $('#mb-input-wallet').val();
    var remark = $('#mb-input-remark').val();
    var action = $('#mb-input-action').val();

    if (action === 1) {
        action = 'Deduct';
    } else {
        action = 'Add';
    }

    console.log(userId, amount, walletType, action);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", `/admin/update_user_balance?user_id=${userId}&amount=${amount}&wallet_type=${walletType}&action=${action}&remark=${remark}`, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            swal('Success', 'User balance updated successfully', 'success').then(function() {
                window.location.reload();
            });
        } else {
            console.error('Error:', xhr.responseText);
            swal('Error', 'Error updating user balance', 'error');
        }
    }
    xhr.send();
}
