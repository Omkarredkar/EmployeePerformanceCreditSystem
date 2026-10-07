<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employees | Employee Performance</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="dashboard-body">

<div class="app-shell">

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="sidebar-brand">

            <div class="brand-logo">EP</div>

            <div>
                <strong>Employee Performance</strong>
                <span>Management System</span>
            </div>

        </div>

        <nav class="sidebar-nav">

            <a href="manager-dashboard.php" class="nav-link">
                <span>▣</span>
                Dashboard
            </a>

            <a href="employees.php" class="nav-link active">
                <span>◉</span>
                Employees
            </a>

            <a href="tasks.php" class="nav-link">
                <span>✓</span>
                Tasks
            </a>

            <a href="ranking.php" class="nav-link">
                <span>★</span>
                Ranking
            </a>

            <a href="monthly-report.php" class="nav-link">
                <span>▤</span>
                Monthly Report
            </a>

        </nav>

        <div class="sidebar-bottom">

            <button class="logout-btn" onclick="logout()">
                ↪ Logout
            </button>

        </div>

    </aside>


    <!-- MAIN -->

    <main class="main-content">

        <header class="topbar">

            <div>

                <p class="eyebrow">
                    EMPLOYEE MANAGEMENT
                </p>

                <h1>
                    Employees
                </h1>

                <p class="page-subtitle">
                    Manage employee records, performance and account status.
                </p>

            </div>

            <button class="primary-action"
                    onclick="openEmployeeModal()">

                + Add Employee

            </button>

        </header>


        <!-- SEARCH / FILTER -->

        <section class="dashboard-card employee-toolbar">

            <div class="search-box">

                <span>⌕</span>

                <input
                    type="text"
                    id="employeeSearch"
                    placeholder="Search employees..."
                    oninput="filterEmployees()"
                >

            </div>

            <select id="statusFilter"
                    onchange="filterEmployees()">

                <option value="all">
                    All Employees
                </option>

                <option value="active">
                    Active
                </option>

                <option value="inactive">
                    Inactive
                </option>

            </select>

        </section>


        <!-- EMPLOYEE TABLE -->

        <section class="dashboard-card employee-table-card">

            <div class="card-header">

                <div>

                    <span class="card-label">
                        TEAM
                    </span>

                    <h2>
                        Employee Directory
                    </h2>

                </div>

                <span id="employeeCount"
                      class="record-count">
                    0 employees
                </span>

            </div>


            <div class="table-container">

                <table class="manager-table">

                    <thead>

                    <tr>

                        <th>Employee</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Performance</th>
                        <th>Credits</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                    </thead>

                    <tbody id="employeeTable">

                    <tr>
                        <td colspan="7"
                            class="table-loading">
                            Loading employees...
                        </td>
                    </tr>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</div>


<!-- EMPLOYEE MODAL -->

<div id="employeeModal"
     class="modal-overlay">

    <div class="modal-card">

        <div class="modal-header">

            <div>

                <span class="card-label">
                    NEW EMPLOYEE
                </span>

                <h2>Add Employee</h2>

            </div>

            <button class="modal-close"
                    onclick="closeEmployeeModal()">
                ×
            </button>

        </div>


        <form id="employeeForm">

            <div class="form-grid">

                <div class="form-group">

                    <label>Username</label>

                    <input
                        type="text"
                        id="newUsername"
                        required
                        placeholder="employee5"
                    >

                </div>


                <div class="form-group">

                    <label>Password</label>

                    <input
                        type="password"
                        id="newPassword"
                        required
                        placeholder="Password"
                    >

                </div>


                <div class="form-group">

                    <label>Full Name</label>

                    <input
                        type="text"
                        id="newFullName"
                        required
                        placeholder="Employee Name"
                    >

                </div>


                <div class="form-group">

                    <label>Email</label>

                    <input
                        type="email"
                        id="newEmail"
                        required
                        placeholder="employee@example.com"
                    >

                </div>


                <div class="form-group">

                    <label>Department</label>

                    <input
                        type="text"
                        id="newDepartment"
                        placeholder="Development"
                    >

                </div>


                <div class="form-group">

                    <label>Designation</label>

                    <input
                        type="text"
                        id="newDesignation"
                        placeholder="Software Engineer"
                    >

                </div>

            </div>


            <div class="form-group">

                <label>Skills</label>

                <input
                    type="text"
                    id="newSkills"
                    placeholder="Java, SQL, Spring Boot"
                >

            </div>


            <div class="modal-actions">

                <button type="button"
                        class="secondary-action"
                        onclick="closeEmployeeModal()">

                    Cancel

                </button>

                <button type="submit"
                        class="primary-action">

                    Create Employee

                </button>

            </div>

        </form>

    </div>

