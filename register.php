<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate form data
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $check_sql = "SELECT * FROM user WHERE username = ?";
        $check_stmt = $db->prepare($check_sql);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error = "Username already taken. Please choose another.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL query to insert data
            $sql = "INSERT INTO user (username, password) VALUES (?, ?)";

            $stmt = $db->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ss", $username, $hashed_password);

                if ($stmt->execute()) {
                    echo "<script>alert('Registration successful! Redirecting to login page...');</script>";
                    echo "<script>window.location.href='index.php?page=login';</script>";
                    exit;
                } else {
                    $error = "Registration failed. Please try again.";
                }
                $stmt->close();
            } else {
                $error = "Error in preparing statement.";
            }
        }
    }
}

// Close connection
$db->close();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    Register
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required value="<?php echo $username ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="mb-3">Sudah punya akun?, <a href="index.php?page=login">Login</a></div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
