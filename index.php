<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the database
include 'connection.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or perform other actions for non-logged-in users
    header("Location: signIn.php");
    exit();
}

// Fetch the user's role from the session
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'member';  // Change 'role' to the actual session variable storing the role

// Fetch books and authors data from the tables
$sql = "SELECT books.book_id, books.book_name, authors.author_name, books.year, books.genre, books.age_group
        FROM books
        INNER JOIN authors ON books.author_id = authors.author_id";

if (!empty($_GET['search'])) {
    // Modify the SQL query to include the search condition
    $searchQuery = $_GET['search'];

    // Apply different search conditions based on the user's role
    if ($userRole === 'librarian') {
        // Librarian can search for both book names and authors
        $sql .= " WHERE 
            books.book_name LIKE '%$searchQuery%' OR
            authors.author_name LIKE '%$searchQuery%' OR
            books.year LIKE '%$searchQuery%' OR
            books.genre LIKE '%$searchQuery%' OR
            books.age_group LIKE '%$searchQuery%' OR
            authors.age LIKE '%$searchQuery%'";
    } else {
        // Members can only search for book names
        $sql .= " WHERE 
            books.book_name LIKE '%$searchQuery%' OR
            books.year LIKE '%$searchQuery%' OR
            books.genre LIKE '%$searchQuery%' OR
            books.age_group LIKE '%$searchQuery%'";
    }
}

if (!empty($_GET['sort'])) {
    $sortValue = $_GET['sort'];
    $sql .= " ORDER BY $sortValue";
}

// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Check for SQL errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Library Index</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div>
        <nav class="navbar navbar-light mb-3" style="background-color: #e3f2fd">
            <a class="navbar-brand">
                <h2 class="m-2">Library
                    <picture>
                        <!-- Specify the source for larger screens -->
                        <source media="(min-width: 768px)" srcset="images/library.png">
                        <!-- Specify the default source for smaller screens -->
                        <img src="images/library.png" alt="Website Logo" width="50" height="50">
                    </picture>
                </h2>
            </a>
            <form class="form-inline" method="GET" action="index.php">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </nav>
    </div>
    <div class="container">
        <?php if ($userRole === 'librarian') : ?>
            <a href="addBook.php" class="btn btn-success mb-2">Add Book</a>
        <?php endif; ?>
        <table class="table table-bordered border-primary">
            <thead>
                <tr>
                    <th><a href="index.php?sort=book_name" class="btn btn-primary">Book Name</a></th>
                    <th><a href="index.php?sort=author_name" class="btn btn-primary">Author Name</a></th>
                    <th><a href="index.php?sort=year" class="btn btn-primary">Year</a></th>
                    <th><a href="index.php?sort=genre" class="btn btn-primary">Genre</a></th>
                    <th><a href="index.php?sort=age_group" class="btn btn-primary">Age Group</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Assuming $result is the result from your database query
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display book information in table rows
                    echo "<tr>";
                    echo "<td>" . $row["book_name"] . "</td>";      // Display Book Name
                    echo "<td>" . $row["author_name"] . "</td>";    // Display Author Name
                    echo "<td>" . $row["year"] . "</td>";           // Display Year
                    echo "<td>" . $row["genre"] . "</td>";          // Display Genre
                    echo "<td>" . $row["age_group"] . "</td>";      // Display Age Group

                    // Check if 'book_id' key exists in the $row array
                    if (array_key_exists('book_id', $row) && $userRole === 'librarian') {

                        // Insert the following line for the Delete button
                        echo "<td><a href='deleteBook.php?book_id=" . $row['book_id'] . "' class='btn btn-danger'>Delete</a></td>";
                    }

                    echo "</tr>";
                }
                ?>


            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>