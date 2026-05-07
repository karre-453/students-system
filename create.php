<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF -8">
    <title>Create Classmate</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2> Add New Classmate</h2>
        <div class="actions">
            <a href="index.php">Back to Home</a> | <a href="read.php">View Records</a>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Note: stud_no is removed here since it's an auto-incrementing ID in the database per your db.php update
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $sex = $_POST['sex'];
            $bdate = $_POST['bdate'];
            $age = empty($_POST['age']) ? "NULL" :$_POST['age'];
            $religion = $_POST['religion'];
            $talent = $_POST['talent'];

            // Insert query without stud_no
            $sql = "INSERT INTO classmate_details(lastname, firstname, sex, bdate, age, religion, talent)
                    VALUES ('$lastname', '$firstname', '$sex', '$bdate', $age, '$religion', '$talent')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>New record created successfully. </p>";
            } else {
                echo "<p class='error'> Error: " .$conn->error . "</p>";
            }
        }
        ?>

        <form method="POST" action="">
            <label>Last Name:</label> <input type="text" name="lastname" required>
            <label>First Name:</label> <input type="text" name="firstname" required>
            <label>Sex:</label>
            <select name="sex">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <label>Birth Date:</label> <input type="date" name="bdate">
            <lable>Age:</label> <input type="number" name="age">
            <label>Religion:</label> <input type="text" name="religion">
            <label>Talent:</label> <input type="text" name="talent">
            <button type="submit">submit</button>
        </form>
    </div>
</body>
</html>