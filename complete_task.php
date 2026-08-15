<?php

session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: task_list.php");
    exit;
}

$taskId = (int) $_GET["id"];
$userId = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "UPDATE tasks
     SET completed = 1
     WHERE id = ? AND user_id = ?"
);

$stmt->bind_param("ii", $taskId, $userId);
$stmt->execute();

$stmt->close();

header("Location: task_list.php");
exit;

?>