<?php
require_once 'src/Models/UserModel.php';
require_once 'dbAccess.php';

session_start();
$db = connectToDb();
$model = new UserModel($db);
$loginError = '';
if (isset($_POST['submit'])) {
    $userID = $model->checkUser($_POST['username']);
    $_SESSION['userid'] = $userID;

    if (isset($userID)) {
        $loginOK = $model->checkPassword($userID, $_POST['password']);
        if ($loginOK === true) {
            header('Location: account.php');
        } else {
            $loginError = 'Sorry your details are incorrect, please check and try again';
        }
    } else
    {
        $loginError = 'Sorry your details are incorrect, please check and try again';
    }
}
echo '<pre>';
?>

<h1>Login Page</h1>

<p>Please log in to see your account.</p>

<form method="post">
    <label for="username">Username</label>
    <input type="text" id="username" name="username"/>

    <label for="password">Password</label>
    <input type="password" id="password" name="password"/>

    <input type="submit" name="submit" value="Log In" />
</form>

<?php echo $loginError;?>
