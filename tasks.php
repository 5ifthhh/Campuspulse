<?php

session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION["user_id"];

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $dueDate = $_POST["due_date"];

    if ($title === "" || $dueDate === "") {

        $message = "Please enter a task title and due date.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO task (user_id, title, description, due_date, completed)
             VALUES (?, ?, ?, ?, 0)"
        );

        $stmt->bind_param(
            "isss",
            $userId,
            $title,
            $description,
            $dueDate
        );

        if ($stmt->execute()) {

            $message = "Task added successfully.";

        } else {

            $message = "Something went wrong. Please try again.";

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

    <title>Add Task - CampusPulse</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<header>

    <h1>CampusPulse</h1>

    <p>Student Budget & Task Manager</p>

</header>

<main>

    <section>

        <h2>Add Academic Task</h2>

        <?php if ($message !== ""): ?>

            <p>
                <?php echo htmlspecialchars($message); ?>
            </p>

        <?php endif; ?>

        <form method="POST" action="tasks.php">

            <label for="title">
                Task Title
            </label>

            <br>

            <input
                type="text"
                id="title"
                name="title"
                required
            >

            <br><br>

            <label for="description">
                Description
            </label>

            <br>

            <textarea
                id="description"
                name="description"
                rows="5"
            ></textarea>

            <br><br>

            <label for="due_date">
                Due Date
            </label>

            <br>

            <input
                type="date"
                id="due_date"
                name="due_date"
                required
            >

            <br><br>

            <button type="submit">
                Add Task
            </button>

        </form>

        <br>

        <a href="task_list.php">
            View My Tasks
        </a>

        <br><br>

        <a href="dashboard.php">
            Back to Dashboard
        </a>

    </section>

</main>

<footer>

    <p>&copy; 2026 CampusPulse</p>

</footer>

</body>

</html>