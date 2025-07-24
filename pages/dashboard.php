<?php
include '../includes/session.php';
include '../includes/config.php';

// Ensure user is logged in and session is valid
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    $stmt = $conn->prepare("SELECT name, email, profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    header("Location: ../login.php?error=Session expired. Please login again.");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<!-- Navbar -->
<div class="flex items-center justify-between px-8 py-4 bg-white shadow-md">
    <h1 class="text-xl font-bold text-gray-800">User Dashboard</h1>

    <!-- Profile Picture + Upload on Hover -->
    <div class="relative">
        <!-- Profile image label trigger -->
        <label id="profileTrigger" class="cursor-pointer block relative">
            <img src="../uploads/<?= htmlspecialchars($user['profile_picture'] ?? 'default.jpg') ?>"
                 alt="Profile"
                 class="w-12 h-12 rounded-full object-cover border-2 border-blue-500" />
            <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 hover:opacity-100 rounded-full transition"></div>
        </label>

        <!-- Upload form -->
        <form action="../auth/upload_picture.php" method="post" enctype="multipart/form-data"
              class="absolute right-0 mt-2 bg-white border p-3 rounded shadow-lg z-50 hidden"
              id="uploadForm">
            <input type="file" name="profile_pic" accept="image/*" class="mb-2 text-sm" required />
            <button type="submit"
                    class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                Upload
            </button>
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-5xl mx-auto mt-10 grid grid-cols-1 md:grid-cols-2 gap-6 px-4">

    <!-- User Info -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Your Profile</h2>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['name'] ?? 'Unknown') ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? 'Not set') ?></p>
        <p><strong>User ID:</strong> <?= $user_id ?? 'N/A' ?></p>
    </div>

    <!-- Summary Cards -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Summary</h2>
        <div class="grid grid-cols-2 gap-4 text-center">
            <div class="bg-blue-100 rounded p-4">
                <h3 class="text-2xl font-bold text-blue-700">20</h3>
                <p class="text-sm text-blue-800">Tasks</p>
            </div>
            <div class="bg-green-100 rounded p-4">
                <h3 class="text-2xl font-bold text-green-700">10</h3>
                <p class="text-sm text-green-800">Projects</p>
            </div>
            <div class="bg-yellow-100 rounded p-4">
                <h3 class="text-2xl font-bold text-yellow-700">5</h3>
                <p class="text-sm text-yellow-800">Teams</p>
            </div>
            <div class="bg-purple-100 rounded p-4">
                <h3 class="text-2xl font-bold text-purple-700">3</h3>
                <p class="text-sm text-purple-800">Events</p>
            </div>
        </div>
    </div>
</div>

<!-- Logout -->
<div class="text-center mt-10">
    <a href="../auth/logout.php" class="text-red-600 hover:underline text-sm">Logout</a>
</div>

<!-- Script to keep upload form open on hover -->
<script>
    const profileTrigger = document.getElementById('profileTrigger');
    const uploadForm = document.getElementById('uploadForm');

    profileTrigger.addEventListener('mouseenter', () => {
        uploadForm.classList.remove('hidden');
    });

    profileTrigger.addEventListener('mouseleave', () => {
        setTimeout(() => {
            if (!uploadForm.matches(':hover')) {
                uploadForm.classList.add('hidden');
            }
        }, 200);
    });

    uploadForm.addEventListener('mouseleave', () => {
        uploadForm.classList.add('hidden');
    });

    uploadForm.addEventListener('mouseenter', () => {
        uploadForm.classList.remove('hidden');
    });
</script>

</body>
</html>
