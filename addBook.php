<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $bookName = $_POST["book_name"];
    $year = $_POST["year"];
    $genre = $_POST["genre"];
    $ageGroup = $_POST["age_group"];

    // Check if author_id is set and not empty
    $authorId = isset($_POST["author_id"]) ? $_POST["author_id"] : null;

    var_dump($_POST["author_id"]);

    // Check if author_id is a numeric value
    if ($authorId === null || !is_numeric($authorId)) {
        echo "Error: Invalid author_id.";
        exit();
    }

    // Construct the SQL query
    $sql = "INSERT INTO books (book_name, year, genre, age_group, author_id) 
            VALUES ('$bookName', '$year', '$genre', '$ageGroup', '$authorId')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to a success page or perform other actions
        header("Location: index.php");
        exit();

        exit();
    } else {
        // Handle the case where the insertion fails
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
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
                <label for="author_id" class="form-label">Author ID:</label>
                <input type="text" id="author_id" name="author_id" class="form-control" required>
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