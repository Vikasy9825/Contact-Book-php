<?php
include_once 'comman/header.php';
require_once 'includes/db.php';
if (empty($_SESSION['user'])) {
    header('location:' . SITEURL . "login.php");
    exit();
}
$userId = $_SESSION['user']['id'];
$conn = db_connect();
$sql = "SELECT * FROM `users` WHERE `id` = $userId";
$sqlResult = mysqli_query($conn, $sql);

if (mysqli_num_rows($sqlResult) > 0) {
    $userInfo = mysqli_fetch_assoc($sqlResult);
} else {
    echo "User not found!";
    exit();
}
db_close($conn);

?>
<style>
    .wrapper {
        padding-top: 30px;
    }
</style>
<div class="row justify-content-center wrapper">
    <div class="col-md-6">
        <?php
            include_once 'comman/alert_message.php';
        ?>

        <div class="card">
            <header class="card-header">
                <h4 class="card-title mt-2">Change Password</h4>
            </header>
            <article class="card-body">
                <form method="POST" action="<?php echo SITEURL . 'actions/update_password_action.php' ?>">
                     
                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="password" name="old_password" class="form-control" placeholder="Enter Old Password" value="">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Enter New Password" value="">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Enter New Password Again" value="">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update_profile" class="btn btn-success btn-block"> Update</button>
                    </div>

                </form>
            </article>
        </div>
    </div>

</div>

<?php
include_once 'comman/footer.php';
?>