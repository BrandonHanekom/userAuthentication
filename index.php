<?php // Connect to the database
include 'connection.php';
$sortValue = $_GET['sort'];
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
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>
        <table class="table table-bordered border-primary">
            <thead>
                <tr>
                    <th><a href="http://localhost:8080/userAuthentication/index.php?sort=book_name" class="btn btn-primary">Book
                            Name</a></th>
                    </a>
                    <th><a href="http://localhost:8080/userAuthentication/index.php?sort=author_name" class="btn btn-primary">Author
                            Name</a></th>
                    <th><a href="http://localhost:8080/userAuthentication/index.php?sort=year" class="btn btn-primary">Year</a>
                    </th>
                    <th><a href="http://localhost:8080/userAuthentication/index.php?sort=genre" class="btn btn-primary">Genre</a>
                    </th>
                    <th><a href="http://localhost:8080/userAuthentication/index.php?sort=age_group" class="btn btn-primary">Age
                            Group</a></th>
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