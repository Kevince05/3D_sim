<?php
session_start();
$error = null;
$db = new mysqli("localhost", "root", "", "3d_sim");

if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST["email"];
    $pwd = md5($_POST["pwd"]);

    if ($_POST["submit_type"] === "Login") {
        $prep = $db->prepare("SELECT * FROM users WHERE email=? AND password=?");
        $prep->bind_param("ss", $email, $pwd);
        $prep->execute();
        $result = $prep->get_result();
        if ($result->num_rows == 1) {
            $_SESSION["email"] = $email;
            $_SESSION["pwd"] = $pwd;
            $_SESSION["admin"] = $result->fetch_assoc()["admin"] === 1 ? true : false;
            header("Location:index.php");
        } else {
            $error = "Wrong user or password";
        }
    } else {
        $prep = $db->prepare("INSERT INTO users (email, password) VALUE (?,?)");
        $prep->bind_param("ss", $email, $pwd);
        if ($prep->execute()) {
            header("Location:ilogin.php");
        } else {
            $error = "Error:" . $db->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<head>
    <title>Login</title>
</head>

<body data-bs-theme="dark">
    <div class="container-float d-flex align-self-center">
        <div class="align-self-center">
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Password</label>
                    <input type="password" class="form-control" name="pwd" id="pwd" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="flex-fill">
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Password</label>
                    <input type="password" class="form-control" name="pwd" id="pwd" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <?php
    if (isset($error)) {
        echo '<div class="error-container"><p>' . $error . '</p></div>';
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>