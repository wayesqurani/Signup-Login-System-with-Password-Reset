<?php include '../includes/config.php'; include '../includes/mailer.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Forget Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Forgot Password</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Enter your registered email"
            class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-md" required>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md">Send Reset Link</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $token = bin2hex(random_bytes(32));
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Store token
            $stmt = $conn->prepare("UPDATE users SET reset_token=?, reset_token_expire=? WHERE email=?");
            $stmt->bind_param("sss", $token, $expiry, $email);
            $stmt->execute();

            if (sendResetEmail($email, $token)) {
                echo '<div class="text-green-600 mt-4">Reset link sent to your email.</div>';
            } else {
                echo '<div class="text-red-600 mt-4">Failed to send email.</div>';
            }
        } else {
            echo '<div class="text-red-600 mt-4">Email not found!</div>';
        }
    }
    ?>
</div>
</body>
</html>
