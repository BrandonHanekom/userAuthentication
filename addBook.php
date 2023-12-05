<?php
include 'connection.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'librarian') {
    header("Location: signIn.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookName = $_POST["book_name"];
    $authorName = $_POST["author_name"];
    $year = $_POST["year"];
    $genre = $_POST["genre"];
    $ageGroup = $_POST["age_group"];

    // Perform the database insertion for adding a new book
    $insertQuery = "INSERT INTO books (book_name, author_name, year, genre, age_group) VALUES ('$bookName', '$authorName', '$year', '$genre', '$ageGroup')";

    if ($conn->query($insertQuery) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add New Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Add New Book</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="book_name" class="form-label">Book Name:</label>
                <input type="text" id="book_name" name="book_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="author_name" class="form-label">Author Name:</label>
                <input type="text" id="author_name" name="author_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Year:</label>
                <input type="text" id="year" name="year" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre:</label>
                <input type="text" id="genre" name="genre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="age_group" class="form-label">Age Group:</label>
                <input type="text" id="age_group" name="age_group" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Add Book</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>