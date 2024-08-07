<?php
session_start();
require 'includes/conn.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    // Check if user exists
    $query = $conn->prepare("SELECT * FROM users WHERE mobile = ?");
    $query->bind_param("s", $mobile);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header('Location: index');
        } else {
            header('Location: login?incorrent');
        }
    } else {
        // Create new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = $conn->prepare("INSERT INTO users (mobile, password) VALUES (?, ?)");
        $insert_query->bind_param("ss", $mobile, $hashed_password);
        if ($insert_query->execute()) {
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['is_admin'] = 0;
            header('Location: index');
        } else {
            header('Location: login?error');
            echo "Error creating user";
        }
    }
}
?>
