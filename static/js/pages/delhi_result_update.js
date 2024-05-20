function populateDate() {
    var currentDate = new Date();

    // Extract year, month, and day
    var year = currentDate.getFullYear();
    var month = ("0" + (currentDate.getMonth() + 1)).slice(-2); // Adding 1 because months are zero-based
    var day = ("0" + currentDate.getDate()).slice(-2);
    var formattedDate = day + "/" + month + "/" + year;

    var inputs = document.querySelectorAll('.date');

    inputs.forEach(function(input) {
        input.value = formattedDate;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    populateDate();
});


function maxLengthCheck(object) {
    if (object.value.length > object.max.length)
      object.value = object.value.slice(0, object.max.length)
}

function isNumeric (evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode (key);
    var regex = /[0-9]|\./;
    if ( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
}



function submitForm(event) {

        if (!confirm('Are you sure you want to update this result?')) {
            return;
        }

        if (event.target.classList.contains('update-form')) {
            event.preventDefault();
            const formData = new FormData(event.target);

            const market_id = formData.get('market_id');
            const market_name = formData.get('market');
            const date = formData.get('date');
            const open_harf = formData.get('opanna');
            const jodi = formData.get('jodi');
            const close_harf = formData.get('cpanna');

            $.ajax({
                url: '/admin/api/delhi_result_update',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    market_id,
                    market_name,
                    date,
                    open_harf,
                    jodi,
                    close_harf
                }),
                success: function(response) {
                    console.log(response);
                    swal("Result Updated", "Result has been updated successfully", "success").then(() => {
                        window.location.href = `/admin/delhi_result_update`
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    swal("Error", "Error updating result", "error");
                }
            });
        }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.forms-sample')
    .forEach(function(form) {
        form.addEventListener('submit', submitForm)
    })
});

function revertResult(result_id) {
  if (!confirm('Are you sure you want to revert this result?')) {
    return;
  }

  fetch('/admin/api/delhi_revert_result', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ result_id: result_id})
  })
  .then(response => response.json())
  .then(data => {
    console.log(data);
    window.location = '/admin/delhi_result_history';
    alert('Result reverted successfully');
  }).catch(error => {
    console.log('Error:', error);
    alert('Error reverting result');
  });
}



