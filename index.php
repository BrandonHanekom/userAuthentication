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
$sql = "SELECT books.book_name, authors.author_name, books.year, books.genre, books.age_group
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

// Debugging: Output the SQL query
echo "SQL Query: $sql";

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
    <div class="container">
        <nav class="navbar navbar-light mb-5" style="background-color: #e3f2fd">
            <a class="navbar-brand">
                <h2>Library</h2>
            </a>
            <form class="form-inline" method="GET" action="index.php">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>

            <?php
            // Display add, edit, delete buttons based on user role
            if ($userRole === 'librarian') {
                echo '<a href="addBook.php" class="btn btn-success">Add Book</a>';
                echo '<a href="editBook.php" class="btn btn-warning">Edit Book</a>';
                echo '<a href="deleteBook.php" class="btn btn-danger">Delete Book</a>';
            }
            ?>
        </nav>

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
                // Display data in the table rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["book_name"] . "</td>";
                    echo "<td>" . $row["author_name"] . "</td>";
                    echo "<td>" . $row["year"] . "</td>";
                    echo "<td>" . $row["genre"] . "</td>";
                    echo "<td>" . $row["age_group"] . "</td>";
                    echo "</tr>";
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>