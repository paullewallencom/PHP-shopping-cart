<?php
session_start();
require("db.php");
if(isset($_SESSION['SESS_LOGGEDIN']) == TRUE) {
    header("Location: " . $config_basedir);
}
if($_POST['submit'])
{
    $loginsql = "SELECT * FROM logins
WHERE username = '" . $_POST['userBox']
            . "' AND password = '" . $_POST['passBox']
            . "'";
    $loginres = mysql_query($loginsql);
    $numrows = mysql_num_rows($loginres);
    if($numrows == 1)
    {
        $loginrow = mysql_fetch_assoc($loginres);
        session_register("SESS_LOGGEDIN");
        session_register("SESS_USERNAME");
        session_register("SESS_USERID");
        $_SESSION['SESS_LOGGEDIN'] = 1;
        $_SESSION['SESS_USERNAME'] = $loginrow['username'];
        $_SESSION['SESS_USERID'] = $loginrow['id'];
        $ordersql = "SELECT id FROM orders
WHERE customer_id = " . $_SESSION['SESS_USERID']
                . " AND status < 2";
        $orderres = mysql_query($ordersql);
        $orderrow = mysql_fetch_assoc($orderres);
        session_register("SESS_ORDERNUM");
        $_SESSION['SESS_ORDERNUM'] = $orderrow['id'];
        header("Location: " . $config_basedir);
    }
    else
    {
        header("Location: http://" . $HTTP_HOST
                . $SCRIPT_NAME . "?error=1");
    }
}else
{
require("header.php");
?>
<h1>Customer Login</h1>
Please enter your username and password to
log into the websites. If you do not
have an account, you can get one for free by <a
        href="register.php">registering</a>.
<p>
    <?php
    if($_GET['error']) {
        echo "<strong>Incorrect username/password</strong>";
    }
    ?>

<form action="<?php echo $SCRIPT_NAME; ?>" method="POST">
    <table>
        <tr>
            <td>Username</td>
            <td><input type="textbox" name="userBox">
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="passBox">
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Log in">
        </tr>
    </table>
</form>
<?php
}
require("footer.php");
?>