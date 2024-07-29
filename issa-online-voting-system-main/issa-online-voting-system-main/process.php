<?php
session_start();

// Form data received
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

include('dbConnect.php');

// Secure query to fetch user details
$sql = "SELECT * FROM admin WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":username", $username);
$stmt->execute();

// Check if user exists
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch();
    // Verify password
    if (password_verify($password, $row['password'])) {
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);

        // Set session variables
        $_SESSION['aid'] = $row['aid'];
        $_SESSION['admin_id'] = $username;
        $_SESSION['aname'] = $row['aname'];

        // Set secure session cookie parameters
        session_set_cookie_params([
            'httponly' => true,
            'secure' => true,
            'samesite' => 'Strict'
        ]);

        // Redirect to admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Wrong Password";
        header("Location: admin_login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Wrong User ID";
    header("Location: admin_login.php");
    exit();
}
?>
