<?php

require_once "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($name === "" || $email === "" || $password === "") {
        $message = "Please complete all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "An account with that email already exists.";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
            );

            $stmt->bind_param("sss", $name, $email, $hashedPassword);

            if ($stmt->execute()) {
                $message = "Account created successfully. You can now log in.";
            } else {
                $message = "Something went wrong. Please try again.";
            }

            $stmt->close();
        }

        $check->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CampusPulse</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
    <h1>CampusPulse</h1>
    <p>Student Budget & Task Manager</p>
</header>

<main>
    <section>

        <h2>Create your account</h2>

        <?php if ($message !== ""): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST" action="register.php">

            <label for="name">Full Name</label>
            <br>
            <input type="text" id="name" name="name" required>

            <br><br>

            <label for="email">Email</label>
            <br>
            <input type="email" id="email" name="email" required>

            <br><br>

            <label for="password">Password</label>
            <br>
            <input type="password" id="password" name="password" required>

            <br><br>

            <button type="submit">Register</button>

        </form>

        <p>Already have an account?</p>
        <a href="login.php">Login here</a>

    </section>
</main>

<footer>
    <p>&copy; 2026 CampusPulse</p>
</footer>

</body>
</html>