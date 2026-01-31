<?php
session_start();
require_once "config/Database.php";

$db = new Database();
$conn = $db->connect();

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Merr dhe pastro të dhënat
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $birthdate = trim($_POST['birthdate']);
    $gender = $_POST['gender'] ?? '';
    $phone = trim($_POST['phone']);
    $city = trim($_POST['city']);
    $terms = isset($_POST['terms']) ? 1 : 0;

    // Validim
    if (empty($name) || empty($email) || empty($password) || empty($birthdate) || empty($gender) || empty($phone) || empty($city)) {
        $error = "Please fill in all fields!";
    } elseif (!$terms) {
        $error = "You must accept Terms and Conditions!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        // Kontrollo nëse email-i ekziston
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $error = "This email is already in use!";
        } else {
            // Hash i fjalëkalimit
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Role default
            $role = "user";

            // Insert në databazë
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, birthdate, gender, phone, city) VALUES (:name, :email, :password, :role, :birthdate, :gender, :phone, :city)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":role", $role);
            $stmt->bindParam(":birthdate", $birthdate);
            $stmt->bindParam(":gender", $gender);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":city", $city);

            if ($stmt->execute()) {
                // Redirect tek login.php me mesazh sukses
                header("Location: login.php?register=success");
                exit;
            } else {
                $error = "Something went wrong. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Reg.css">
    <script>
        // Validim front-end
        function validateForm() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            if (!email.includes("@")) {
                alert("Enter a valid email!");
                return false;
            }
            if (password.length < 6) {
                alert("Password must be at least 6 characters!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<div class="box">
    <h3>Register</h3>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" onsubmit="return validateForm()">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Name and surname" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password" required><br><br>

        <label for="birthdate">Ditelindja:</label>
        <input type="date" id="birthdate" name="birthdate" required><br><br>

        <label>Gender:</label>
        <input type="radio" id="female" name="gender" value="F" required>
        <label for="female">F</label>
        <input type="radio" id="male" name="gender" value="M" required>
        <label for="male">M</label><br><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" placeholder="Phone number" required><br><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" placeholder="City" required><br><br>

        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">I accept Terms and Conditions</label><br><br>

        <button type="submit">Register</button>
    </form>
</div>
</body>
</html>
