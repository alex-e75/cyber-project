<?php
require_once "header.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$user_id = $_SESSION['id'];
$receiver = isset($_POST['receiver']) ? $_POST['receiver'] : "";
$subject = isset($_POST['subject']) ? $_POST['subject'] : "";
$textMessage = isset($_POST['textMessage']) ? $_POST['textMessage'] : "";
$textMessage = encrypt_decrypt('encrypt', $textMessage);

/**
 * TRAITEMENT
 */

$req = getUserId($link,$receiver);
if (mysqli_num_rows($req) > 0) {
    while ($row = mysqli_fetch_array($req)) {
        $receiver = $row['id'];
    }
}else{
    exit;
}

$sql="INSERT INTO `messages` (`id`, `sender`, `recipient`, `subject`, `text`) VALUES (NULL, '$user_id', '$receiver', '$subject', '$textMessage')";
mysqli_query($link,$sql);

?>

<div class="jumbotron text-center">
    <h1 class="display-3">Sended!</h1>
    <p class="lead">Your message has been sent.</p>
    <hr>

    <p class="lead">
        <a class="btn btn-primary btn-sm" href="./inbox.php" role="button">Back</a>
    </p>
</div>

<?php require "footer.php"; ?>