<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/home.css">
    <title>TaskFlow | Home</title>
</head>

<body>
    <?php
    session_start();

    $methodType = $_SERVER["REQUEST_METHOD"];
    $loginStatus = false;

    if (isset($_SESSION["login"])) {
        $loginStatus = true;
    }

    if ($loginStatus == false) {
        header("location: login.php");
    }
    ?>

    <header>
        <h1>TaskFlow</h1>
        <nav>
            <a href="taken.php">Taken</a>
            <a href="home.php">Home</a>
            <a href="settings.php">
                <img src="../img/user.svg">
            </a>
        </nav>
    </header>

    <main>
        <?php

        echo "<h1 id='maintext'>Welkom " . $_SESSION["login"] . "</h1>";

        ?>
        <img id="logo" src="../img/vogel.svg">
        <div id="info">
            <div id="welcome">
                <h2>Welkom bij TaskFlow</h2>
                <p>Uw hulpmiddel bij het overzichtelijk houden van uw taken.</p>
            </div>
            <div id="start">
                <p>Klik hier om te beginnen</p>
                <a href="#">Nieuwe taak</a>
            </div>
        </div>
    </main>

    <footer>
        <p>© 2024 All rights reserved.</p>
    </footer>
</body>

</html>