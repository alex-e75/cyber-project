<?php

require "core.php";
utilisateurConnecte();

// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $role = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

//Fonction pour obtenir l'IP du visiteur
function getIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username already exists.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    $email = trim($_POST["email"]);
    if (empty(trim($_POST["email"]))) {
        $email_err = "Enter your email address.";
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = trim($_POST["email"]);
    } else {
        $email_err = "Email address is invalid.";
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {

        $sql = "INSERT INTO users (username,email, password,user_ip) VALUES (?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_email, $param_password, $param_ip);
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_ip = getIP();
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
            } else {
                echo "An error has occurred, please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>S'inscrire</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
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
                    <h2 class="text-primary">Register</h2>
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
                        <label id="paiement-label">E-mail</label>
                        <input class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" type="email" id="password" name="email" class="form-control" value="<?php echo $email; ?>">
                        <?php echo (!empty($email_err)) ? '<div class="invalid-feedback">' . $email_err . '</div>' : ''; ?>
                    </div>
                    <div class="form-group">
                        <label id="paiement-label">Password</label>
                        <input class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" type="password" id="password" name="password" class="form-control" value="<?php echo $password; ?>">
                        <?php echo (!empty($password_err)) ? '<div class="invalid-feedback">' . $password_err . '</div>' : ''; ?>
                    </div>
                    <div class="form-group">
                        <label id="paiement-label">Confirm password</label>
                        <input class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" type="password" id="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                        <?php echo (!empty($confirm_password_err)) ? '<div class="invalid-feedback">' . $confirm_password_err . '</div>' : ''; ?>
                    </div>
                    <div class="form-group">
                    </div><button class="btn btn-primary btn-block" type="submit" value="Submit">Register</button>
                    <p>Already have an account? <a href="login.php">Login</a>.</p>
                </form>
            </div>
        </section>
    </main>
</body>

</html>