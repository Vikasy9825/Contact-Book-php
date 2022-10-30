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
                <h4 class="card-title mt-2">Edit Profile</h4>
            </header>
            <article class="card-body">
                <form method="POST" action="<?php echo SITEURL . 'actions/update_profile_action.php' ?>">
                    <div class="form-row">
                        <div class="col form-group">
                            <label>First name </label>
                            <input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo $userInfo['first_name']; ?>">
                        </div> 
                        <div class="col form-group">
                            <label>Last name</label>
                            <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $userInfo['last_name']; ?>">
                        </div> 
                    </div> 
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="text" name="email" class="form-control" placeholder="Email address" value="<?php echo $userInfo['email']; ?>">
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