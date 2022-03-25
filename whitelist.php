<?php
    if (!isset($_POST["email"]) || !isset($_POST["eth"])) {
            die('missing args');
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die('bad email');
    }

    $eth_pattern = "/^0x[a-fA-F0-9]{40}$/";
    if (preg_match_all($eth_pattern, $_POST["eth"]) <= 0) {
            die('bad addr');
    }

    try{
            $conn = new PDO("mysql:host=localhost;dbname=backroom", "root", "root");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {

            die('cant connect to db');
    }

    $email = $_POST["email"];
    $eth = $_POST["eth"];
    $twitter = $_POST["twitter"];

    $sql = "INSERT INTO whitelist (email, eth, twitter) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $eth, $twitter]);
?>
