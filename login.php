<?php
session_start();

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'MANAGER') {
        header("Location: manager-dashboard.php");
    } else {
        header("Location: employee-dashboard.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Employee Performance System</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="login-page">

    <div class="login-brand">

        <div class="brand-icon">
            EP
        </div>

        <h1>Employee Performance</h1>

        <p>
            Credit Management System
        </p>

        <div class="brand-description">
            Manage employee performance, tasks,
            credits and monthly evaluations
            from one centralized platform.
        </div>

    </div>


    <div class="login-card">

        <div class="login-header">

            <span class="welcome-text">
                Welcome back
            </span>

            <h2>Sign in to your account</h2>

            <p>
                Enter your credentials to continue.
            </p>

        </div>


        <form id="loginForm">

            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter your username"
                    required
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                    <button
                        type="button"
                        id="togglePassword"
                        class="password-toggle">
                        Show
                    </button>

                </div>

            </div>


            <div
                id="loginMessage"
                class="login-message">
            </div>


            <button
                type="submit"
                class="login-button"
                id="loginButton">

                <span id="loginButtonText">
                    Sign in
                </span>

            </button>

        </form>


        <div class="login-footer">

            Employee Performance & Credit Management System

        </div>

    </div>

</div>


<script src="assets/js/login.js"></script>

</body>

</html>