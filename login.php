<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}
require_once "config/config.php";

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            header("location: index.php");
                        } else {
                            $password_err = "The entered password is incorrect.";
                        }
                    }
                } else {
                    $username_err = "Could not find an account corresponding to this nickname.";
                }
            } else {
                echo "An error has occurred, please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Se connecter</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="./"><b>Coursera</b></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto"></ul>
            </div>
        </div>
    </nav>
    <main style="padding-top: 80px">
        <section style="padding-bottom: 50px;background-color: #f6f6f6">
            <div class="container">
                <div style="padding-top: 50px;
                margin-bottom: 40px;
                text-align: center;">
                    <h2 class="text-primary">Login</h2>
                </div>
                <form style="border-top: 2px solid #5ea4f3;
                background-color: #fff;
                max-width: 500px;
                margin: auto;
                padding: 40px;
                box-shadow: 0 2px 10px rgba(0,0,0,.075);" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label id="paiement-label">Pseudo</label>
                        <input class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>">
                        <?php echo (!empty($username_err)) ? '<div class="invalid-feedback">' . $username_err . '</div>' : ''; ?>
                    </div>
                    <div class="form-group">
                        <label id="paiement-label">Password</label>
                        <input class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" type="password" id="password" name="password" class="form-control" value="<?php echo $password; ?>">
                        <?php echo (!empty($password_err)) ? '<div class="invalid-feedback">' . $password_err . '</div>' : ''; ?>
                    </div>
                    <div class="form-group">
                    </div><button class="btn btn-primary btn-block" type="submit">Login</button>
                    <p>No account ? <a href="register.php">Register</a>.</p>
                </form>
            </div>
        </section>
    </main>
</body>

</html>