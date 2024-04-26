 // Function to handle form submission
 document.getElementById("marketForm").addEventListener("submit", function(event) {
    event.preventDefault();

    // Get form data
    const urlParams = new URLSearchParams(window.location.search);

    var id = urlParams.get('id');
    var name = document.getElementById("marketName").value;
    var openTime = document.getElementById("openTime").value;
    var closeTime = document.getElementById("closeTime").value;
    var resultTime = document.getElementById("resultTime").value;

    $.ajax({
        url: `/admin/api/add_update_market?market_id=${id}&name=${name}&open_time=${openTime}&close_time=${closeTime}&result_time=${resultTime}`,
        method: 'POST',
        success: function(response) {
            console.log(response);
            swal("Market Updated", "Market has been updated successfully", "success").then(() => {
                window.location.href = `/admin/markets`
            });
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Error updating market');
        }
    });
});
