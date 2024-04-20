 // Function to handle form submission
 document.getElementById("marketForm").addEventListener("submit", function(event) {
    event.preventDefault();

    // Get form data
    var name = document.getElementById("marketName").value;
    var openTime = document.getElementById("openTime").value;
    var closeTime = document.getElementById("closeTime").value;
    var resultTime = document.getElementById("resultTime").value;

    // Make AJAX request to submit form data
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/admin_add_market", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function() {
        if (xhr.status == 201) {
            // Process success response here
            var response = JSON.parse(xhr.responseText);
            alert(response.message);
        } else {
            // Process error response here
            var errorResponse = JSON.parse(xhr.responseText);
            alert("Error: " + errorResponse.error);
        }
    };

    xhr.onerror = function() {
        // Display error message
        alert("Error: Request failed");
    };

    // Send form data as JSON
    xhr.send(JSON.stringify({ name: name, open_time: openTime, close_time: closeTime, result_time: resultTime }));
});