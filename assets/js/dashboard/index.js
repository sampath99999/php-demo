$(document).ready(function () {
    let userId = window.localStorage.getItem("user_id");
    if (!userId) {
        window.location.replace("./../login.html");
    }
    $.ajax({
        method: "GET",
        url: "./api/getUser.php?user_id=" + userId,
        success: (response) => {
            response = JSON.parse(response);
            if (response.status) {
                $("#name").text(response.data.username);
            } else {
                window.localStorage.removeItem("user_id");
            }
        },
        error: (response) => {},
    });
});
