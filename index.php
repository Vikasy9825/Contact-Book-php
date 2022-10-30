<?php
include_once 'comman/header.php';
require_once 'includes/db.php';
$userId = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : 0;


if (!empty($_SESSION['success'])) {
?>
    <div class="alert alert-success text-center mt-2">
        <?php echo $_SESSION['success'] ?>
    </div>
    <?php
    unset($_SESSION['success']);
}


//get users contact's

if (!empty($userId)) {
    $contactsSql = "SELECT * FROM `contacts` WHERE `owner_id` = $userId ORDER BY first_name ASC LIMIT 0, 10";
    $conn = db_connect();
    $contactsResult = mysqli_query($conn, $contactsSql);
    $contactsNumRows = mysqli_num_rows($contactsResult);

    if ($contactsNumRows > 0) {

    ?>

        <table class="table text-center">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                while ($row = mysqli_fetch_assoc($contactsResult)) {


                ?>

                    <tr>
                        <td class="align-middle"><img src="public/images/profile.png" width="50" height="50" class=" img-list" /></td>
                        <td class="align-middle"><?php echo $row['first_name'] . " " . $row['last_name'] ?></td>
                        <td class="align-middle">
                            <a href="<?php echo SITEURL . "view.php?id=" . $row['id']; ?>" class="btn btn-success">View</a>
                            <a href="<?php echo SITEURL . "addcontact.php?id=" . $row['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="<?php echo SITEURL . "delete.php?id=" . $row['id']; ?>" class="btn btn-danger" onclick="return confirm(`Are you sure want to delete this contact?`)">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
    <?php
    } else {
        echo '<div class="alert alert-danger text-center mt-2"> No contacts available!</div>';
    }
} else {
    ?>
    <style>
        body {
            background-image: url("<?php echo SITEURL . "public/images/contactbook.jpg"; ?>");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>

<?php
}
include_once 'comman/footer.php';
?>