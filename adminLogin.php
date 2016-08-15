<?php 

session_start();                              // Session start
include("connectDB2.php");                     // Config for database connection
if(isset($_POST['check']))                    // Check form submit with IF Isset function
{
$username =$_POST['username'];                // set username to variable
$password =$_POST['password'];                //set password to variable
//$password = md5($password);				//set encrypted password
$result = mysql_query("SELECT * FROM enforcer WHERE username='$username' AND password='$password'");               //check from database
if(mysql_num_rows ($result) > 0 )
{
$_SESSION['username'] = $username;            // set session name
$_SESSION['password'] = $password;
header('location:dashboard.php');
}
else
{
$err="Incorrect Username or Password!";
}
}
?>
<!DOCTYPE html>
<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<meta charset="UTF-8">
<title>Administrator Login</title>
<style>
body {
    background-size: cover;
    font-family: Montserrat;
}

.logo {
    width: 213px;
    height: 36px;
    margin: 30px auto;
}

.login-block {
    width: 320px;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    border-top: 5px solid #222;
    margin: 0 auto;
}

.login-block h1 {
    text-align: center;
    color: #000;
    font-size: 18px;
    text-transform: uppercase;
    margin-top: 0;
    margin-bottom: 20px;
}

.login-block input {
    width: 100%;
    height: 42px;
    box-sizing: border-box;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-bottom: 20px;
    font-size: 14px;
    font-family: Montserrat;
    padding: 0 20px 0 50px;
    outline: none;
}

.login-block input:active, .login-block input:focus {
    border: 1px solid #222;
}

.login-block button {
    width: 100%;
    height: 40px;
    background: #222;
    box-sizing: border-box;
    border-radius: 5px;
    border: 1px solid #1e1e1e;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 14px;
    font-family: Montserrat;
    outline: none;
    cursor: pointer;
}

.login-block button:hover {
    background: #383838;
}

</style>
</head>

<body>

<div class="logo"></div>
<div class="login-block">
    <h1>Administrator Login</h1>
	<?php if(isset($err)){ echo $err; } ?>
    <form method="post" action="" name="loginauth" target="_self">
    <input type="text" placeholder="Username" id="username" name="username" />
    <input type="password" placeholder="Password" id="password" name="password" />
    <button name="check" type="submit">Submit</button>
    </form>
</div>
</body>

</html>
