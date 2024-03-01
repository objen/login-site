<?php

require_once 'src/Models/UserModel.php';
require_once 'dbAccess.php';

session_start();
$db = connectToDb();
$model = new UserModel($db);

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
} else {
    $userDetails = $model->getUserByID($_SESSION['userid']);
}
?>

<h1>Account Page</h1>

<a href="logout.php">Log Out</a>

<p>Welcome <?php echo $userDetails->displayname;?>!</p>

<h3>Your Bio</h3>

<?php echo $userDetails->bio;?>

<h3>Your Birthday</h3>

<?php echo $userDetails->birthday;?>







