<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection to MySQL server
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS classmates";
if ($conn->query($sql) === TRUE) {
    // Select the database
    $conn-> select_db("classmates");

    // Create table if not exists
    $table_sql = "CREATE TABLE IF NOT EXISTS classmate_details(
        stud_no int unsigned not null AUTO_INCREMENT PRIMARY KEY,
        lastname VARCHAR(100) NOT NULL,
        firstname VARCHAR(100) NOT NULL,
        sex VARCHAR(10),
        bdate DATE,
        age INT,
        religion VARCHAR(100),
        talent VARCHAR(255)
    )";
    $conn->query($table_sql);
}
else {
    die("Error creating database: " . $conn->error);
}
?>