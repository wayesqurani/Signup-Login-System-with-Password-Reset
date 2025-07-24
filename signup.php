<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
    <form method="post" action="login.php" onsubmit="return validateForm()">
        <input type="text" name="name" placeholder="Name"
            class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>

        <input type="email" id="email" name="email" placeholder="Email"
            class="w-full mb-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>

        <div id="emailMsg" class="text-sm mt-1"></div>

        <input type="password" name="password" placeholder="Password"
            class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
            Register
        </button>
    </form>
</div>

<script>
    let isEmailValid = false;

    document.getElementById("email").addEventListener("input", function () {
        const email = this.value.trim();
        const emailMsg = document.getElementById("emailMsg");

        if (email.length === 0) {
            emailMsg.textContent = "";
            isEmailValid = false;
            return;
        }

        fetch("auth/email_check.php?email=" + encodeURIComponent(email))
            .then(res => res.text())
            .then(data => {
                if (data === "exists") {
                    emailMsg.textContent = "Email already registered.";
                    emailMsg.className = "text-red-500 text-sm mt-1";
                    isEmailValid = false;
                } else {
                    emailMsg.textContent = "Email is available.";
                    emailMsg.className = "text-green-500 text-sm mt-1";
                    isEmailValid = true;
                }
            });
    });

    function validateForm() {
        if (!isEmailValid) {
            alert("Email already exists or not checked!");
            return false;
        }
        return true;
    }
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'includes/config.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo '<div class="fixed bottom-5 right-5 z-50">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">Email already registered.</span>
            </div>
        </div>';
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            echo '<div class="fixed bottom-5 right-5 z-50">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">Registration successful!</span>
                </div>
            </div>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>
