<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tasks | Employee Performance</title>

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


        <nav class="sidebar-nav" id="sidebarNav">

            <!-- JavaScript builds navigation -->

        </nav>


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
                    TASK MANAGEMENT
                </p>

                <h1>
                    Tasks
                </h1>

                <p class="page-subtitle"
                   id="taskSubtitle">
                    Manage assigned work and task completion.
                </p>

            </div>


            <button
                id="createTaskButton"
                class="primary-action"
                onclick="openTaskModal()"
                style="display:none;">

                + Assign Task

            </button>

        </header>


        <!-- EMPLOYEE SELECTOR -->

        <section
            id="employeeSelectorCard"
            class="dashboard-card"
            style="display:none; margin-bottom:18px;">

            <div class="form-group">

                <label>
                    Select Employee
                </label>

                <select
                    id="employeeSelector"
                    onchange="loadSelectedEmployeeTasks()">

                </select>

            </div>

        </section>


        <!-- TASK STATS -->

        <section class="stats-grid">

            <div class="stat-card">

                <div class="stat-icon">
                    ✓
                </div>

                <div>

                    <span>Total Tasks</span>

                    <strong id="totalTasks">
                        --
                    </strong>

                    <small>assigned</small>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    ✓
                </div>

                <div>

                    <span>Completed</span>

                    <strong id="completedTasks">
                        --
                    </strong>

                    <small>finished</small>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    !
                </div>

                <div>

                    <span>Pending</span>

                    <strong id="pendingTasks">
                        --
                    </strong>

                    <small>remaining</small>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    %
                </div>

                <div>

                    <span>Completion Rate</span>

                    <strong id="completionRate">
                        --
                    </strong>

                    <small>overall</small>

                </div>

            </div>

        </section>


        <!-- TASK TABLE -->

        <section class="dashboard-card">

            <div class="card-header">

                <div>

                    <span class="card-label">
                        WORK ITEMS
                    </span>

                    <h2>
                        Task List
                    </h2>

                </div>

            </div>


            <div class="table-container">

                <table class="manager-table">

                    <thead>

                    <tr>

                        <th>Task</th>
                        <th>Assigned</th>
                        <th>Deadline</th>
                        <th>Completed</th>
                        <th>Quality</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                    </thead>

                    <tbody id="taskTable">

                    <tr>

                        <td colspan="7"
                            class="table-loading">

                            Loading tasks...

                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</div>


<!-- TASK MODAL -->

<div id="taskModal"
     class="modal-overlay">

    <div class="modal-card">

        <div class="modal-header">

            <div>

                <span class="card-label">
                    NEW TASK
                </span>

                <h2>
                    Assign Task
                </h2>

            </div>

            <button class="modal-close"
                    onclick="closeTaskModal()">

                ×

            </button>

        </div>


        <form id="taskForm">

            <div class="form-group">

                <label>
                    Employee
                </label>

                <select
                    id="taskEmployee"
                    required>

                </select>

            </div>


            <div class="form-group">

                <label>
                    Task Title
                </label>

                <input
                    id="taskTitle"
                    required
                    placeholder="Complete monthly report">

            </div>


            <div class="form-group">

                <label>
                    Description
                </label>

                <textarea
                    id="taskDescription"
                    rows="4"
                    placeholder="Task details..."></textarea>

            </div>


            <div class="form-group">

                <label>
                    Deadline
                </label>

                <input
                    type="date"
                    id="taskDeadline"
                    required>

            </div>


            <div class="modal-actions">

                <button
                    type="button"
                    class="secondary-action"
                    onclick="closeTaskModal()">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="primary-action">

                    Assign Task

                </button>

            </div>

        </form>

    </div>

</div>


<div id="toastContainer"></div>


<script src="assets/js/api.js"></script>

<script>

requireLogin();

const role =
    getRole();

let employees = [];

let currentTasks = [];


/* ================= NAVIGATION ================= */

