const API_BASE_URL = "http://localhost:8080/api";

function getToken() {
    return sessionStorage.getItem("token");
}

function getUserId() {
    return sessionStorage.getItem("userId");
}

function getUsername() {
    return sessionStorage.getItem("username");
}

function getRole() {
    return sessionStorage.getItem("role");
}

function isLoggedIn() {
    return !!getToken();
}

function logout() {
    sessionStorage.clear();
    window.location.href = "login.php";
}

async function apiRequest(endpoint, options = {}) {

    const token = getToken();

    const headers = {
        "Content-Type": "application/json",
        ...(options.headers || {})
    };

    if (token) {
        headers["Authorization"] = `Bearer ${token}`;
    }

    const response = await fetch(
        `${API_BASE_URL}${endpoint}`,
        {
            ...options,
            headers
        }
    );

    if (response.status === 401 ||
        response.status === 403) {

        logout();
        return null;
    }

    let data = null;

    try {
        data = await response.json();
    } catch {
        data = null;
    }

    if (!response.ok) {

        const message =
            data?.message ||
            data?.error ||
            "Something went wrong.";

        throw new Error(message);
    }

    return data;
}

function requireLogin() {

    if (!isLoggedIn()) {
        window.location.href = "login.php";
    }
}

function formatNumber(value) {

    if (value === null || value === undefined) {
        return "0";
    }

    return Number(value).toFixed(1);
}

function showToast(message, type = "success") {

    let container =
        document.getElementById("toastContainer");

    if (!container) {

        container = document.createElement("div");

        container.id = "toastContainer";

        document.body.appendChild(container);
    }

    const toast = document.createElement("div");

    toast.className = `toast toast-${type}`;

    toast.textContent = message;

    container.appendChild(toast);

    setTimeout(() => {

        toast.classList.add("toast-hide");

        setTimeout(() => {
            toast.remove();
        }, 300);

    }, 3000);
}