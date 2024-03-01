<?php
require_once 'src/Models/UserModel.php';
require_once 'dbAccess.php';

session_start();
$db = connectToDb();
$model = new UserModel($db);
$formError = '';
if (isset($_POST['submit'])) {
    // check it's a user
    $userID = $model->checkUser($_POST['username']);
    $_SESSION['userid'] = $userID;

    if (isset($userID)) {
        $loginOK = $model->checkOldPassword($userID, $_POST['password']);
        if ($loginOK === true) {
            $hashedPassword =  password_hash($_POST['password'], PASSWORD_BCRYPT);
            $model->updatePassword($userID, $hashedPassword);
            header('Location: account.php');
        } else {
            $formError = 'Sorry your details are incorrect, please check and try again';
        }
    }
}
echo '<pre>';
?>

<h1>Reset Your Password</h1>

<p>Please re-enter your password to use our new encryption system</p>

<form method="post">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required/>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required/>

    <input type="submit" name="submit" value="Reset Password" />
</form>

<?php echo $formError;?>

