<?php

include("changePass.html");
include_once("db.php");

session_start();

$username = $_SESSION['username'];
$oldpassword = $_POST['oldpassword'];
$newpassword = $_POST['newpassword'];
$confirmPassword = $_POST['confirmPassword'];



$db = db_connect();
$query = "SELECT * FROM user1 WHERE username = '$username' ";
$sql = db_query($db, $query);

if ($sql)
{
	$row = db_fetch($sql);
	// Check for oldpassword validity
	if (password_verify($oldpassword, $row['password']))
	{
	    // Check for authorized characters
	    if (preg_match("/^[A-Za-z0-9_-]*$/", $newpassword))
        {
	        // Check for newpassword and confirmPassword matching
	        if ($newpassword == $confirmPassword)
	        {
                $password_encode = password_hash($newpassword, PASSWORD_BCRYPT);
			    $query="UPDATE user1 SET password='$password_encode' WHERE username='$username'";
    		    if (db_query($db, $query))
    		    {
	                header("refresh:3; url=information.php");
	                echo 'New password saved, now redirecting to your profile. If not, click <a href="information.php">here</a>.<br/>';
    		    }
    		    else
    		    {
    		        echo 'Error $query<br/>';
    		    }
	        }
	        else
	        {
	            header("refresh:3; url=changePass.html");
	            echo 'New password and confirm password don\'t match.<br/>';
	        }
        }
        else
        {
	        header("refresh:3; url=changePass.html");
	        echo 'New password can only be letters, numbers, _ or -.<br/>';
        }
	    
	}
	else
	{
	    header("refresh:3; url=changePass.html");
	    echo 'Wrong password, please retry.<br/>';
	}
}
db_close($db);

