<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">

<body>

    <?php require_once "config.php"; ?>

    <div>
        Today’s date is <b>
            <?php echo date('Y/m/d') ?>
        </b> and it’s a <b>
            <?php echo date('l') ?>
        </b> today!
    </div>

    <?php 
        $sql = "SELECT * FROM test";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Value: " . $row["value"]. " " . "<br>";
            }
        } else {
            echo "0 results";
        }
    ?>

    <form action="/dumb-login.php" autocomplete="on">
        <label>Username</label><br>
        <input type="text" name="username"><br>
        <label>Password</label><br>
        <input type="text" name="password"><br><br>
        <input type="submit" value="Login">
    </form>

</body>

</html>