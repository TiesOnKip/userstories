<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/registreer.css">
    <title>TaskFlow | Registreer</title>
</head>

<body>

    <?php
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

            $veiligNaam = htmlspecialchars($postNaam);

            $statement->bind_param("s", $veiligNaam);
            $statement->execute();
            $result = $statement->get_result();
            // Als de gebruikersnaam of email al in gebruik is dan wordt er een alert gegeven
            if ($result->num_rows > 0) {
                echo "<script>alert('Gebruikersnaam al in gebruik');</script>";
            } else {
                // Als de gebruikersnaam en email nog niet in gebruik zijn dan wordt er een nieuwe record aangemaakt in de database
                $query = "INSERT INTO gebruikers(gebruikersnaam,wachtwoord) VALUES (?,?)";
                // statement preparen om de query uit te voeren
                $statement = $connectie->prepare($query);

                $postWachtwoord = $_POST["wachtwoord"];
                $veiligWachtwoord = password_hash($postWachtwoord, PASSWORD_DEFAULT);
                $statement->bind_param("ss", $veiligNaam, $veiligWachtwoord);
                header("location: login.php");
            }

            if (!$statement->execute()) {
                throw new Exception($connectie->error);
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
            <p>Registreren</p>
            <form action="registreer.php" method="post">
                <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required>
                <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
                <input class="btn" type="submit" value="Inloggen">
            </form>
        </div>
    </main>

    <footer>
        <p>© 2024 All rights reserved.</p>
    </footer>
</body>

</html>