</div>


<div id="toastContainer"></div>


<script src="assets/js/api.js"></script>

<script>

requireLogin();

let allEmployees = [];


/* ================= LOAD ================= */

async function loadEmployees() {

    try {

        allEmployees =
            await apiRequest("/employees");

        renderEmployees(allEmployees);

    } catch (error) {

        showToast(
            error.message ||
            "Unable to load employees.",
            "error"
        );

    }

}


/* ================= RENDER ================= */

function renderEmployees(employees) {

    const table =
        document.getElementById("employeeTable");

    document.getElementById("employeeCount")
        .textContent =
        `${employees.length} employee${employees.length === 1 ? "" : "s"}`;


    if (!employees.length) {

        table.innerHTML = `

            <tr>
                <td colspan="7"
                    class="table-empty">
                    No employees found.
                </td>
            </tr>

        `;

        return;

    }


    table.innerHTML =
        employees.map(employee => {

            const performance =
                Number(employee.currentPerformance || 0);


            const statusClass =
                employee.active
                    ? "status-active"
                    : "status-inactive";


            return `

                <tr>

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
                        ${employee.designation || "—"}
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
                            ${statusClass}
                        ">

                            ${
                                employee.active
                                    ? "Active"
                                    : "Inactive"
                            }

                        </span>

                    </td>


                    <td>

                        <button
                            class="table-action"
                            onclick="toggleEmployee(
                                ${employee.id},
                                ${employee.active}
                            )">

                            ${
                                employee.active
                                    ? "Deactivate"
                                    : "Activate"
                            }

                        </button>

                    </td>

                </tr>

            `;

        }).join("");

}


/* ================= SEARCH ================= */

function filterEmployees() {

    const search =
        document.getElementById(
            "employeeSearch"
        )
        .value
        .toLowerCase();


    const status =
        document.getElementById(
            "statusFilter"
        ).value;


    const filtered =
        allEmployees.filter(employee => {

            const matchesSearch =
                (
                    employee.fullName || ""
                )
                .toLowerCase()
                .includes(search)
                ||
                (
                    employee.username || ""
                )
                .toLowerCase()
                .includes(search)
                ||
                (
                    employee.department || ""
                )
                .toLowerCase()
                .includes(search);


            const matchesStatus =
                status === "all"
                ||
                (
                    status === "active"
                    && employee.active
                )
                ||
                (
                    status === "inactive"
                    && !employee.active
                );


            return matchesSearch &&
                   matchesStatus;

        });


    renderEmployees(filtered);

}


/* ================= ACTIVATE / DEACTIVATE ================= */

async function toggleEmployee(id, active) {

    try {

        await apiRequest(
            `/employees/${id}/${active ? "deactivate" : "activate"}`,
            {
                method: "PUT"
            }
        );


        showToast(
            active
                ? "Employee deactivated."
                : "Employee activated.",
            "success"
        );


        await loadEmployees();

    } catch (error) {

        showToast(
            error.message ||
            "Unable to update employee.",
            "error"
        );

    }

}


/* ================= MODAL ================= */

function openEmployeeModal() {

    document
        .getElementById("employeeModal")
        .classList.add("modal-visible");

}


function closeEmployeeModal() {

    document
        .getElementById("employeeModal")
        .classList.remove("modal-visible");

}


/* ================= CREATE ================= */

document
    .getElementById("employeeForm")
    .addEventListener(
        "submit",
        async function(event) {

            event.preventDefault();


            const employee = {

                username:
                    document.getElementById(
                        "newUsername"
                    ).value.trim(),

                password:
                    document.getElementById(
                        "newPassword"
                    ).value,

                fullName:
                    document.getElementById(
                        "newFullName"
                    ).value.trim(),

                email:
                    document.getElementById(
                        "newEmail"
                    ).value.trim(),

                department:
                    document.getElementById(
                        "newDepartment"
                    ).value.trim(),

                designation:
                    document.getElementById(
                        "newDesignation"
                    ).value.trim(),

                skills:
                    document.getElementById(
                        "newSkills"
                    ).value.trim()

            };


            try {

                await apiRequest(
                    "/employees",
                    {
                        method: "POST",
                        body: JSON.stringify(employee)
                    }
                );


                showToast(
                    "Employee created successfully.",
                    "success"
                );


                document
                    .getElementById("employeeForm")
                    .reset();


                closeEmployeeModal();

                await loadEmployees();


            } catch (error) {

                showToast(
                    error.message ||
                    "Unable to create employee.",
                    "error"
                );

            }

        }
    );


