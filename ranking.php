<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Ranking | Employee Performance</title>

    <link rel="stylesheet"
          href="assets/css/style.css">

</head>

<body class="dashboard-body">

<div class="app-shell">

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


        <nav class="sidebar-nav" id="rankingNav"></nav>


        <div class="sidebar-bottom">

            <button class="logout-btn"
                    onclick="logout()">

                ↪ Logout

            </button>

        </div>

    </aside>


    <main class="main-content">

        <header class="topbar">

            <div>

                <p class="eyebrow">
                    PERFORMANCE ANALYTICS
                </p>

                <h1>
                    Employee Ranking
                </h1>

                <p class="page-subtitle">
                    Performance-based ranking with credits as the tie-breaker.
                </p>

            </div>

        </header>


        <!-- TOP THREE -->

        <section class="top-three"
                 id="topThree">

            <div class="podium-card">
                Loading...
            </div>

        </section>


        <!-- FULL RANKING -->

        <section class="dashboard-card">

            <div class="card-header">

                <div>

                    <span class="card-label">
                        LEADERBOARD
                    </span>

                    <h2>
                        Performance Ranking
                    </h2>

                </div>

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
                        <th>Performance Level</th>

                    </tr>

                    </thead>

                    <tbody id="rankingTable">

                    <tr>

                        <td colspan="6"
                            class="table-loading">

                            Loading ranking...

                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</div>


<div id="toastContainer"></div>


<script src="assets/js/api.js"></script>

<script>

requireLogin();

const role =
    getRole();


/* ================= NAV ================= */

function buildNav() {

    const nav =
        document.getElementById(
            "rankingNav"
        );


    if (role === "MANAGER") {

        nav.innerHTML = `

            <a href="manager-dashboard.php"
               class="nav-link">
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
               class="nav-link active">
                <span>★</span>
                Ranking
            </a>

            <a href="monthly-report.php"
               class="nav-link">
                <span>▤</span>
                Monthly Report
            </a>

        `;

    } else {

        nav.innerHTML = `

            <a href="employee-dashboard.php"
               class="nav-link">
                <span>▣</span>
                Dashboard
            </a>

            <a href="tasks.php"
               class="nav-link">
                <span>✓</span>
                My Tasks
            </a>

            <a href="ranking.php"
               class="nav-link active">
                <span>★</span>
                Ranking
            </a>

        `;

    }

}


/* ================= LOAD ================= */

async function loadRanking() {

    try {

        const employees =
            await apiRequest(
                "/ranking"
            );


        if (!Array.isArray(employees)) {
            return;
        }


        renderTopThree(
            employees
        );


        renderRanking(
            employees
        );


    } catch (error) {

        showToast(
            error.message ||
            "Unable to load ranking.",
            "error"
        );

    }

}


/* ================= TOP THREE ================= */

function renderTopThree(employees) {

    const container =
        document.getElementById(
            "topThree"
        );


    const top =
        employees.slice(0, 3);


    if (!top.length) {

        container.innerHTML = `
            <div class="podium-card">
                No ranking data available.
            </div>
        `;

        return;

    }


    container.innerHTML =
        top.map(
            (employee, index) => {

                const performance =
                    Number(
                        employee.currentPerformance || 0
                    );


                const position =
                    index + 1;


                return `

                    <div class="
                        podium-card
                        podium-${position}
                    ">

                        <div class="podium-rank">
                            #${position}
                        </div>

                        <div class="podium-avatar">

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

                        <strong>

                            ${
                                employee.fullName ||
                                employee.username
                            }

                        </strong>

                        <span>
                            ${performance.toFixed(1)} performance
                        </span>

                        <small>
                            ${employee.totalCredits || 0} credits
                        </small>

                    </div>

                `;

            }
        )
        .join("");

}


/* ================= TABLE ================= */

function renderRanking(employees) {

    const table =
        document.getElementById(
            "rankingTable"
        );


    table.innerHTML =
        employees.map(
            (employee, index) => {

                const performance =
                    Number(
                        employee.currentPerformance || 0
                    );


                let level =
                    "Needs Attention";


                if (performance >= 90) {

                    level = "Excellent";

                } else if (performance >= 75) {

                    level = "Good";

                } else if (performance >= 60) {

                    level = "Average";

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
                                            employee.username
                                        }
                                    </strong>

                                    <small>
                                        @${employee.username || ""}
                                    </small>

                                </div>

                            </div>

                        </td>


                        <td>
                            ${employee.department || "—"}
                        </td>


                        <td>

                            <div class="performance-cell">

                                <strong>
                                    ${performance.toFixed(1)}
                                </strong>

                                <div class="mini-progress">

                                    <span
                                        style="
                                        width:${Math.min(
                                            performance,
                                            100
                                        )}%
                                        ">
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>
                            ${employee.totalCredits || 0}
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

                                ${level}

                            </span>

                        </td>

                    </tr>

                `;

            }
        )
        .join("");

}


buildNav();

loadRanking();

</script>


<style>

.top-three {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 16px;

    margin-bottom: 18px;

}


.podium-card {

    text-align: center;

    padding: 25px;

    background: #101925;

    border:
        1px solid rgba(255,255,255,0.065);

    border-radius: 15px;

    transition: 0.25s ease;

}


.podium-card:hover {

    transform: translateY(-4px);

    border-color:
        rgba(59,130,246,0.3);

}


.podium-1 {

    background:
        linear-gradient(
            145deg,
            rgba(37,99,235,0.18),
            #101925
        );

}


.podium-rank {

    color: #6094ff;

    font-weight: 800;

    font-size: 12px;

    margin-bottom: 12px;

}


.podium-avatar {

    width: 55px;

    height: 55px;

    display: grid;

    place-items: center;

    margin: 0 auto 12px;

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #173b91
        );

    font-size: 18px;

    font-weight: 800;

}


.podium-card strong,
.podium-card span,
.podium-card small {

    display: block;

}


.podium-card strong {

    font-size: 14px;

}


.podium-card span {

    margin-top: 5px;

    color: #6f7e94;

    font-size: 10px;

}


.podium-card small {

    margin-top: 8px;

    color: #526177;

    font-size: 9px;

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


@media (max-width: 800px) {

    .top-three {

        grid-template-columns: 1fr;

    }

}

</style>

</body>
</html>