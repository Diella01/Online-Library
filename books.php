<?php
session_start();
require "config/Database.php";

// Merr librat nga databaza
$sql = "SELECT * FROM books ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Books - Celestial Library</title>
<link rel="stylesheet" href="css/style.css">
<style>
.books-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin: 20px;
}
.book-item {
    width: 220px;
    background-color: #f9f3e7;
    border: 1px solid #e0c1a0;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
}
.book-item img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 10px;
}
.book-item h3 {
    font-family: Georgia, 'Times New Roman', Times, serif;
    color: #b86b00;
    margin: 5px 0;
}
.book-item p {
    font-size: 14px;
    color: #5a3e2b;
}
</style>
</head>
<body>

<header style="text-align:center; padding:20px; background-color:#f7d7c4;">
    <h1>Celestial Library - Our Books</h1>
    <nav>
        <a href="index.php">Home</a> | 
        <a href="books.php">Books</a> | 
        <a href="about.php">About Us</a> | 
        <a href="contact.php">Contact</a>
    </nav>
</header>

<div class="books-container">
<?php if($result->num_rows > 0): ?>
    <?php while($book = $result->fetch_assoc()): ?>
        <div class="book-item">
            <?php if($book['cover_image']): ?>
                <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
            <?php else: ?>
                <img src="uploads/default.png" alt="No image">
            <?php endif; ?>
            <h3><?= htmlspecialchars($book['title']) ?></h3>
            <p><?= htmlspecialchars($book['description']) ?></p>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No books found!</p>
<?php endif; ?>
</div>

</body>
</html>
