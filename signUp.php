<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Encrypt the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Set the default role for a new user (you might want to adjust this based on your system)
    $role = "member";

    // Insert user data into the 'users' table
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', '$role')";

    if ($conn->query($sql) === TRUE) {
        // Set session variables for user information
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Redirect to index.php after successful signup
        header("Location: index.php");
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>

<body>
    <main>
        <div class="container">
            <h2 class="mt-5">Sign Up</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>