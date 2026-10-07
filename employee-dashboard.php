<?php
session_start();

if (!isset($_SESSION["user"])) {
    // Session isn't used for API authentication.
    // JavaScript checks sessionStorage instead.
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Employee Dashboard</title>

    <link rel="stylesheet"
          href="assets/css/style.css">

</head>

<body class="dashboard-body">

<div class="app-shell">

    <!-- Sidebar -->

    <aside class="sidebar">

        <div class="sidebar-brand">

            <div class="brand-logo">EP</div>

            <div>
                <strong>Employee Performance</strong>
                <span>Management System</span>
            </div>

        </div>

        <nav class="sidebar-nav">

            <a href="employee-dashboard.php"
               class="nav-link active">

                <span>▣</span>
                Dashboard

            </a>

            <a href="tasks.php"
               class="nav-link">

                <span>✓</span>
                My Tasks

            </a>

            <a href="ranking.php"
               class="nav-link">

                <span>★</span>
                Ranking

            </a>

        </nav>

        <div class="sidebar-bottom">

            <button class="logout-btn"
                    onclick="logout()">

                ↪ Logout

            </button>

        </div>

    </aside>


    <!-- Main -->

    <main class="main-content">

        <header class="topbar">

            <div>

                <p class="eyebrow">
                    EMPLOYEE PORTAL
                </p>

                <h1>
                    Welcome back,
                    <span id="employeeName">
                        Employee
                    </span>
                </h1>

                <p class="page-subtitle">
                    Here's your current performance overview.
                </p>

            </div>

            <div class="profile-chip">

                <div class="profile-avatar">
                    E
                </div>

                <div>
                    <strong id="profileUsername">
                        Employee
                    </strong>

                    <span>Employee</span>
                </div>

            </div>

        </header>


        <!-- Stats -->

        <section class="stats-grid">

            <div class="stat-card">

                <div class="stat-icon performance-icon">
                    ↗
                </div>

                <div>

                    <span>Performance</span>

                    <strong id="performanceScore">
                        --
                    </strong>

                    <small>out of 100</small>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon credit-icon">
                    ★
                </div>

                <div>

                    <span>Total Credits</span>

                    <strong id="totalCredits">
                        --
                    </strong>

                    <small>earned credits</small>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon task-icon">
                    ✓
                </div>

                <div>

                    <span>Completed Tasks</span>

                    <strong id="completedTasks">
                        --
                    </strong>

                    <small>tasks completed</small>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon rank-icon">
                    #
                </div>

                <div>

                    <span>Current Ranking</span>

                    <strong id="employeeRank">
                        --
                    </strong>

                    <small>among employees</small>

                </div>

            </div>

        </section>


        <!-- Main dashboard grid -->

        <section class="dashboard-grid">


            <!-- Performance -->

            <div class="dashboard-card performance-card">

                <div class="card-header">

                    <div>

                        <span class="card-label">
                            PERFORMANCE
                        </span>

                        <h2>Performance Overview</h2>

                    </div>

                </div>


                <div class="performance-ring-wrapper">

                    <div class="performance-ring">

                        <div>

                            <strong id="ringScore">
                                --
                            </strong>

                            <span>Score</span>

                        </div>

                    </div>

                </div>


                <div class="performance-details">

                    <div>

                        <span>Deadline</span>

                        <strong id="deadlineScore">
                            --
                        </strong>

                    </div>

                    <div>

                        <span>Quality</span>

                        <strong id="qualityScore">
                            --
                        </strong>

                    </div>

                    <div>

                        <span>Completion</span>

                        <strong id="completionScore">
                            --
                        </strong>

                    </div>

                </div>

            </div>


            <!-- Employee info -->

            <div class="dashboard-card">

                <div class="card-header">

                    <div>

                        <span class="card-label">
                            PROFILE
                        </span>

                        <h2>Employee Details</h2>

                    </div>

                </div>

                <div class="profile-details">

                    <div>
                        <span>Full Name</span>
                        <strong id="fullName">--</strong>
                    </div>

                    <div>
                        <span>Department</span>
                        <strong id="department">--</strong>
                    </div>

                    <div>
                        <span>Designation</span>
                        <strong id="designation">--</strong>
                    </div>

                    <div>
                        <span>Email</span>
                        <strong id="email">--</strong>
                    </div>

                    <div>
                        <span>Skills</span>
                        <strong id="skills">--</strong>
                    </div>

                </div>

            </div>


        </section>


        <!-- Recommendation -->

        <section class="dashboard-card recommendation-card">

            <div class="recommendation-icon">
                ✦
            </div>

            <div>

                <span class="card-label">
                    SKILL RECOMMENDATION
                </span>

                <h2 id="recommendationTitle">
                    Skill-based opportunity
                </h2>

                <p id="recommendationText">
                    Your skill profile will be evaluated
                    against current employee performance.
                </p>

            </div>

        </section>


    </main>

</div>


<div id="toastContainer"></div>


<script src="assets/js/api.js"></script>

<script>

requireLogin();

document.getElementById("profileUsername")
    .textContent = getUsername() || "Employee";


async function loadEmployeeDashboard() {

    try {

        const id = getUserId();

        const employee =
            await apiRequest(`/employees/${id}`);

        if (!employee) {
            return;
        }

        document.getElementById("employeeName")
            .textContent =
            employee.fullName || employee.username;

        document.getElementById("profileUsername")
            .textContent =
            employee.username;

        document.getElementById("fullName")
            .textContent =
            employee.fullName || "--";

        document.getElementById("department")
            .textContent =
            employee.department || "--";

        document.getElementById("designation")
            .textContent =
            employee.designation || "--";

        document.getElementById("email")
            .textContent =
            employee.email || "--";

        document.getElementById("skills")
            .textContent =
            employee.skills || "--";

        const performance =
            await apiRequest(`/performance/${id}`);

        const score =
            Number(performance || 0);

        document.getElementById("performanceScore")
            .textContent =
            score.toFixed(1);

        document.getElementById("ringScore")
            .textContent =
            score.toFixed(1);

        document.getElementById("deadlineScore")
            .textContent =
            "40%";

        document.getElementById("qualityScore")
            .textContent =
            "40%";

        document.getElementById("completionScore")
            .textContent =
            "20%";

        document.getElementById("totalCredits")
            .textContent =
            employee.totalCredits ?? 0;

        const ranking =
            await apiRequest("/ranking");

        if (Array.isArray(ranking)) {

            const position =
                ranking.findIndex(
                    item => item.id === employee.id
                );

            document.getElementById("employeeRank")
                .textContent =
                position >= 0
                    ? `#${position + 1}`
                    : "--";
        }

        const tasks =
            await apiRequest(`/tasks/employee/${id}`);

        if (Array.isArray(tasks)) {

            const completed =
                tasks.filter(
                    task => task.completed
                ).length;

            document.getElementById("completedTasks")
                .textContent =
                `${completed}/${tasks.length}`;
        }

    } catch (error) {

        console.error(error);

        showToast(
            error.message ||
            "Unable to load dashboard.",
            "error"
        );
    }
}


loadEmployeeDashboard();

</script>

</body>
</html>