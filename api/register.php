<?php

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $response = ["status" => false, "message" => ""];

    if (!isset($_POST["username"])) {
        $response["message"] = "Username is required!";
        echo json_encode($response);
        exit;
    }
    if (!isset($_POST["password"])) {
        $response["message"] = "Password is required!";
        echo json_encode($response);
        exit;
    }

    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    if ($username == '' || $password == '') {
        $response["message"] = "Username & Password shouldn't be empty";
        echo json_encode($response);
        exit;
    }

    $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=login_register;user=postgres;password=postgres");
    if (!$pdo) {
        $response["message"] = "Database Not Connected!";
        echo json_encode($response);
        exit;
    }

    $query = "SELECT id FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) == 1) {
        $response["message"] = "Username already Taken!";
        echo json_encode($response);
        exit;
    }

    $query = "INSERT INTO users (username, password, created_at, updated_at) VALUES (?, ?, now(), now())";

    $statment = $pdo->prepare($query);
    $result = $statment->execute([$username, $password]);

    if (!$result) {
        $response["message"] = $statment->errorInfo();
        echo json_encode($response);
    }

    $response["status"] = true;
    $response["message"] = "Successfully Registered!";
    echo json_encode($response);
    exit;
}

$response["message"] = "ONLY POST method Accepted";
echo json_encode($response);
