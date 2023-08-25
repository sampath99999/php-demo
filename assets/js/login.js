$(document).ready(function () {
    let userId = window.localStorage.getItem("user_id");
    if (userId) {
        window.location.replace("./dashboard");
    }
});

function login(event) {
    event.preventDefault();

    let username = $("#username").val();
    let password = $("#password").val();

    $("#usernameError").text("");
    $("#passwordError").text("");

    if (username.length < 3 || username.length > 25) {
        $("#usernameError").text(
            "Username should be at least 3 Characters and at most 25 Characters"
        );
        return false;
    }

    if (password.length < 3 || password.length > 25) {
        $("#passwordError").text(
            "Password should be at least 3 Characters and at most 25 Characters"
        );
        return false;
    }

    $.ajax({
        method: "POST",
        url: "./api/login.php",
        data: {
            username,
            password,
        },
        success: function (data) {
            data = JSON.parse(data);
            if (data.status) {
                window.localStorage.setItem("user_id", data.data);
                window.location.replace("./dashboard");
            } else {
                $("#usernameError").text(data.message);
            }
        },
        error: function (error) {},
    });
}
