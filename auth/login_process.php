<?php
session_start();
include '../includes/config.php'; // Your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT id, name, email, password, profile_picture FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['profile_picture'] = $user['profile_picture'];

            header("Location: ../pages/dashboard.php");
            exit;
        } else {
            header("Location: login.php?error=Invalid+email+or+password");
            exit;
        }
    } else {
        header("Location: login.php?error=Invalid+email+or+password");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>