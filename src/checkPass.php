<?php

include("login.html");
include("db.php");

session_start();

$username = $_POST['username'];
$password = $_POST['password'];
//$remember = $_POST['rememberMe'];


/*if ($remember == rememberMe)
{
	$remember = 1;
}
else 
{
	$remember = 0;
}
*/

// Checks for username and password validities


if (!preg_match("/^[A-Za-z0-9_-]*$/",$username) || !preg_match("/^[A-Za-z0-9_-]*$/",$password))
{
	header("refresh:3; url=login.html");
	echo "Login failed, invalid username or password. </br> Please retry !";
}
else
{
	$db = db_connect();
	$query = "SELECT * FROM user1 WHERE username = '$username' ";
	$sql = db_query($db, $query);

	if ($sql)
	{
		$row = db_fetch($sql);
		
		if (password_verify($password, $row['password']))
		{
			$datetime=date("Y-m-d G:i:s");
			$query="update user1 set last_login='$datetime' where username='$username'";
    		$result=db_query($db, $query);
	        
    		$_SESSION["username"] = $username;
	        
	        $query="SELECT is_admin FROM user1 WHERE username='$username'";
	        $result=db_query($db, $query);
	        $row=db_fetch($result);
	        
    		$_SESSION["admin"] = $row["is_admin"];
    		//session_unset();
    		//session_destroy();
    		//session_register("password");
    		//$HTTP_SESSION_VARS["password"]=$password;
    		//session_register("username");
    		//$HTTP_SESSION_VARS["username"]=$username;
    		/*
    		if ($Remember=="1")
    		{
	    		setcookie("RememberCookieUsername", $username, (time()+604800));
    			setcookie("RememberCookiePassword", md5($password), (time()+604800));
    		}
    		*/
	   		
    		header("refresh:1; url=index.php");
			echo "Welcome $username, you'll be redirected in about 1 secs. If not, click <a href='index.php'>here</a>."; 
		}
		else
		{
			header("refresh:3; url=login.html");
			echo "Login failed, wrong username or password. </br> Please retry !";
		}
	}
	db_close($db);
}
