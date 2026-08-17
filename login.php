<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($email === "" || $password === "") {
        $message = "Please enter your email and password.";
    } else {

        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];

                header("Location: dashboard.php");
                exit;

            } else {
                $message = "Incorrect email or password.";
            }

        } else {
            $message = "Incorrect email or password.";
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
    <title>Login - CampusPulse</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>CampusPulse</h1>
    <p>Student Budget & Task Manager</p>
</header>

<main>

    <section>

        <h2>Login</h2>

        <?php if ($message !== ""): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">

            <label for="email">Email</label>
            <br>

            <input
                type="email"
                id="email"
                name="email"
                required
            >

            <br><br>

            <label for="password">Password</label>
            <br>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

            <br><br>

            <button type="submit">Login</button>

        </form>

        <p>Don't have an account?</p>

        <a href="register.php">Create an account</a>

    </section>

</main>

<footer>
    <p>&copy; 2026 CampusPulse</p>
</footer>

</body>

</html>