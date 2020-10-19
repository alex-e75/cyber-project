<?php require_once "header.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
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
                            <h2 class="grid-title"><i class="fa fa-inbox"></i> Inbox</h2>
                            <a class="btn btn-block btn-primary" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-pencil"></i>&nbsp;&nbsp;NEW MESSAGE</a>

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

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <?php
                                        $req = getMessages($link, $_SESSION['id']);
                                        if (mysqli_num_rows($req) > 0) {
                                            while ($row = mysqli_fetch_array($req)) {
                                                echo '<tr>';
                                                echo '<td class="name">' . getUsername($link, $row['sender']) . '</a></td>';
                                                echo '<td class="subject"><a href="./message.php?id=' . $row['id'] . '">' . $row['subject'] . '</a></td>';
                                                echo '<td class="button"><a href="./message.php?id='.$row['id'].'" class="btn btn-primary" role="button">Read</a></td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END INBOX CONTENT -->

                        <!-- BEGIN COMPOSE MESSAGE -->
                        <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-blue">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title"><i class="fa fa-envelope"></i> Compose New Message</h4>
                                        </div>
                                        <form action="send_message.php" id="send" enctype="multipart/form-data" method="POST">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                <label id="paiement-label">To (username)</label>
                                                    <select class="form-control" name="receiver" id="receiver">
                                                        <?php
                                                        $requete = getAllUsers($link);
                                                        if (mysqli_num_rows($requete) > 0) {
                                                            while ($row = mysqli_fetch_array($requete)) {
                                                                echo '<option value="' . $row['username'] . '">' . $row['username'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input id="subject" name="subject" type="name" class="form-control" placeholder="Subject" maxlength="250">
                                                </div>
                                                <div class="form-group">
                                                    <textarea id="textMessage" name="textMessage" class="form-control" placeholder="Message" style="height: 120px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                                                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-envelope"></i> Send Message</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END COMPOSE MESSAGE -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END INBOX -->
    </div>
</div>
<?php include "footer.php" ?>