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
    <script src="https://cdn.babylonjs.com/babylon.js"></script>
    <script src="https://cdn.babylonjs.com/loaders/babylonjs.loaders.min.js"></script>
</head>

<body data-bs-theme="dark" style="overflow: hidden;">
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col"<?php $col=['#0dcaf0','#20c997','#198754','#fd7e14','#6f42c1','#6610f2','#0d6efd']; echo 'style = "background-color:'. $col[array_rand($col,1)] .'50;"'?> id="loginCol">
                    <div class="d-flex position-relative top-50 start-50 translate-middle">
                        <form class="w-100">
                            <h3 class="fw-normal mb-3 pb-3">Log in</h3>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email address</label>
                                <input type="email" id="email" class="form-control form-control"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" class="form-control form-control"/>
                            </div>
                            <input type="submit" name="submit_type" value="Login" class="btn btn-primary mt-1" />
                            <input type="submit" name="submit_type" value="Register" class="btn btn-primary mt-1"/>
                        </form>
                    </div>
                </div>
                <div class="col-sm-9 px-0">
                    <canvas id="demo" touch-action="none" style="touch-action: none; outline: none; -webkit-tap-highlight-color: transparent; height: 100vh; width: 100%;"></canvas>
                    <script src="script/scene.js"></script>
                    <script src="script/demo.js"></script>
                </div>
            </div>
        </div>
    </section>
    <?php
    if (isset($error)) {
        echo '<div class="error-container"><p>' . $error . '</p></div>';
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>