function buildNavigation() {

    const nav =
        document.getElementById(
            "sidebarNav"
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
               class="nav-link active">
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

        `;


        document.getElementById(
            "createTaskButton"
        ).style.display = "block";


        document.getElementById(
            "employeeSelectorCard"
        ).style.display = "block";


    } else {

        nav.innerHTML = `

            <a href="employee-dashboard.php"
               class="nav-link">
                <span>▣</span>
                Dashboard
            </a>

            <a href="tasks.php"
               class="nav-link active">
                <span>✓</span>
                My Tasks
            </a>

            <a href="ranking.php"
               class="nav-link">
                <span>★</span>
                Ranking
            </a>

        `;

    }

}


/* ================= LOAD ================= */

async function initialize() {

    buildNavigation();


    try {

        if (role === "MANAGER") {

            employees =
                await apiRequest(
                    "/employees/active"
                );


            populateEmployeeSelectors();


            if (employees.length > 0) {

                document.getElementById(
                    "employeeSelector"
                ).value =
                    employees[0].id;

                await loadTasks(
                    employees[0].id
                );

            }

        } else {

            await loadTasks(
                getUserId()
            );

        }

    } catch (error) {

        showToast(
            error.message ||
            "Unable to initialize tasks.",
            "error"
        );

    }

}


/* ================= SELECTORS ================= */

function populateEmployeeSelectors() {

    const options =
        employees.map(
            employee => `

                <option value="${employee.id}">
                    ${
                        employee.fullName ||
                        employee.username
                    }
                </option>

            `
        )
        .join("");


    document.getElementById(
        "employeeSelector"
    ).innerHTML = options;


    document.getElementById(
        "taskEmployee"
    ).innerHTML = options;

}


function loadSelectedEmployeeTasks() {

    const id =
        document.getElementById(
            "employeeSelector"
        ).value;


    if (id) {

        loadTasks(id);

    }

}


/* ================= TASKS ================= */

async function loadTasks(employeeId) {

    try {

        currentTasks =
            await apiRequest(
                `/tasks/employee/${employeeId}`
            );


        if (!Array.isArray(currentTasks)) {

            currentTasks = [];

        }


        renderStats();

        renderTasks();

    } catch (error) {

        showToast(
            error.message ||
            "Unable to load tasks.",
            "error"
        );

    }

}


/* ================= STATS ================= */

function renderStats() {

    const total =
        currentTasks.length;


    const completed =
        currentTasks.filter(
            task => task.completed
        ).length;


    const pending =
        total - completed;


    const rate =
        total > 0
            ? (completed / total) * 100
            : 0;


    document.getElementById(
        "totalTasks"
    ).textContent = total;


    document.getElementById(
        "completedTasks"
    ).textContent = completed;


    document.getElementById(
        "pendingTasks"
    ).textContent = pending;


    document.getElementById(
        "completionRate"
    ).textContent =
        `${rate.toFixed(0)}%`;

}


/* ================= RENDER ================= */

function renderTasks() {

    const table =
        document.getElementById(
            "taskTable"
        );


    if (!currentTasks.length) {

        table.innerHTML = `

            <tr>

                <td colspan="7"
                    class="table-empty">

                    No tasks found.

                </td>

            </tr>

        `;

        return;

    }


    table.innerHTML =
        currentTasks.map(task => {

            const completed =
                task.completed;


            const deadline =
                task.deadline
                    ? new Date(
                        task.deadline
                    ).toLocaleDateString()
                    : "—";


            const assigned =
                task.assignedDate
                    ? new Date(
                        task.assignedDate
                    ).toLocaleDateString()
                    : "—";


            let status =
                completed
                    ? "Completed"
                    : "Pending";


            if (
                !completed &&
                task.deadline &&
                new Date(task.deadline) <
                new Date()
            ) {

                status = "Overdue";

            }


            let action = "—";


            if (role === "EMPLOYEE") {

                if (!completed) {

                    action = `

                        <button
                            class="table-action"
                            onclick="completeTask(${task.id})">

                            Complete

                        </button>

                    `;

                }

            }


            if (role === "MANAGER") {

                action = `

                    <button
                        class="table-action"
                        onclick="evaluateTask(${task.id})">

                        Evaluate

                    </button>

                `;

            }


            return `

                <tr>

                    <td>

                        <strong>
                            ${task.title || "Untitled"}
                        </strong>

                        <small class="task-description">
                            ${task.description || ""}
                        </small>

                    </td>


                    <td>
                        ${assigned}
                    </td>


                    <td>
                        ${deadline}
                    </td>


                    <td>
                        ${
                            task.completionDate
                                ? new Date(
                                    task.completionDate
                                ).toLocaleDateString()
                                : "—"
                        }
                    </td>


                    <td>

                        <strong>
                            ${
                                Number(
                                    task.qualityScore || 0
                                ).toFixed(0)
                            }
                        </strong>

                        /100

                    </td>


                    <td>

                        <span class="
                            status-badge
                            ${
                                status === "Completed"
                                    ? "status-active"
                                    : status === "Overdue"
                                        ? "status-inactive"
                                        : "status-warning"
                            }
                        ">

                            ${status}

                        </span>

                    </td>


                    <td>
                        ${action}
                    </td>

                </tr>

            `;

        }).join("");

}


/* ================= COMPLETE ================= */

async function completeTask(id) {

    try {

        await apiRequest(
            `/tasks/${id}/complete`,
            {
                method: "PUT"
            }
        );


        showToast(
            "Task marked as completed.",
            "success"
        );


        if (role === "MANAGER") {

            await loadSelectedEmployeeTasks();

        } else {

            await loadTasks(
                getUserId()
            );

        }

    } catch (error) {

        showToast(
            error.message ||
            "Unable to complete task.",
            "error"
        );

    }

}


/* ================= EVALUATE ================= */

async function evaluateTask(id) {

    const score =
        prompt(
            "Enter quality score (0 - 100):"
        );


    if (score === null) {
        return;
    }


    const quality =
        Number(score);


    if (
        Number.isNaN(quality) ||
        quality < 0 ||
        quality > 100
    ) {

        showToast(
            "Quality score must be between 0 and 100.",
            "error"
        );

        return;

    }


    try {

        await apiRequest(
            `/tasks/${id}/evaluate?qualityScore=${quality}`,
            {
                method: "PUT"
            }
        );


        showToast(
            "Task evaluated successfully.",
            "success"
        );


        await loadSelectedEmployeeTasks();

    } catch (error) {

        showToast(
            error.message ||
            "Unable to evaluate task.",
            "error"
        );

    }

}


/* ================= MODAL ================= */

function openTaskModal() {

    document
        .getElementById("taskModal")
        .classList.add("modal-visible");

}


function closeTaskModal() {

    document
        .getElementById("taskModal")
        .classList.remove("modal-visible");

}


/* ================= CREATE TASK ================= */

document
    .getElementById("taskForm")
    .addEventListener(
        "submit",
        async function(event) {

            event.preventDefault();


            const employeeId =
                document.getElementById(
                    "taskEmployee"
                ).value;


            const title =
                document.getElementById(
                    "taskTitle"
                ).value.trim();


            const description =
                document.getElementById(
                    "taskDescription"
                ).value.trim();


            const deadline =
                document.getElementById(
                    "taskDeadline"
                ).value;


            try {

                const params =
                    new URLSearchParams({

                        employeeId,
                        title,
                        description,
                        deadline

                    });


                await apiRequest(
                    `/tasks?${params.toString()}`,
                    {
                        method: "POST"
                    }
                );


                showToast(
                    "Task assigned successfully.",
                    "success"
                );


                document
                    .getElementById("taskForm")
                    .reset();


                closeTaskModal();


                const selected =
                    document.getElementById(
                        "employeeSelector"
                    ).value;


                await loadTasks(selected);

            } catch (error) {

                showToast(
                    error.message ||
                    "Unable to create task.",
                    "error"
                );

            }

        }
    );


initialize();

</script>


<style>

.task-description {

    display: block;

    margin-top: 4px;

    max-width: 230px;

    color: #5e6d82;

    font-size: 9px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

}


#employeeSelector,
#taskEmployee {

    width: 100%;

    padding: 11px;

    box-sizing: border-box;

    border-radius: 8px;

    background: #0c141f;

    color: #dce6f6;

    border: 1px solid rgba(255,255,255,0.07);

}


textarea {

    width: 100%;

    box-sizing: border-box;

    resize: vertical;

    padding: 11px;

    border-radius: 8px;

    border: 1px solid rgba(255,255,255,0.07);

    outline: none;

    background: #0c141f;

    color: #dce6f6;

    font-family: inherit;

    font-size: 11px;

}


textarea:focus,
select:focus {

    border-color:
        rgba(59,130,246,0.55);

}

</style>

</body>
</html>