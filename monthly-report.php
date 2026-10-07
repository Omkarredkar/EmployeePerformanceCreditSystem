<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Performance Report</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            margin: 0;
            background: #0b1120;
            color: #e5e7eb;
            font-family: Arial, sans-serif;
        }

        .report-page {
            min-height: 100vh;
            padding: 30px;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .report-header h1 {
            margin: 0;
            font-size: 28px;
        }

        .report-header p {
            color: #94a3b8;
            margin-top: 8px;
        }

        .back-btn {
            padding: 10px 18px;
            border-radius: 8px;
            border: 1px solid #334155;
            background: #111827;
            color: #e5e7eb;
            text-decoration: none;
            cursor: pointer;
        }

        .back-btn:hover {
            background: #1e293b;
        }

        .report-card {
            background: #111827;
            border: 1px solid #1e293b;
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .report-card h2 {
            margin-top: 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .info-box {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 10px;
            padding: 18px;
        }

        .info-label {
            color: #94a3b8;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 22px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #1e293b;
        }

        .message {
            margin-top: 20px;
            padding: 14px;
            border-radius: 8px;
            background: #172033;
            color: #cbd5e1;
        }

        .error {
            color: #fca5a5;
            background: #3f1d1d;
        }

        @media (max-width: 700px) {
            .report-page {
                padding: 18px;
            }

            .report-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

<div class="report-page">

    <div class="report-header">
        <div>
            <h1>Monthly Performance Report</h1>
            <p id="welcomeText">Loading report...</p>
        </div>

        <a href="manager-dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>
    </div>

    <div class="report-card">

        <h2>Current Month Evaluation</h2>

        <div id="reportContent">
            <div class="message">
                Loading monthly performance data...
            </div>
        </div>

    </div>

</div>

<script src="assets/js/api.js"></script>

<script>
document.addEventListener("DOMContentLoaded", async () => {

    const username = getUsername();

    if (username) {
        document.getElementById("welcomeText").textContent =
            `Welcome, ${username}`;
    } else {
        document.getElementById("welcomeText").textContent =
            "Monthly employee performance evaluation";
    }

    const reportContent = document.getElementById("reportContent");

    try {

        const data = await apiRequest("/monthly-performance");

        if (!data || data.length === 0) {

            reportContent.innerHTML = `
                <div class="message">
                    No monthly performance evaluation has been generated yet.
                </div>
            `;

            return;
        }

        reportContent.innerHTML = data.map(item => `
            <div class="report-card">

                <h2>${item.employee?.fullName || "Employee"}</h2>

                <div class="info-grid">

                    <div class="info-box">
                        <div class="info-label">Month</div>
                        <div class="info-value">
                            ${item.month || "-"}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Performance Score</div>
                        <div class="info-value">
                            ${item.performanceScore ?? 0}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Rank</div>
                        <div class="info-value">
                            #${item.rankPosition ?? "-"}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Recommendation</div>
                        <div class="status">
                            ${item.recommendation || "CONTINUE"}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Approval Status</div>
                        <div class="status">
                            ${item.approved ? "APPROVED" : "PENDING"}
                        </div>
                    </div>

                </div>

            </div>
        `).join("");

    } catch (error) {

        console.error("Monthly report error:", error);

        reportContent.innerHTML = `
            <div class="message error">
                Unable to load the monthly report.
                <br><br>
                ${error.message || "Unknown error"}
            </div>
        `;
    }
});
</script>

</body>
</html>