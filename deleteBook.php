<?php
include 'connection.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'librarian') {
    header("Location: signIn.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookIdToDelete = $_POST["book_id_to_delete"];

    // Perform the database deletion for deleting a book
    $deleteQuery = "DELETE FROM books WHERE book_id = '$bookIdToDelete'";
    // ...

    header("Location: index.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Delete Book</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="book_id_to_delete" class="form-label">Book ID to Delete:</label>
                <input type="text" id="book_id_to_delete" name="book_id_to_delete" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger">Delete Book</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>