<?php require_once "core.php" ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title><?php echo $websiteTitle ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>body{font-family: 'Montserrat', sans-serif;}</style>
</head>

<!-- Barre de navigation -->
<div>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean">
        <div class="container"><a class="navbar-brand" href="./"><?php echo $websiteTitle ?></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <?php
                    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
                        echo '<li class="nav-item" role="presentation"><a class="nav-link" href="./login.php"><i class="icon-login"> </i> Login</a></li>';
                    } else {
                        echo '<li class="dropdown nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">';
                        echo htmlspecialchars($_SESSION["username"]);
                        echo '</a><div class="dropdown-menu" role="menu">';
                        echo '<a class="dropdown-item alert-danger" role="presentation" href="./logout.php">Disconnect</a></div>';
                        echo '</li>';
                        echo '<li class="nav-item" role="presentation"><a class="nav-link" href="./inbox.php"><i class="icon-envelope"></i> Inbox <span class="badge badge-primary">';$req1 = countMessages($link, $_SESSION['id']);
                        if (mysqli_num_rows($req1) > 0) {
                            while ($row = mysqli_fetch_array($req1)) {
                                echo $row['COUNT(ID)'];
                            }
                        }
                        echo '</span></a></li>';
                    }
                    ?>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="./dump.php"><i class="fa fa-download"> </i> Dump Database</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<!-- Barre de navigation -->

<body>