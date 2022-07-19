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

    <form action="/dumb-login.php" method="POST" autocomplete="on">
        <label>Username</label><br>
        <input type="text" name="username"><br>
        <label>Password</label><br>
        <input type="text" name="password"><br><br>
        <input type="submit" value="Login">
    </form>

</body>

</html>