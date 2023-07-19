<?php // Connect to the database
include 'connection.php';
$sortValue = $_GET['sort'];
echo $sortValue;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Library Index</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Library</h2>
        <table class="table">
            <thead>
                <tr>
                    <!-- http://localhost:8080/userAuthentication/index.php?sort=book_name -->
                    <th>Book Name</th>
                    <th>Author Name</th>
                    <th>Year</th>
                    <th>Genre</th>
                    <th>Age Group</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Fetch books and authors data from the tables
                $sql = "SELECT books.book_name, authors.author_name, books.year, books.genre, books.age_group
                        FROM books
                        INNER JOIN authors ON books.author_id = authors.author_id";

                if (isset($sortValue)) {

                    $sql = $sql . " ORDER BY $sortValue";
                }
                echo $sql;
                $result = mysqli_query($conn, $sql);

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