loadEmployees();

</script>


<style>

/* EMPLOYEE TOOLBAR */

.employee-toolbar {

    display: flex;
    gap: 12px;
    align-items: center;
    margin-bottom: 18px;

}


.search-box {

    flex: 1;

    display: flex;
    align-items: center;
    gap: 10px;

    padding: 10px 13px;

    border-radius: 9px;

    background: rgba(255,255,255,0.025);

    border: 1px solid rgba(255,255,255,0.07);

}


.search-box span {

    color: #637187;

}


.search-box input {

    width: 100%;

    border: 0;
    outline: 0;

    background: transparent;

    color: #dbe5f5;

    font-size: 12px;

}


.employee-toolbar select {

    min-width: 150px;

    padding: 11px;

    border-radius: 9px;

    background: #151f2d;

    border: 1px solid rgba(255,255,255,0.07);

    color: #aab6c8;

}


/* TABLE */

.employee-table-card {

    margin-bottom: 20px;

}


.record-count {

    color: #68778d;

    font-size: 10px;

}


.table-action {

    border: 1px solid rgba(255,255,255,0.08);

    background: rgba(255,255,255,0.03);

    color: #8eacdf;

    border-radius: 7px;

    padding: 6px 9px;

    cursor: pointer;

    font-size: 9px;

    transition: 0.2s;

}


.table-action:hover {

    background: rgba(59,130,246,0.12);

}


.status-active {

    color: #72c89b;

    background: rgba(34,197,94,0.09);

}


.status-inactive {

    color: #ef8585;

    background: rgba(239,68,68,0.09);

}


/* MODAL */

.modal-overlay {

    position: fixed;

    inset: 0;

    display: none;

    align-items: center;

    justify-content: center;

    background: rgba(2,6,14,0.78);

    backdrop-filter: blur(8px);

    z-index: 1000;

}


.modal-overlay.modal-visible {

    display: flex;

}


.modal-card {

    width: min(600px, calc(100% - 35px));

    background: #101925;

    border: 1px solid rgba(255,255,255,0.08);

    border-radius: 16px;

    padding: 25px;

    box-shadow: 0 30px 80px rgba(0,0,0,0.5);

    animation: modalIn 0.22s ease;

}


@keyframes modalIn {

    from {
        opacity: 0;
        transform: translateY(15px) scale(0.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

}


.modal-header {

    display: flex;

    justify-content: space-between;

    margin-bottom: 22px;

}


.modal-header h2 {

    margin: 7px 0 0;

}


.modal-close {

    width: 32px;
    height: 32px;

    border: 0;

    border-radius: 8px;

    background: rgba(255,255,255,0.05);

    color: #8997aa;

    font-size: 20px;

    cursor: pointer;

}


.form-grid {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 13px;

}


.form-group {

    margin-bottom: 14px;

}


.form-group label {

    display: block;

    margin-bottom: 6px;

    color: #7d8ba0;

    font-size: 10px;

}


.form-group input {

    width: 100%;

    box-sizing: border-box;

    padding: 11px;

    border-radius: 8px;

    border: 1px solid rgba(255,255,255,0.07);

    outline: none;

    background: #0c141f;

    color: #dce6f6;

    font-size: 11px;

}


.form-group input:focus {

    border-color: rgba(59,130,246,0.55);

}


.modal-actions {

    display: flex;

    justify-content: flex-end;

    gap: 9px;

    margin-top: 12px;

}


.secondary-action {

    padding: 10px 15px;

    border-radius: 9px;

    border: 1px solid rgba(255,255,255,0.08);

    background: transparent;

    color: #8795a9;

    cursor: pointer;

    font-size: 11px;

}


@media (max-width: 700px) {

    .employee-toolbar {

        flex-direction: column;

        align-items: stretch;

    }

    .form-grid {

        grid-template-columns: 1fr;

    }

}

</style>

</body>
</html>