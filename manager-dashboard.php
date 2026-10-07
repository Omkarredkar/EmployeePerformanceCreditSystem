<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manager Dashboard | Employee Performance</title>

    <link rel="stylesheet"
          href="assets/css/style.css">

</head>

<body class="dashboard-body">

<div class="app-shell">

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <div class="sidebar-brand">

            <div class="brand-logo">
                EP
            </div>

            <div>
                <strong>Employee Performance</strong>
                <span>Management System</span>
            </div>

        </div>


        <nav class="sidebar-nav">

            <a href="manager-dashboard.php"
               class="nav-link active">

                <span>▣</span>
                Dashboard

            </a>

            <a href="employees.php"
               class="nav-link">

                <span>◉</span>
                Employees

            </a>

            <a href="tasks.php"
               class="nav-link">

                <span>✓</span>
                Tasks

            </a>

            <a href="ranking.php"
               class="nav-link">

                <span>★</span>
                Ranking

            </a>

            <a href="monthly-report.php"
               class="nav-link">

                <span>▤</span>
                Monthly Report

            </a>

        </nav>


        <div class="sidebar-bottom">

            <button class="logout-btn"
                    onclick="logout()">

                ↪ Logout

            </button>

        </div>

    </aside>


    <!-- ================= MAIN ================= -->

    <main class="main-content">


        <!-- TOP BAR -->

        <header class="topbar">

            <div>

                <p class="eyebrow">
                    MANAGER PORTAL
                </p>

                <h1>
                    Good day,
                    <span id="managerName">
                        Manager
                    </span>
                </h1>

                <p class="page-subtitle">
                    Monitor employee performance, tasks and credits.
                </p>

            </div>


            <div class="profile-chip">

                <div class="profile-avatar">
                    M
                </div>

                <div>

                    <strong id="managerUsername">
                        Manager
                    </strong>

                    <span>Manager</span>

                </div>

            </div>

        </header>


        <!-- ================= STAT CARDS ================= -->

        <section class="stats-grid">


            <div class="stat-card">

                <div class="stat-icon">
                    ◉
                </div>

                <div>

                    <span>Total Employees</span>

                    <strong id="totalEmployees">
                        --
                    </strong>

                    <small>registered</small>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    ✓
                </div>

                <div>

                    <span>Active Employees</span>

                    <strong id="activeEmployees">
                        --
                    </strong>

                    <small>currently active</small>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    ↗
                </div>

                <div>

                    <span>Average Performance</span>

                    <strong id="averagePerformance">
                        --
                    </strong>

                    <small>out of 100</small>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    ★
                </div>

                <div>

                    <span>Total Credits</span>

                    <strong id="totalCredits">
                        --
                    </strong>

                    <small>earned</small>

                </div>

            </div>

        </section>


        <!-- ================= DASHBOARD GRID ================= -->

        <section class="dashboard-grid">


            <!-- PERFORMANCE SUMMARY -->

            <div class="dashboard-card">

                <div class="card-header">

                    <div>

                        <span class="card-label">
                            OVERVIEW
                        </span>

                        <h2>Performance Summary</h2>

                    </div>

                </div>


                <div class="manager-summary">

                    <div class="summary-number">

                        <strong id="topPerformance">
                            --
                        </strong>

                        <span>
                            Top Performance
                        </span>

                    </div>


                    <div class="summary-number">

                        <strong id="topEmployee">
                            --
                        </strong>

                        <span>
                            Top Employee
                        </span>

                    </div>


                    <div class="summary-number">

                        <strong id="lowestPerformance">
                            --
                        </strong>

                        <span>
                            Lowest Performance
                        </span>

                    </div>

                </div>

            </div>


            <!-- QUICK ACTIONS -->

            <div class="dashboard-card">

                <div class="card-header">

                    <div>

                        <span class="card-label">
                            MANAGEMENT
                        </span>

                        <h2>Quick Actions</h2>

                    </div>

                </div>


                <div class="quick-actions">

                    <a href="employees.php"
                       class="quick-action">

                        <span>◉</span>

                        <div>
                            <strong>Manage Employees</strong>
                            <small>
                                View and manage employee records
                            </small>
                        </div>

                    </a>


                    <a href="tasks.php"
                       class="quick-action">

                        <span>✓</span>

                        <div>
                            <strong>Manage Tasks</strong>
                            <small>
                                Assign and evaluate tasks
                            </small>
                        </div>

                    </a>


                    <a href="monthly-report.php"
                       class="quick-action">

                        <span>▤</span>

                        <div>
                            <strong>Monthly Evaluation</strong>
                            <small>
                                Review monthly recommendations
                            </small>
                        </div>

                    </a>

                </div>

            </div>

        </section>


        <!-- ================= RANKING ================= -->

        <section class="dashboard-card manager-ranking-card">

            <div class="card-header">

                <div>

                    <span class="card-label">
                        PERFORMANCE RANKING
                    </span>

                    <h2>Employee Ranking</h2>

                </div>


                <a href="ranking.php"
                   class="view-all-btn">

                    View Full Ranking →

                </a>

            </div>


            <div class="table-container">

                <table class="manager-table">

                    <thead>

                    <tr>

                        <th>Rank</th>

                        <th>Employee</th>

                        <th>Department</th>

                        <th>Performance</th>

                        <th>Credits</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody id="rankingTable">

                    <tr>

                        <td colspan="6"
                            class="table-loading">

                            Loading employee data...

                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </section>


        <!-- ================= MONTHLY EVALUATION ================= -->

        <section class="dashboard-card monthly-card">

            <div class="card-header">

                <div>

                    <span class="card-label">
                        MONTHLY EVALUATION
                    </span>

                    <h2>Management Recommendation</h2>

                </div>

                <button class="primary-action"
                        onclick="generateMonthlyEvaluation()">

                    Generate Evaluation

                </button>

            </div>


            <div id="monthlyStatus"
                 class="monthly-status">

                <div class="monthly-icon">
                    ✦
                </div>

                <div>

                    <strong>
                        Monthly evaluation is ready
                    </strong>

                    <p>
                        Generate the current month's evaluation
                        to review increment and removal recommendations.
                    </p>

                </div>

            </div>

        </section>


    </main>

