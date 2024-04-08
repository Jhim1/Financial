<?php
include('db_connect.php');

if($_POST){
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security
    
    // Prepare and execute SQL statement to insert new user into database
    $insert = $conn->query("INSERT INTO users (email, password) VALUES ('$email', '$password')");

    if($insert === TRUE){
        // Redirect user to login page after successful signup
        header("location: login.php");
    }else{
        // Handle error
        echo "Error: " . $conn->error;
    }
}