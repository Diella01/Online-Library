<?php
session_start();
require_once "config/Database.php";

$db = new Database();
$conn = $db->connect();

// Merr librat nga databaza
$stmt = $conn->query("SELECT * FROM books ORDER BY created_at DESC");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="Home.css">
</head>
<body>

<header class="box">
    <div class="logo">Celestial Chapters</div>
</header>

<div class="text box">
    <h1>Welcome to Celestial Chapters</h1>
    <p>"A friend is a gift you give yourself"</p>
    <h2>Get your book</h2>
</div>

<br><br>

<!-- Butonat Sign In / Register ose Welcome mesazhi -->
<div class="boxes" style="display:flex; justify-content:center; gap:20px;">
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="box">
            <span>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></span>
        </div>
        <div class="box">
            <a href="logout.php">Logout</a>
        </div>
    <?php else: ?>
        <div class="box">
            <a href="login.php">Sign In</a>
        </div>
        <div class="box">
            <a href="register.php">Register</a>
        </div>
    <?php endif; ?>
</div>

<br><br>

<!-- Shtimi i librave nga databaza -->
<?php if (!empty($books)): ?>
    <div class="books-container box">
        <h2>Our Books</h2>
        <div class="books-list" style="display:flex; flex-wrap:wrap; justify-content:center; gap:20px;">
            <?php foreach ($books as $book): ?>
                <div class="book-item box" style="width:200px; text-align:center;">
                    <?php if (!empty($book['cover_image'])): ?>
                        <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" style="width:100%; height:auto; border-radius:5px; margin-bottom:10px;">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($book['title']) ?></h3>
                    <p><?= htmlspecialchars($book['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<br><br>

<footer class="footer box">
    <ul>
        <li><a href="#">2025 - Celestial Library</a></li>
        <li><a href="PrivacyPolicy.html">Privacy Policy</a></li>
        <li><a href="Terms.html">Terms</a></li>
        <li><a href="about.php">About us</a></li>
        <li><a href="contact.php">Contact us</a></li>
    </ul>
</footer>

</body>
</html>
