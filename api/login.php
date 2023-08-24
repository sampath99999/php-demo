<?php

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (!isset($_POST["username"])) {
        echo "Username is required!";
        exit;
    }
    if (!isset($_POST["password"])) {
        echo "Password is required!";
        exit;
    }

    $username = $_POST["username"];
    $password = $_POST["password"];
    $response = ["status" => true, "message" => ""];

    if ($username == '' || $password == '') {
        $response["status"] = false;
        $response["message"] = "Username & Password shouldn't be empty";
        echo json_encode($response);
        exit;
    }

    $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=login_register;user=postgres;password=postgres");
    if (!$pdo) {
        $response["status"] = false;
        $response["message"] = "Database Not Connected!";
        echo json_encode($response);
        exit;
    }

    $query = "SELECT * FROM users WHERE username = ? AND password = ?";

    $statment = $pdo->prepare($query);
    $statment->execute([$username, $password]);
    $user = $statment->fetchAll(PDO::FETCH_ASSOC);
    if (count($user) == 1) {
        $response["message"] = "LoggedIn Successfully!";
        echo json_encode($response);
        exit;
    } else {
        $response["status"] = false;
        $response["message"] = "Username & Password shouldn't be empty";
        echo json_encode($response);
        exit;
        
    }
}
echo "Only POST request is accepted!";
