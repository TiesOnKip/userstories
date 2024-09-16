<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/taken.css">
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
        <div id="block1">
            <h1>Taken</h1>
            <img src="../img/vogel.svg">
        </div>
        <div id="block2">
            <div id="taak1" class="taak">
                <h2>[taak naam]</h2>
                <p>[beschrijving]</p>
            </div>
            <div id="taak2" class="taak">
                <h2>[taak naam]</h2>
                <p>[beschrijving]</p>
            </div>
            <div id="taak3" class="taak">
                <h2>[taak naam]</h2>
                <p>[beschrijving]</p>
            </div>
            <div id="taak4" class="taak">
                <h2>[taak naam]</h2>
                <p>[beschrijving]</p>
            </div>
        </div>
    </main>

    <footer>
        <p>© 2024 All rights reserved.</p>
    </footer>
</body>

</html>