<?php

session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";
$userId = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $amount = trim($_POST["amount"]);

    if ($amount === "" || !is_numeric($amount) || $amount <= 0) {
        $message = "Please enter a valid budget amount.";
    } else {

        $check = $conn->prepare("SELECT id FROM budgets WHERE user_id = ?");
        $check->bind_param("i", $userId);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $stmt = $conn->prepare(
                "UPDATE budgets SET amount = ? WHERE user_id = ?"
            );

            $stmt->bind_param("di", $amount, $userId);

        } else {

            $stmt = $conn->prepare(
                "INSERT INTO budgets (user_id, amount) VALUES (?, ?)"
            );

            $stmt->bind_param("id", $userId, $amount);
        }

        if ($stmt->execute()) {
            $message = "Budget saved successfully.";
        } else {
            $message = "Could not save your budget.";
        }

        $stmt->close();
        $check->close();
    }
}

$budget = 0;

$stmt = $conn->prepare("SELECT amount FROM budgets WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $budget = $result->fetch_assoc()["amount"];
}

$stmt->close();

$totalSpent = 0;

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

$remaining = $budget - $totalSpent;?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Budget - CampusPulse</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>CampusPulse</h1>
    <p>Student Budget & Task Manager</p>
</header>

<main>

    <section>

        <h2>Student Budget</h2>

        <?php if ($message !== ""): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <p>
    Current budget:
    <strong>R<?php echo number_format($budget, 2); ?></strong>
</p>

<p>
    Total spent:
    <strong>R<?php echo number_format($totalSpent, 2); ?></strong>
</p>

<p>
    Remaining:
    <strong>R<?php echo number_format($remaining, 2); ?></strong>
</p>

        <form method="POST" action="budget.php">

            <label for="amount">Set your budget</label>
            <br>

            <input
                type="number"
                id="amount"
                name="amount"
                step="0.01"
                min="0.01"
                required
            >

            <br><br>

            <button type="submit">Save Budget</button>

        </form>

        <br>

        <a href="expenses.php">Add Expense</a>

        <br><br>

        <a href="expense_history.php">View Expense History</a>

        <br><br>

        <a href="dashboard.php">Back to Dashboard</a>

    </section>

</main>

<footer>
    <p>&copy; 2026 CampusPulse</p>
</footer>

</body>

</html>