</div>


<!-- TOAST -->

<div id="toastContainer"></div>


<script src="assets/js/api.js"></script>


<script>

requireLogin();


/* =========================================================
   BASIC USER INFORMATION
   ========================================================= */

const username =
    getUsername() || "Manager";

document.getElementById("managerUsername")
    .textContent = username;

document.getElementById("managerName")
    .textContent = username;


/* =========================================================
   LOAD DASHBOARD
   ========================================================= */

async function loadManagerDashboard() {

    try {

        const employees =
            await apiRequest("/employees");

        if (!Array.isArray(employees)) {

            throw new Error(
                "Unable to load employee data."
            );

        }


        /* ---------------------------------------------
           BASIC COUNTS
           --------------------------------------------- */

        const activeEmployees =
            employees.filter(
                employee => employee.active === true
            );


        document.getElementById("totalEmployees")
            .textContent =
            employees.length;


        document.getElementById("activeEmployees")
            .textContent =
            activeEmployees.length;


        /* ---------------------------------------------
           PERFORMANCE
           --------------------------------------------- */

        const performances =
            employees
                .map(employee =>
                    Number(employee.currentPerformance || 0)
                );


        const average =
            performances.length > 0
                ? performances.reduce(
                    (sum, value) => sum + value,
                    0
                ) / performances.length
                : 0;


        document.getElementById("averagePerformance")
            .textContent =
            average.toFixed(1);


        /* ---------------------------------------------
           CREDITS
           --------------------------------------------- */

        const credits =
            employees.reduce(
                (sum, employee) =>
                    sum + Number(employee.totalCredits || 0),
                0
            );


        document.getElementById("totalCredits")
            .textContent =
            credits;


        /* ---------------------------------------------
           SORT EMPLOYEES
           --------------------------------------------- */

        const sortedEmployees =
            [...employees].sort(
                (a, b) => {

                    const performanceDifference =
                        Number(b.currentPerformance || 0)
                        -
                        Number(a.currentPerformance || 0);

                    if (performanceDifference !== 0) {
                        return performanceDifference;
                    }

                    const creditDifference =
                        Number(b.totalCredits || 0)
                        -
                        Number(a.totalCredits || 0);

                    if (creditDifference !== 0) {
                        return creditDifference;
                    }

                    return Number(a.id || 0)
                        -
                        Number(b.id || 0);
                }
            );


        /* ---------------------------------------------
           TOP / LOWEST
           --------------------------------------------- */

        if (sortedEmployees.length > 0) {

            const top =
                sortedEmployees[0];

            const lowest =
                sortedEmployees[
                    sortedEmployees.length - 1
                ];


            document.getElementById("topPerformance")
                .textContent =
                Number(
                    top.currentPerformance || 0
                ).toFixed(1);


            document.getElementById("topEmployee")
                .textContent =
                top.fullName ||
                top.username ||
                "--";


            document.getElementById("lowestPerformance")
                .textContent =
                Number(
                    lowest.currentPerformance || 0
                ).toFixed(1);

        }


        /* ---------------------------------------------
           RANKING TABLE
           --------------------------------------------- */

        renderRanking(sortedEmployees);


    } catch (error) {

        console.error(
            "Manager dashboard error:",
            error
        );

        showToast(
            error.message ||
            "Unable to load manager dashboard.",
            "error"
        );

    }

}


