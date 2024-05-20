function updateRate(id, rate, desc, game_type) {
    var url = '/admin/api/update_rate';
    var data = {
        id: id,
        rate: rate,
        desc: desc,
        game_type: game_type
    };

    fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(function(response) {
        if (response.ok) {
            console.log('Rate updated');
        } else {
            console.log('Rate update failed');
        }
    });
}

function submitForm() {
    event.preventDefault();
    var jodi_id = document.getElementById('jodi-id').value;
    var jodi_rate = document.getElementById('jodi-val').value;
    var jodi_desc = document.getElementById('jodi-desc').value;

    var harf_id = document.getElementById('harf-id').value;
    var harf_rate = document.getElementById('harf-val').value;
    var harf_desc = document.getElementById('harf-desc').value;

    // Create promises for each updateRate call
    var jodiPromise = updateRate(jodi_id, jodi_rate, jodi_desc, "JODI");
    var harfPromise = updateRate(harf_id, harf_rate, harf_desc, "OPEN_HARF");

    // Wait for both promises to resolve
    Promise.all([jodiPromise, harfPromise]).then(function() {
        // Reload the page and show alert after both updateRate calls complete
        window.location.reload();
        alert('Rate updated successfully!');
    }).catch(function(error) {
        // Handle error if any of the updateRate calls fail
        console.error('Error updating rates:', error);
        alert('Failed to update rates. Please try again later.');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.forms-sample').addEventListener('submit', submitForm);
});
