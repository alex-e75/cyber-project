<?php include "header.php" ?>
<?php
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$id = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("location: index.php");
}

$id_raw = trim(htmlentities($_GET["id"]));
$id_secure = mysqli_real_escape_string($link, $id_raw);

$req = getMessageId($link, $id_secure);
if (mysqli_num_rows($req) > 0) {
    while ($row = mysqli_fetch_array($req)) {
        if ($row['recipient'] != $_SESSION['id']) {
            header("location: index.php");
        } else {
            $decrypted = encrypt_decrypt('decrypt', $row['text']);
        }
    }
} else {
    header("location: index.php");
}
?>

<div class="container">
    <div class="row">
        <!-- BEGIN INBOX -->
        <div class="col-md-12">
            <div class="grid email">
                <div class="grid-body">
                    <div class="row">
                        <!-- BEGIN INBOX MENU -->
                        <div class="col-md-3">
                            <a class="btn btn-block btn-primary" href="./inbox.php"><i class="fa fa-arrow"></i>&nbsp;&nbsp;Back to inbox</a>

                            <hr>
                        </div>
                        <!-- END INBOX MENU -->

                        <!-- BEGIN INBOX CONTENT -->
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label style="margin-right: 8px;" class="">
                                        <div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" id="check-all" class="icheck" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
                                    </label>
                                </div>
                            </div>

                            <div class="padding"></div>
                            <?php echo $decrypted ?>
                        </div>
                        <!-- END INBOX CONTENT -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END INBOX -->
    </div>
</div>
<?php include "footer.php" ?>