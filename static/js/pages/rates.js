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

    updateRate(jodi_id, jodi_rate, jodi_desc, "JODI");
    updateRate(harf_id, harf_rate, harf_desc, "OPEN_HARF");

    alert('Rate updated successfully!');
    window.location.reload();
}

// document.addEventListener('DOMContentLoaded', function() {
//     document.querySelector('.forms-sample').addEventListener('submit', submitForm);
// });
