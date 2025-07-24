<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?error=Please login first");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $file = $_FILES['profile_pic'];
    $filename = time() . '_' . basename($file['name']);
    $upload_dir = '../uploads/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $target = $upload_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $target)) {
        // Save filename in DB
        $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
        $stmt->bind_param("si", $filename, $_SESSION['user_id']);
        $stmt->execute();

        $_SESSION['profile_picture'] = $filename;
        header("Location: ../pages/dashboard.php");
        exit;
    } else {
        header("Location: ../pages/dashboard.php?error=Upload failed");
        exit;
    }
} else {
    header("Location: ../pages/dashboard.php");
    exit;
}
?>