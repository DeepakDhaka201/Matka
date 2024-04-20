function fetchBets(pageNumber) {
    $.ajax({
        url: '/admin_get_bets',
        method: 'GET',
        data: {
            page: pageNumber
        },
        success: function(response) {
            console.log('Bets:', response.bets);
            console.log('Total Bets:', response.total_bets);
            displayBets(response.bets);
            dataTable();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function displayBets(bets) {
    $('#bets-list').empty();
    bets.forEach(function(bet, index) {
        $('#bets-list').append(`
            <tr>
                <td>${index + 1}</td>
                <td onclick="openBetDetails()" style="cursor:pointer;">${bet.market_id}</td>
                <td onclick="openBetDetails()" style="cursor:pointer;">${bet.user_id}</td>
                <td onclick="openBetDetails()" style="cursor:pointer;">${bet.transaction_id}</td>
                <td>${bet.bet_number}</td>
                <td>${bet.bet_amount}</td>
                <td>${bet.bet_type}</td>
                <td>${new Date(bet.created_at).toLocaleString()}</td>
                <td>
    <button class="toggle-status-btn btn button ${bet.status === 'CANCELLED' ? 'btn-outline-danger' : 'btn-outline-warning'}" data-bet-id="${bet.id}">
        ${bet.status === 'CANCELLED' ? 'Cancelled' : 'Pending'}
    </button>
</td>

<td>
    <button class="toggle-settle-btn btn button ${bet.settled === true ? 'btn-outline-success' : 'btn-outline-danger'}" data-bet-id="${bet.id}">
        ${bet.settled === true ? 'Approved' : 'Rejected'}
    </button>
</td>

            </tr>
        `);
    });
}

fetchBets(1);


$(document).on('click', '.toggle-settle-btn', function() {
    var betId = $(this).data('bet-id');
    var toggleValue = $(this).hasClass('btn-outline-success') ? false : true;
    var button = $(this);
    $.ajax({
        url: `/admin_cancel_bet_id?bet_id=${betId}&toggle_value=${toggleValue}`,
        method: 'POST',
        success: function(response) {
          console.log(response)
            
            if (response.message.includes('Settled')) {
                button.removeClass('btn-outline-danger').addClass('btn-outline-success').text('Approved');
            }
  
            if (response.message.includes('unSettled')) {
                button.removeClass('btn-outline-success').addClass('btn-outline-danger').text('Rejected');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
  });
  
  
  $(document).on('click', '.toggle-status-btn', function() {
      var betId = $(this).data('bet-id');
    //   var toggleValue = $(this).hasClass('btn-outline-danger') ? 'CANCELLED' : 'PENDING';
      var button = $(this);
      $.ajax({
          url: `/admin_cancel_bet_id?bet_id=${betId}`,
          method: 'POST',
          success: function(response) {
            console.log(response)
              
              if (response.message.includes('cancelled')) {
                  button.removeClass('btn-outline-warning').addClass('btn-outline-danger').text('Cancelled');
              }
    
              else {
                  button.removeClass('btn-outline-danger').addClass('btn-outline-warning').text('Pending');
              }
          },
          error: function(xhr, status, error) {
              console.error('Error:', error);
          }
      });
  });
  