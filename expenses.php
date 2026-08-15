<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $description = trim($_POST["description"]);
    $amount = trim($_POST["amount"]);
    $expenseDate = $_POST["expense_date"];

    if ($description === "" || $amount === "" || $expenseDate === "") {
        $message = "Please complete all fields.";
    } elseif (!is_numeric($amount) || $amount <= 0) {
        $message = "Please enter a valid amount.";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO expenses (user_id, description, amount, expense_date)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "isds",
            $_SESSION["user_id"],
            $description,
            $amount,
            $expenseDate
        );

        if ($stmt->execute()) {
            $message = "Expense added successfully.";
        } else {
            $message = "Could not add the expense.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Expenses - CampusPulse</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>CampusPulse</h1>
    <p>Student Budget & Task Manager</p>
</header>

<main>

    <section>

        <h2>Add Expense</h2>

        <?php if ($message !== ""): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST" action="expenses.php">

            <label for="description">What did you spend money on?</label>
            <br>

            <input
                type="text"
                id="description"
                name="description"
                required
            >

            <br><br>

            <label for="amount">Amount</label>
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

            <label for="expense_date">Date</label>
            <br>

            <input
                type="date"
                id="expense_date"
                name="expense_date"
                required
            >

            <br><br>

            <button type="submit">Add Expense</button>

        </form>

        <br>

        <a href="dashboard.php">Back to Dashboard</a>

    </section>

</main>

<footer>
    <p>&copy; 2026 CampusPulse</p>
</footer>

</body>

</html>