/* =========================================================
   RENDER RANKING
   ========================================================= */

function renderRanking(employees) {

    const table =
        document.getElementById("rankingTable");


    if (!employees.length) {

        table.innerHTML = `

            <tr>

                <td colspan="6"
                    class="table-empty">

                    No employees found.

                </td>

            </tr>

        `;

        return;
    }


    table.innerHTML =
        employees
            .slice(0, 8)
            .map(
                (employee, index) => {

                    const performance =
                        Number(
                            employee.currentPerformance || 0
                        );


                    let status =
                        "Needs Attention";

                    if (performance >= 90) {

                        status =
                            "Excellent";

                    } else if (performance >= 75) {

                        status =
                            "Good";

                    } else if (performance >= 60) {

                        status =
                            "Average";

                    }


                    return `

                    <tr>

                        <td>

                            <span class="rank-number">
                                #${index + 1}
                            </span>

                        </td>


                        <td>

                            <div class="employee-cell">

                                <div class="employee-avatar">
                                    ${
                                        (
                                            employee.fullName ||
                                            employee.username ||
                                            "E"
                                        )
                                        .charAt(0)
                                        .toUpperCase()
                                    }
                                </div>

                                <div>

                                    <strong>
                                        ${
                                            employee.fullName ||
                                            employee.username ||
                                            "Unknown"
                                        }
                                    </strong>

                                    <small>
                                        @${employee.username || ""}
                                    </small>

                                </div>

                            </div>

                        </td>


                        <td>

                            ${
                                employee.department ||
                                "—"
                            }

                        </td>


                        <td>

                            <div class="performance-cell">

                                <strong>
                                    ${performance.toFixed(1)}
                                </strong>

                                <div class="mini-progress">

                                    <span
                                        style="width:${Math.min(
                                            performance,
                                            100
                                        )}%">
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <strong>
                                ${employee.totalCredits || 0}
                            </strong>

                        </td>


                        <td>

                            <span class="
                                status-badge
                                ${
                                    performance >= 75
                                        ? "status-good"
                                        : "status-warning"
                                }
                            ">

                                ${status}

                            </span>

                        </td>

                    </tr>

                    `;

                }
            )
            .join("");

}


/* =========================================================
   MONTHLY EVALUATION
   ========================================================= */

async function generateMonthlyEvaluation() {

    const button =
        document.querySelector(
            ".primary-action"
        );


    const originalText =
        button.textContent;


    button.disabled = true;

    button.textContent =
        "Generating...";


    try {

        const result =
            await apiRequest(
                "/monthly-performance/generate",
                {
                    method: "POST"
                }
            );


        showToast(
            "Monthly evaluation generated successfully.",
            "success"
        );


        const status =
            document.getElementById(
                "monthlyStatus"
            );


        status.innerHTML = `

            <div class="monthly-icon">
                ✓
            </div>

            <div>

                <strong>
                    Evaluation generated successfully
                </strong>

                <p>
                    ${
                        Array.isArray(result)
                            ? result.length
                            : 0
                    }
                    employee evaluations have been generated.
                    Open Monthly Report to review them.
                </p>

            </div>

        `;


    } catch (error) {

        console.error(error);

        showToast(
            error.message ||
            "Unable to generate evaluation.",
            "error"
        );

    } finally {

        button.disabled = false;

        button.textContent =
            originalText;

    }

}


/* =========================================================
   START
   ========================================================= */

loadManagerDashboard();

</script>


<style>

/* =========================================================
   MANAGER DASHBOARD
   ========================================================= */

.manager-summary {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 12px;

}


.summary-number {

    padding: 18px;

    background:
        rgba(255,255,255,0.025);

    border:
        1px solid rgba(255,255,255,0.05);

    border-radius: 11px;

}


.summary-number strong {

    display: block;

    font-size: 23px;

    margin-bottom: 6px;

}


.summary-number span {

    color: #718097;

    font-size: 10px;

}


.quick-actions {

    display: grid;

    gap: 9px;

}


