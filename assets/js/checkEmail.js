document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");
    const emailMsg = document.getElementById("emailMsg");

    let timeout = null;

    emailInput.addEventListener("input", function () {
        const email = this.value.trim();

        clearTimeout(timeout);

        timeout = setTimeout(() => {
            if (email.length === 0) {
                emailMsg.textContent = "";
                return;
            }

            fetch("auth/email_check.php?email=" + encodeURIComponent(email))
                .then(res => res.text())
                .then(data => {
                    if (data === "exists") {
                        emailMsg.textContent = "Email already registered.";
                        emailMsg.classList.remove("text-green-500");
                        emailMsg.classList.add("text-red-500");
                    } else {
                        emailMsg.textContent = "EEmail is available.";
                        emailMsg.classList.remove("text-red-500");
                        emailMsg.classList.add("text-green-500");
                    }
                });
        }, 400); // debounce delay
    });
});