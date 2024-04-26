function setTitle() {
    console.log("Setting title");
    const urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('title');
    console.log(id);

    if (id == "w_com") {
        document.getElementById("p-title").innerHTML = "Successful Withdrawals";
    } else if (id == "w_pen") {
        document.getElementById("p-title").innerHTML = "Pending Withdrawals";
    } else if (id == "w_can") {
        document.getElementById("p-title").innerHTML = "Cancelled Withdrawals";
    } else if (id == "d_com") {
        document.getElementById("p-title").innerHTML = "Successful Deposits";
    } else if (id == "d_pen") {
        document.getElementById("p-title").innerHTML = "Pending Deposits";
    } else if (id == "w") {
        document.getElementById("p-title").innerHTML = "Withdrawals";
    } else if (id == "d") {
        document.getElementById("p-title").innerHTML = "Deposits";
    } else if (id == "b") {
        document.getElementById("p-title").innerHTML = "Bonus Transactions";
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setTitle();
});

function markDepositAsCompleted(id) {
    if (!confirm('Are you sure you want to mark this deposit as completed?')) {
        return;
    }

    $.ajax({
        url: '/admin/api/update_transaction',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id: id, status: 'SUCCESS'}),
        success: function(response) {
            console.log(response);
            window.location.reload();
            alert('Deposit marked as completed');
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Error marking deposit as completed');
        }
    });
}

function markWithdrawalAsCompleted(id) {
    if (!confirm('Are you sure you want to mark this withdrawal as completed?')) {
        return;
    }

    $.ajax({
        url: '/admin/api/update_transaction',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id: id, status: 'SUCCESS' }),
        success: function(response) {
            console.log(response);
            window.location.reload();
            alert('Withdrawal marked as completed');
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Error marking withdrawal as completed');
        }
    });
}

function markDepositAsCancelled(id) {
    if (!confirm('Are you sure you want to mark this deposit as cancelled?')) {
        return;
    }

    $.ajax({
        url: '/admin/api/update_transaction',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id: id, status: 'CANCELLED'}),
        success: function(response) {
            console.log(response);
            window.location.reload();
            alert('Deposit marked as cancelled');
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Error marking deposit as cancelled');
        }
    });
}

function markWithdrawalAsCancelled(id) {
    if (!confirm('Are you sure you want to mark this withdrawal as cancelled?')) {
        return;
    }

    swal("Enter reason:", {
        content: "input",
    }).then((value) => {
        $.ajax({
            url: '/admin/api/update_transaction',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ id: id, status: 'CANCELLED', remark: value }),
            success: function(response) {
                console.log(response);
                window.location.reload();
                alert('Withdrawal marked as cancelled');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error marking withdrawal as cancelled');
            }
        });
    });
}

function markWithdrawalAsCancelledAndRefund(id) {
    if (!confirm('Are you sure you want to mark this withdrawal as cancelled and refund the amount?')) {
        return;
    }

    swal("Enter reason:", {
        content: "input",
    }).then((value) => {
        $.ajax({
            url: '/admin/api/update_transaction',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ id: id, status: 'CANCELLED', refund: true, remark: value}),
            success: function(response) {
                console.log(response);
                window.location.reload();
                alert('Withdrawal marked as cancelled and refunded');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error marking withdrawal as cancelled and refunded');
            }
        });
    });
}
