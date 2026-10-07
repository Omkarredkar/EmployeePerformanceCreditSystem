document.addEventListener("DOMContentLoaded", function () {

    const token = sessionStorage.getItem("jwtToken");
    const role = sessionStorage.getItem("role");
    const fullName = sessionStorage.getItem("fullName");
    const username = sessionStorage.getItem("username");

    // Security check
    if (!token || role !== "MANAGER") {
        window.location.href = "login.php";
        return;
    }

    // Display manager information
    document.getElementById("managerName").textContent =
        fullName || "Manager";

    document.getElementById("managerUsername").textContent =
        username || "Manager";

    loadDashboard();

    // Logout
    document.getElementById("logoutButton")
        .addEventListener("click", function () {

            sessionStorage.clear();

            window.location.href = "login.php";
        });
});


async function apiRequest(url) {

    const token = sessionStorage.getItem("jwtToken");

    const response = await fetch(
        url,
        {
            method: "GET",

            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        }
    );

    if (response.status === 401 ||
        response.status === 403) {

        sessionStorage.clear();

        window.location.href = "login.php";

        return null;
    }

    if (!response.ok) {
        throw new Error(
            "API request failed: " + response.status
        );
    }

    return await response.json();
}


async function loadDashboard() {

    try {

        const employees =
            await apiRequest(
                "http://localhost:8080/api/employees"
            );

        if (!employees) {
            return;
        }

        const activeEmployees =
            await apiRequest(
                "http://localhost:8080/api/employees/active"
            );

        if (!activeEmployees) {
            return;
        }

        const ranking =
            await apiRequest(
                "http://localhost:8080/api/ranking"
            );

        if (!ranking) {
            return;
        }

        // ==========================
        // STATISTICS
        // ==========================

        document.getElementById("totalEmployees")
            .textContent = employees.length;

        document.getElementById("activeEmployees")
            .textContent = activeEmployees.length;


        let totalPerformance = 0;
        let totalCredits = 0;

        employees.forEach(employee => {

            totalPerformance +=
                Number(employee.currentPerformance || 0);

            totalCredits +=
                Number(employee.totalCredits || 0);

        });


        const averagePerformance =
            employees.length > 0
                ? totalPerformance / employees.length
                : 0;


        document.getElementById("averagePerformance")
            .textContent =
            averagePerformance.toFixed(1) + "%";


        document.getElementById("totalCredits")
            .textContent = totalCredits;


        // ==========================
        // TOP PERFORMER
        // ==========================

        if (ranking.length > 0) {

            const top = ranking[0];

            document.getElementById("topPerformer")
                .innerHTML = `

                    <div class="performer-name">
                        ${escapeHtml(top.fullName)}
                    </div>

                    <div class="performer-details">
                        ${escapeHtml(top.designation || "Employee")}
                    </div>

                    <div class="performer-score">
                        ${Number(top.currentPerformance || 0).toFixed(1)}%
                    </div>

                    <div class="performer-label">
                        Performance Score
                    </div>

                `;

        } else {

            document.getElementById("topPerformer")
                .textContent = "No ranking data available.";

        }


        // ==========================
        // RANKING TABLE
        // ==========================

        renderRanking(ranking);


    } catch (error) {

        console.error(error);

        document.getElementById("rankingTable")
            .innerHTML = `
                <div class="error-message">
                    Unable to load dashboard data.
                </div>
            `;
    }
}


function renderRanking(ranking) {

    if (!ranking || ranking.length === 0) {

        document.getElementById("rankingTable")
            .innerHTML =
            "<p>No ranking data available.</p>";

        return;
    }


    let html = `

        <table class="dashboard-table">

            <thead>

                <tr>
                    <th>Rank</th>
                    <th>Employee</th>
                    <th>Department</th>
                    <th>Performance</th>
                    <th>Credits</th>
                </tr>

            </thead>

            <tbody>
    `;


    ranking.slice(0, 5).forEach((employee, index) => {

        html += `

            <tr>

                <td>
                    <span class="rank-number">
                        ${index + 1}
                    </span>
                </td>

                <td>
                    <strong>
                        ${escapeHtml(employee.fullName)}
                    </strong>
                </td>

                <td>
                    ${escapeHtml(employee.department || "-")}
                </td>

                <td>
                    <strong>
                        ${Number(employee.currentPerformance || 0).toFixed(1)}%
                    </strong>
                </td>

                <td>
                    ${Number(employee.totalCredits || 0)}
                </td>

            </tr>

        `;
    });


    html += `
            </tbody>
        </table>
    `;


    document.getElementById("rankingTable")
        .innerHTML = html;
}


function escapeHtml(value) {

    const div = document.createElement("div");

    div.textContent = value ?? "";

    return div.innerHTML;
}