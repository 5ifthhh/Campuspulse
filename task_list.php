<?php

session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT id, title, description, due_date, completed
     FROM task
     WHERE user_id = ?
     ORDER BY due_date ASC"
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

    <title>My Tasks - CampusPulse</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>CampusPulse</h1>
    <p>Student Budget & Task Manager</p>
</header>

<main>

    <section>

        <h2>My Academic Tasks</h2>

        <?php if ($result->num_rows > 0): ?>

            <table border="1" cellpadding="10">

                <tr>
                    <th>Task</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php while ($task = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($task["title"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($task["description"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($task["due_date"]); ?>
                        </td>

                        <td>
                            <?php
                            if ($task["completed"] == 1) {
                                echo "Completed";
                            } else {
                                echo "Not completed";
                            }
                            ?>
                        </td>

                        <td>

                            <?php if ($task["completed"] == 0): ?>

                                <a href="complete_task.php?id=<?php echo $task["id"]; ?>">
                                    Complete
                                </a>

                            <?php else: ?>

                                Done

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

            </table>

        <?php else: ?>

            <p>You don't have any tasks yet.</p>

        <?php endif; ?>

        <br>

        <a href="tasks.php">Add Another Task</a>

        <br><br>

        <a href="dashboard.php">Back to Dashboard</a>

    </section>

</main>

<footer>
    <p>&copy; 2026 CampusPulse</p>
</footer>

</body>

</html>