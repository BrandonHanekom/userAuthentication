<?php
include 'connection.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'librarian') {
    header("Location: signIn.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookIdToEdit = $_POST["book_id_to_edit"];
    $newBookName = $_POST["new_book_name"];
    $newAuthorName = $_POST["new_author_name"];
    $newYear = $_POST["new_year"];
    $newGenre = $_POST["new_genre"];
    $newAgeGroup = $_POST["new_age_group"];

    // Perform the database update for editing a book
    $updateQuery = "UPDATE books SET book_name = '$newBookName', author_name = '$newAuthorName', year = '$newYear', genre = '$newGenre', age_group = '$newAgeGroup' WHERE book_id = '$bookIdToEdit'";
    // ...

    header("Location: index.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Edit Book</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="book_id_to_edit" class="form-label">Book ID to Edit:</label>
                <input type="text" id="book_id_to_edit" name="book_id_to_edit" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="new_book_name" class="form-label">New Book Name:</label>
                <input type="text" id="new_book_name" name="new_book_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="new_author_name" class="form-label">New Author Name:</label>
                <input type="text" id="new_author_name" name="new_author_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="new_year" class="form-label">New Year:</label>
                <input type="text" id="new_year" name="new_year" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="new_genre" class="form-label">New Genre:</label>
                <input type="text" id="new_genre" name="new_genre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="new_age_group" class="form-label">New Age Group:</label>
                <input type="text" id="new_age_group" name="new_age_group" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-warning">Edit Book</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>