<?php
include 'connection.php';

// Check if book_id is set in the URL
if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];

    // Construct the SQL query for deletion
    $sql = "DELETE FROM books WHERE book_id = '$bookId'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to a success page or perform other actions
        header("Location: index.php");
        exit();
    } else {
        // Handle the case where the deletion fails
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Handle the case where book_id is not set
    echo "Invalid request. Please provide a book ID.";
}

// Close the database connection
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