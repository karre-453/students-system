<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Classmate</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Classmate</h2>
        <div class="actions">
            <a href="/crud_app/read.php">Back to List</a>
        </div>

        <?php
        $raw = null;
        if (isset($_GET['stud_no'])) {
            $stud_no_get = $_GET['stud_no'];
            $result = $conn->query("SELECT * FROM classmate_details WHERE stud_no='$stud_no_get'");
            if ($result && $result->num_rows > 0) {
                $raw = $result->fetch_assoc();
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $stud_no = $_POST['stud_no'];
            $lastname = $_POST['lastname'];
            $firstname= $_POST['firstname'];
            $sex= $_POST['sex'];
            $bdate= $_POST['bdate'];
            $age = empty($_POST['age']) ? "NULL" : $_POST['age'];
            $religion = $_POST['religion'];
            $talent = $_POST['talent'];
        
            $sql = "UPDATE classmate_details SET
                    lastname= '$lastname',
                    firstname= '$firstname',
                    sex= '$sex',
                    bdate= '$bdate',
                    age=$age,
                    religion= '$religion',
                    talent= '$talent'
                    WHERE stud_no='$stud_no'";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>Record updated successfully.</p>";
                $result = $conn->query("SELECT * FROM classmate_details WHERE stud_no='$stud_no'");
                $raw = $result->fetch_assoc();
            } else {
               echo "<p class='error'>Error updating record: " .$conn->error . "</p>";
            }
        }
        ?>

        <?php if ($raw): ?>
        <form method="POST" action="">
            <input type="hidden" name="stud_no" value="<?php echo htmlspecialchars($raw['stud_no']); ?>">
            <label>Student No:</label>
            <input type="text" value="<?php echo htmlspecialchars($raw['stud_no']); ?>" disabled>
            <label>Last Name:</label>
            <input type="text" name="lastname" value="<?php echo htmlspecialchars($raw['lastname']); ?>" required>
            <label>First Name:</label>
            <input type="text" name="firstname" value="<?php echo htmlspecialchars($raw['firstname']); ?>" required>
            <label>Sex:</label>
            <select name="sex">
                <option value="Male" <?php if($raw['sex']=="Male") echo "selected"; ?>>Male</option>
                <option value="Female" <?php if($raw['sex']=="Female") echo "selected"; ?>>Female</option>
            </select>
            <label>Birth Date:</label>
            <input type="date" name="bdate" value="<?php echo htmlspecialchars($raw['bdate']); ?>">
            <label>Age:</label>
            <input type="number" name="age" value="<?php echo htmlspecialchars($raw['age']); ?>">
            <label>Religion:</label>
            <input type="text" name="religion" value="<?php echo htmlspecialchars($raw['religion']); ?>">
            <label>Talent:</label>
            <input type="text" name="talent" value="<?php echo htmlspecialchars($raw['talent']); ?>">
            <button type="submit">Update Record</button>
        </form>
        <?php else: ?>
            <p class="error">Record not found. Please select a record from the <a href="read.php">list</a>.</p>
        <?php endif; ?>
    </div>
</body>
</html>

