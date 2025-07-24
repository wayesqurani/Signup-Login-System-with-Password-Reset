document.getElementById("email").addEventListener("blur", function() {
    const email = this.value.trim();
    const emailMsg = document.getElementById("emailMsg");

    // Basic email format check (optional)
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email) {
        emailMsg.innerText = "";
        return;
    }
    if (!emailPattern.test(email)) {
        emailMsg.innerText = "Please enter a valid email address.";
        return;
    }

    fetch("auth/email_check.php?email=" + encodeURIComponent(email))
        .then(response => response.json())  // Expect JSON response like { exists: true }
        .then(data => {
            if (data.exists) {
                emailMsg.innerText = "Email already registered!";
            } else {
                emailMsg.innerText = "Email is available.";
            }
        })
        .catch(error => {
            console.error("Error checking email:", error);
            emailMsg.innerText = "";  // Or show a friendly message if you want
        });
});
