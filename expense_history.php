<?php

session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT description, amount, expense_date
     FROM expenses
     WHERE user_id = ?
     ORDER BY expense_date DESC"
);

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Expense History - CampusPulse</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>CampusPulse</h1>
    <p>Student Budget & Task Manager</p>
</header>

<main>

    <section>

        <h2>Expense History</h2>

        <?php if ($result->num_rows > 0): ?>

            <table border="1" cellpadding="10">

                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>

                <?php while ($expense = $result->fetch_assoc()): ?>

                    <tr>
                        <td>
                            <?php echo htmlspecialchars($expense["description"]); ?>
                        </td>

                        <td>
                            R<?php echo number_format($expense["amount"], 2); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($expense["expense_date"]); ?>
                        </td>
                    </tr>

                <?php endwhile; ?>

            </table>

        <?php else: ?>

            <p>You haven't added any expenses yet.</p>

        <?php endif; ?>

        <br>

        <a href="expenses.php">Add another expense</a>

        <br><br>

        <a href="dashboard.php">Back to Dashboard</a>

    </section>

</main>

<footer>
    <p>&copy; 2026 CampusPulse</p>
</footer>

</body>

</html>