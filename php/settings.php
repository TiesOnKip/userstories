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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/settings.css">
    <title>TaskFlow | Home</title>
</head>

<body>
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["changeUsername"])) {
                $newUsername = $_POST["newUsername"];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "userstories";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "UPDATE gebruikers SET gebruikersnaam='$newUsername' WHERE id=1";

                if ($conn->query($sql) === TRUE) {
                    echo "Username changed successfully!";
                    $_SESSION["login"] = $newUsername;
                } else {
                    echo "Error updating username: " . $conn->error;
                }

                $conn->close();
            }
        }
        if (isset($_POST["deleteAccount"])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "userstories";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            $statement = $conn->prepare("DELETE FROM gebruikers WHERE gebruikersnaam = ?");
            $statement->bind_param("s", $_SESSION["login"]);

            $statement->execute();

            $statement->close();
            $conn->close();

            session_destroy();
            echo "<script>alert('Account deleted!')</script>";
            header("refresh: 0");
        }
        ?>

        <div>
            <form method="post">
                <h2>Change Username</h2>
                <input type="text" name="newUsername" placeholder="New Username">
                <button type="submit" name="changeUsername">Change</button>
            </form>

            <form action="settings.php" method="post">
                <h2>Delete Account</h2>
                <button type="submit" name="deleteAccount">Delete</button>
            </form>
        </div>
    </main>

    <footer>
        <p>© 2024 All rights reserved.</p>
    </footer>

    <script>
        const main = document.querySelector("main");
  const header = document.querySelector("header");
  const footer = document.querySelector("footer");

  main.style.height =
    window.innerHeight - header.offsetHeight - footer.offsetHeight + "px";

  window.onresize = () => {
    main.style.height =
      window.innerHeight - header.offsetHeight - footer.offsetHeight + "px";
  };
    </script>
</body>

</html>