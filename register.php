<?php
require_once 'src/Models/UserModel.php';
require_once 'dbAccess.php';

session_start();
$db = connectToDb();
$model = new UserModel($db);
$formError = '';
if (isset($_POST['submit'])) {
    $userID = $model->checkUser($_POST['username']);

    if (isset($userID)) {
        $formError = 'Sorry, that username is already in use.';
    } else {
        $hashedPassword =  password_hash($_POST['password'], PASSWORD_BCRYPT);
        $model->createUser($_POST['username'], $_POST['displayname'], $hashedPassword, $_POST['bio'], $_POST['birthday']);
        $_SESSION['userid'] = $model->checkUser($_POST['username']);
        header('Location: account.php');
    }
}
echo '<pre>';
?>

<h1>Register New User</h1>

<p>Sign up to our site.</p>

<form method="post">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required/>

    <label for="displayname">Display Name</label>
    <input type="text" id="displayname" name="displayname" required/>

    <label for="bio">Your Bio</label>
    <textarea rows="4" cols="50" id="bio" name="bio"></textarea>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required/>

    <label for="birthday">Your Birthday</label>
    <input type="date" id="birthday" name="birthday"/>

    <p>What are your interests?</p>
    <input type="checkbox" id="art" name="art" value="Art">
    <label for="art"> Art</label>
    <input type="checkbox" id="balloon-modelling" name="balloon-modelling" value="Balloon Modelling">
    <label for="balloon-modelling"> Balloon Modelling</label>
    <input type="checkbox" id="cookery" name="cookery" value="Cookery">
    <label for="cookery"> Cookery</label>
    <input type="checkbox" id="daredevil-stunts" name="daredevil-stunts" value="Daredevil Stunts">
    <label for="daredevil-stunts"> Daredevil Stunts</label>
    <input type="checkbox" id="esports" name="esports" value="Esports">
    <label for="esports"> Esports</label>

    <input type="submit" name="submit" value="Register" />
</form>

<?php echo $formError;?>
