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
$userId = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $dueDate = $_POST["due_date"];
    $priority = $_POST["priority"];

    if ($title === "" || $dueDate === "") {
        $message = "Please enter a title and due date.";
    } elseif (!in_array($priority, ["Low", "Medium", "High"])) {
        $message = "Please select a valid priority.";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO tasks (user_id, title, description, due_date, priority)
             VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "issss",
            $userId,
            $title,
            $description,
            $dueDate,
            $priority
        );

        if ($stmt->execute()) {
            $message = "Task added successfully.";
        } else {
            $message = "Could not add the task.";
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

    <title>Tasks - CampusPulse</title>

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
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST" action="tasks.php">

            <label for="title">Task Title</label>
            <br>

            <input
                type="text"
                id="title"
                name="title"
                required
            >

            <br><br>

            <label for="description">Description</label>
            <br>

            <textarea
                id="description"
                name="description"
                rows="4"
            ></textarea>

            <br><br>

            <label for="due_date">Due Date</label>
            <br>

            <input
                type="date"
                id="due_date"
                name="due_date"
                required
            >

            <br><br>

            <label for="priority">Priority</label>
            <br>

            <select id="priority" name="priority" required>
                <option value="">Select priority</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>

            <br><br>

            <button type="submit">Add Task</button>

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