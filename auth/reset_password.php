<?php include '../includes/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-lg">

<?php
if (!isset($_GET['token'])) {
    echo "<p class='text-red-600'>Invalid token.</p>";
    exit;
}

$token = $_GET['token'];

$stmt = $conn->prepare("SELECT email, reset_token_expire FROM users WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (strtotime($row['reset_token_expire']) < time()) {
        echo "<p class='text-red-600'>Token expired. Please try again.</p>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, reset_token_expire=NULL WHERE reset_token=?");
        $stmt->bind_param("ss", $new_password, $token);

        if ($stmt->execute()) {
            echo "<p class='text-green-600'>Password reset successful. <a class='underline text-blue-600' href='../login.php'>Login</a></p>";
        } else {
            echo "<p class='text-red-600'>Failed to reset password.</p>";
        }
    } else {
        echo '
        <h2 class="text-2xl font-bold mb-6 text-center">Reset Password</h2>
        <form method="post">
            <input type="password" name="new_password" placeholder="New Password" required
                class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-md">
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-md">Update Password</button>
        </form>';
    }
} else {
    echo "<p class='text-red-600'>Invalid or used token.</p>";
}
?>
</div>
</body>
</html>
