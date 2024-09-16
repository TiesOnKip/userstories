<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>TaskFlow | Login</title>
</head>

<body>

    <?php
    session_start();

    $methodType = $_SERVER["REQUEST_METHOD"];

    if (($methodType == "POST") && (isset($_POST["gebruikersnaam"]))) {
        try {
            $host = "localhost";
            $user = "root";
            $pass = "";
            $database = "userstories";

            $connectie = new mysqli($host, $user, $pass, $database);

            if ($connectie->error) {
                throw new Exception($connectie->connect_error);
            }

            $query = "SELECT * FROM gebruikers WHERE gebruikersnaam = ?";

            $statement = $connectie->prepare($query);

            $postNaam = $_POST["gebruikersnaam"];
            $postWachtwoord = $_POST["wachtwoord"];

            $veiligNaam = htmlspecialchars($postNaam);
            $veiligWachtwoord = password_hash($postWachtwoord, PASSWORD_DEFAULT);

            $statement->bind_param("s", $veiligNaam);

            if (!$statement->execute()) {

                throw new Exception($connectie->error);
            }
            $databaseNaam = "<error>";
            $databaseWachtwoord = "<error>";

            $statement->bind_result($id, $gebruikersnaam, $wachtwoord);
            while ($statement->fetch()) {
                $databaseNaam = $gebruikersnaam;
                $databaseWachtwoord = $wachtwoord;
            }

            if ($databaseNaam == "<error>") {
                echo '<script>alert("Gebruikersnaam niet gevonden")</script>';
            } else if (!password_verify($postWachtwoord, $databaseWachtwoord)) {
                echo "<script>alert('Wachtwoord is incorrect')</script>";
            } else {
                $_SESSION["login"] = $databaseNaam;
                header("Location: home.php");
            }
        } catch (Exception $e) {
            echo "oops: " . $e->getMessage();
        } finally {
            if ($statement) {
                $statement->close();
            }

            if ($connectie) {
                $connectie->close();
            }
        }
    }
    ?>

    <header>
        <h1>TaskFlow</h1>
        <nav>
            <a href="#">
                <img src="../img/user.svg">
            </a>
        </nav>
    </header>

    <main>
        <div>
            <p>Inloggen</p>
            <form action="login.php" method="post">
                <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required>
                <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
                <input class="btn" type="submit" value="Inloggen">
            </form>
            <p>Geen account? Registreer <a href="registreer.php">hier</a></p>
        </div>
    </main>

    <footer>
        <p>© 2024 All rights reserved.</p>
    </footer>
</body>

</html>