.quick-action {

    display: flex;

    align-items: center;

    gap: 13px;

    padding: 12px;

    text-decoration: none;

    color: inherit;

    border-radius: 10px;

    background:
        rgba(255,255,255,0.025);

    border:
        1px solid rgba(255,255,255,0.04);

    transition: 0.2s ease;

}


.quick-action:hover {

    transform: translateX(4px);

    background:
        rgba(59,130,246,0.09);

    border-color:
        rgba(59,130,246,0.2);

}


.quick-action > span {

    width: 34px;

    height: 34px;

    display: grid;

    place-items: center;

    border-radius: 9px;

    background:
        rgba(59,130,246,0.12);

    color: #5f91ff;

}


.quick-action strong,
.quick-action small {

    display: block;

}


.quick-action strong {

    font-size: 12px;

}


.quick-action small {

    margin-top: 4px;

    color: #6d7b90;

    font-size: 9px;

}


.manager-ranking-card {

    margin-top: 18px;

}


.view-all-btn {

    color: #5f91ff;

    text-decoration: none;

    font-size: 11px;

    align-self: center;

}


.table-container {

    overflow-x: auto;

}


.manager-table {

    width: 100%;

    border-collapse: collapse;

}


.manager-table th {

    text-align: left;

    padding: 12px;

    color: #637187;

    font-size: 9px;

    letter-spacing: 1px;

    text-transform: uppercase;

    border-bottom:
        1px solid rgba(255,255,255,0.06);

}


.manager-table td {

    padding: 14px 12px;

    color: #aab6c8;

    font-size: 11px;

    border-bottom:
        1px solid rgba(255,255,255,0.045);

}


.manager-table tbody tr {

    transition: 0.2s ease;

}


.manager-table tbody tr:hover {

    background:
        rgba(255,255,255,0.025);

}


.employee-cell {

    display: flex;

    align-items: center;

    gap: 10px;

}


.employee-avatar {

    width: 32px;

    height: 32px;

    display: grid;

    place-items: center;

    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #173b91
        );

    color: white;

    font-size: 11px;

    font-weight: 700;

}


.employee-cell strong,
.employee-cell small {

    display: block;

}


.employee-cell strong {

    color: #dce6f6;

    font-size: 11px;

}


.employee-cell small {

    margin-top: 3px;

    color: #5e6d83;

    font-size: 9px;

}


.rank-number {

    color: #7ea5ff;

    font-weight: 700;

}


.performance-cell strong {

    display: inline-block;

    width: 35px;

}


.mini-progress {

    display: inline-block;

    width: 65px;

    height: 4px;

    background:
        #202c3c;

    border-radius: 10px;

    overflow: hidden;

    vertical-align: middle;

}


.mini-progress span {

    display: block;

    height: 100%;

    border-radius: inherit;

    background:
        linear-gradient(
            90deg,
            #2563eb,
            #60a5fa
        );

}


.status-badge {

    display: inline-block;

    padding: 5px 8px;

    border-radius: 20px;

    font-size: 8px;

    font-weight: 700;

}


.status-good {

    color: #79c9a0;

    background:
        rgba(34,197,94,0.09);

}


.status-warning {

    color: #e8b86b;

    background:
        rgba(245,158,11,0.09);

}


.table-loading,
.table-empty {

    text-align: center;

    padding: 30px !important;

    color: #68778d !important;

}


.monthly-card {

    margin-top: 18px;

}


.primary-action {

    border: 0;

    padding: 10px 15px;

    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #3478ed
        );

    color: white;

    font-size: 11px;

    font-weight: 700;

    cursor: pointer;

    transition: 0.2s ease;

}


.primary-action:hover {

    transform: translateY(-2px);

    box-shadow:
        0 8px 20px
        rgba(37,99,235,0.22);

}


.primary-action:disabled {

    opacity: 0.6;

    cursor: wait;

}


.monthly-status {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 16px;

    border-radius: 11px;

    background:
        rgba(59,130,246,0.05);

    border:
        1px solid rgba(59,130,246,0.08);

}


.monthly-icon {

    width: 42px;

    height: 42px;

    flex-shrink: 0;

    display: grid;

    place-items: center;

    border-radius: 11px;

    background:
        rgba(59,130,246,0.13);

    color: #6b9aff;

    font-size: 18px;

}


.monthly-status strong {

    display: block;

    font-size: 12px;

}


.monthly-status p {

    margin: 5px 0 0;

    color: #6c7a90;

    font-size: 10px;

}


@media (max-width: 900px) {

    .manager-summary {

        grid-template-columns: 1fr;

    }

    .manager-table {

        min-width: 700px;

    }

}

</style>

</body>

</html>