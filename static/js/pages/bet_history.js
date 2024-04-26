function setTitle() {
    const urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('title');

    if (id == "p_bet") {
        document.getElementById("p-title").innerHTML = "Pending Bets";
    } else if (id == "w_bet") {
        document.getElementById("p-title").innerHTML = "Winning Bets";
    } else if (id == "c_bets") {
        document.getElementById("p-title").innerHTML = "Cancelled Bets";
    } else if (id == "bet") {
        document.getElementById("p-title").innerHTML = "Deposits";
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setTitle();
});

