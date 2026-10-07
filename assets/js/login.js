document.addEventListener("DOMContentLoaded", () => {

    const loginForm = document.getElementById("loginForm");
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");
    const message = document.getElementById("loginMessage");

    // Show / hide password
    if (togglePassword) {
        togglePassword.addEventListener("click", () => {
            const isPassword = passwordInput.type === "password";

            passwordInput.type = isPassword ? "text" : "password";
            togglePassword.textContent = isPassword ? "Hide" : "Show";
        });
    }

    loginForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        const username = document.getElementById("username").value.trim();
        const password = passwordInput.value;

        if (!username || !password) {
            message.textContent = "Please enter username and password.";
            message.className = "login-message error";
            return;
        }

        message.textContent = "Signing in...";
        message.className = "login-message";

        try {
            const response = await fetch(
                "http://localhost:8080/api/auth/login",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password
                    })
                }
            );

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Invalid username or password.");
            }

            // Store authentication information
            sessionStorage.setItem("token", data.token);
            sessionStorage.setItem("userId", data.userId);
            sessionStorage.setItem("username", data.username);
            sessionStorage.setItem("role", data.role);

            message.textContent = "Login successful. Redirecting...";
            message.className = "login-message success";

            // Redirect according to role
            if (data.role === "MANAGER") {
                window.location.href = "manager-dashboard.php";
            } else {
                window.location.href = "employee-dashboard.php";
            }

        } catch (error) {
            console.error(error);

            message.textContent =
                error.message || "Unable to connect to the server.";

            message.className = "login-message error";
        }
    });
});