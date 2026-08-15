<?php

session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION["user_id"];
$userName = $_SESSION["user_name"];

$budget = 0;
$totalSpent = 0;
$remaining = 0;
$totalTasks = 0;
$completedTasks = 0;
$pendingTasks = 0;

$stmt = $conn->prepare(
    "SELECT amount FROM budgets WHERE user_id = ?"
);

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $budget = $result->fetch_assoc()["amount"];
}

$stmt->close();

$stmt = $conn->prepare(
    "SELECT COALESCE(SUM(amount), 0) AS total
     FROM expenses
     WHERE user_id = ?"
);

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $totalSpent = $result->fetch_assoc()["total"];
}

$stmt->close();

$remaining = $budget - $totalSpent;

$stmt = $conn->prepare(
    "SELECT
        COUNT(*) AS total,
        SUM(CASE WHEN completed = 1 THEN 1 ELSE 0 END) AS completed
     FROM tasks
     WHERE user_id = ?"
);

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $taskData = $result->fetch_assoc();

    $totalTasks = $taskData["total"];
    $completedTasks = $taskData["completed"] ?? 0;
}

$stmt->close();

$pendingTasks = $totalTasks - $completedTasks;

require_once "includes/header.php";

?>

<main>

    <section class="dashboard">

        <h2>Welcome, <?php echo htmlspecialchars($userName); ?>!</h2>

        <p>Here's an overview of your student activity.</p>

        <div class="dashboard-section">

            <h3>Budget Overview</h3>

            <p>
                Budget:
                <strong>R<?php echo number_format($budget, 2); ?></strong>
            </p>

            <p>
                Spent:
                <strong>R<?php echo number_format($totalSpent, 2); ?></strong>
            </p>

            <p>
                Remaining:
                <strong>R<?php echo number_format($remaining, 2); ?></strong>
            </p>

        </div>

        <div class="dashboard-section">

            <h3>Academic Tasks</h3>

            <p>
                Total Tasks:
                <strong><?php echo $totalTasks; ?></strong>
            </p>

            <p>
                Completed:
                <strong><?php echo $completedTasks; ?></strong>
            </p>

            <p>
                Not Completed:
                <strong><?php echo $pendingTasks; ?></strong>
            </p>

        </div>

    </section>

</main>

<footer>

    <p>&copy; 2026 CampusPulse</p>

</footer>

</body>

</html>