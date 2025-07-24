<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <form method="post" action='./auth/login_process.php'>
        <input type="email" name="email" placeholder="Email" required
               class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <input type="password" name="password" placeholder="Password" required
               class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />

        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
            Login
        </button>
    </form>

    <!-- Forgot Password Link -->
    <div class="mt-4 text-center">
        <a href="./auth/forget_password.php" class="text-blue-600 text-sm hover:underline">
            Forgot your password?
        </a>
    </div>

    <!-- Register Link -->
    <div class="mt-2 text-center text-sm text-gray-600">
        Don’t have an account?
        <a href="./signup.php" class="text-blue-600 hover:underline">Register</a>
    </div>
</div>
</body>
</html>