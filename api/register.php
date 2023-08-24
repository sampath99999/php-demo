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

    if ($username == '' || $password == '') {
        echo "Username & Password shouldn't be empty";
        exit;
    }

    $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=login_register;user=postgres;password=postgres");
    if (!$pdo) {
        echo "Database Not Connected!";
        exit;
    }

    $query = "INSERT INTO users (username, password, created_at, updated_at) VALUES (?, ?, now(), now())";

    $statment = $pdo->prepare($query);
    $result = $statment->execute([$username, $password]);

    echo $result;
    return;
}
echo "Only POST request is accepted!";
