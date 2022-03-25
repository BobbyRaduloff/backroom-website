<?php
    if (!isset($_POST["email"]) || !isset($_POST["eth"])) {
            echo 'Please fill out the form!';
            exit(400);
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email!';
            exit(400);
    }

    $eth_pattern = "/^0x[a-fA-F0-9]{40}$/";
    if (preg_match_all($eth_pattern, $_POST["eth"]) <= 0) {
            echo 'Invalid Polygon address!';
            exit(400);
    }

    try{
            $conn = new PDO("mysql:host=localhost;dbname=backroom", "root", "root");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {
        echo 'Something went wrong... Please try again later.';
        exit(400);
    }

    $email = $_POST["email"];
    $eth = $_POST["eth"];
    $twitter = $_POST["twitter"];

    $sql = "INSERT INTO whitelist (email, eth, twitter) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if(!$stmt->execute([$email, $eth, $twitter])) {
        echo 'You can only register for the whitelist once.';
        exit(400);
    }
?>
