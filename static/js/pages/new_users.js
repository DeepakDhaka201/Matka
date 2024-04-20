function fetchUsers(pageNumber) {
    $.ajax({
        url: '/admin_get_users?fetch_new=true',
        method: 'GET',
        data: {
            page: pageNumber
        },
        success: function(response) {
            console.log('Users:', response.users);
            console.log('Total users:', response.total_users);
            displayUsers(response.users);
            dataTable();
                    
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function displayUsers(users) {
    $('#users-list').empty();
    users.forEach(function(user, index) {
        $('#users-list').append(`
            <tr>
                <td>${index + 1}</td>
                <td onclick="openUserDetails()" style="cursor:pointer;">${user.name}</td>
                <td onclick="openUserDetails()" style="cursor:pointer;">${user.phone}</td>
                <td onclick="openUserDetails()" style="cursor:pointer;">${user.email}</td>
                <td>${user.password}</td>
                <td>${user.total_balance + user.winning_balance + user.bonus_balance}</td>
                <td>${user.deposit_balance}</td>
                <td>${user.winning_balance}</td>
                <td>${user.bonus_balance}</td>
                <td>${new Date(user.created_at).toLocaleString()}</td>
                <td><a href="all_bets.php?mobile=${user.mobile}"><button class="btn btn-outline-info">View bets</button></a></td>
                <td><a href="all_bets.php?mobile=${user.mobile}"><button class="btn btn-outline-info">View Transactions</button></a></td>
                <td>
    <button id='btn-ad' class="toggle-status-btn btn button ${user.active === true ? 'btn-outline-success' : 'btn-outline-warning'}" data-user-id="${user.id}">
        ${user.active === true ? 'Active' : 'Inactive'}
    </button>
</td>
            </tr>
        `);
    });
}

fetchUsers(1);

$(document).on('click', '.toggle-status-btn', function() {
  var userId = $(this).data('user-id');
  var toggleValue = $(this).hasClass('btn-outline-success') ? false : true;
  var button = $(this);
  $.ajax({
      url: `/admin_toggle_user_activation?user_id=${userId}&toggle_value=${toggleValue}`,
      method: 'POST',
      success: function(response) {
        console.log(response)
          
          if (response.message.includes('activated')) {
              button.removeClass('btn-outline-warning').addClass('btn-outline-success').text('Active');
          }

          if (response.message.includes('deactivated')) {
              button.removeClass('btn-outline-success').addClass('btn-outline-warning').text('Inactive');
          }
      },
      error: function(xhr, status, error) {
          console.error('Error:', error);
      }
  });
});
