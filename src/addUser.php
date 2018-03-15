<?php
include("db.php");
include("regis.html");

// grab recaptcha library
require_once "recaptchalib.php";

$username=$_POST["username"];
$password=$_POST["password"];
$confirmPassword=$_POST["confirmPassword"];
$email=$_POST["email"];



// your secret key
$secret = "6LdsIyAUAAAAAC8sA_KRrmAfxxX3yc85NEvDvlgA";
 
// empty response
$response = null;
 
// check secret key
$reCaptcha = new ReCaptcha($secret);

// if submitted check response
if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}


function check_username($username)
{
    $max_len=16;
    $min_len=1;
    $pattern="/^[a-zA-Z0-9_-]*$/";
    $usernameGood="Username is correct";
 
    // Check if username is empty
    if($username=="")
    {
        $usernameGood="Username can't be empty";
        return $usernameGood;
    }
 
    // Check for authorized caracters
    if(!preg_match($pattern,$username))
    {
        $usernameGood="Username can only be letters, numbers or -";
        return $usernameGood;
    }
    
    // Check for username length
    if (strlen($username)<$min_len)
    {
        $usernameGood="Username too short";
        return $usernameGood;
    }
    if (strlen($username)>$max_len)
    {
        $usernameGood="Username too long";
        return $usernameGood;
    }
    
    return $usernameGood;
}

function check_password($password)
{
    $max_len=64;
    $min_len=6;
    $pattern="/^[A-Za-z0-9_-]*$/";
    $passwordGood="Password is correct";
    
    // Check for empty password
    if($password=="")
    {
        $passwordGood="Password can't be empty";
        return $passwordGood;
    }
    
    // Check for authorized caracters
    if(!preg_match($pattern,$password))
    {
        $passwordGood="Password can only be letters, numbers or -";
        return $passwordGood;
    }

    // Check for password length    
    if(strlen($password)<$min_len)
    {
        $passwordGood="Password too short";
        return $passwordGood;
    }
    if (strlen($password)>$max_len)
    {
        $passwordGood="Password too long";
        return $passwordGood;
    }
    
    return $passwordGood;
}


function check_email($email)
{
    $emailGood="Email is correct";
    
    // Check for empty email
    if($email=="")
    {
        $emailGood="Email adress can't be empty";
        return $emailGood;
    }
    
    // Check for email validity
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $emailGood="Invalid email format";
        return $emailGood;
    }
    return $emailGood;
}


function check_confirmPassword($password,$confirmPassword)
{
    $confirmPasswordGood="Password matches";
    // Check if password and confirmPassword are the same
    if($password<>$confirmPassword)
    {
        $confirmPasswordGood="Password doesn't match";
        return $confirmPasswordGood;
    }
    else
        return $confirmPasswordGood;
}



$usernameGood=check_username($username);
$passwordGood=check_password($password);
$emailGood=check_email($email);
$confirmPasswordGood=check_confirmPassword($password,$confirmPassword);
$error=false;

// Check if there is an error
if($usernameGood != "Username is correct")
{
    $error=true;
    echo $usernameGood."<br/>";
}
if($passwordGood !="Password is correct")
{
    $error=true;
    echo $passwordGood."<br/>";
}
if($emailGood !="Email is correct")
{
    $error=true;
    echo $emailGood."<br/>";
}
if ($confirmPasswordGood !="Password matches")
{
    $error=true;
    echo $confirmPasswordGood."<br/>";
}
    
    
// Check if username or email adress already exist in database
$db=db_connect();
$query="select * from user1 where username='$username' or email='$email'";
$result=db_query($db, $query);
$row=db_fetch($result);
while ($row)
{
    if ($row["username"]==$username)
    {
        $error=true;
        echo "Username already exists<br/>";
    }
    if ($row["email"]==$email)
    {
        $error=true;
        echo "Email adress already exists<br/>";
    }
    $row=db_fetch($result);
}
    

// Add new user
function add_user($username, $password, $email)
{
    $db = db_connect();

    $datetime=date("Y-m-d G:i:s");
    // Default nickname = $username
    $sql = "INSERT INTO user1 (username, password, nickname, email, register_date) 
        VALUES ('".$username."','".$password."','".$username."','".$email."','".$datetime."')";
        
    if (db_query($db, $sql))
    {
        echo "Data saved<br/>";
        // Change login status
        
        $_SESSION["username"] = $username;
        $_SESSION["admin"] = 0;
        echo "Welcome $username, now you registered.<br/>";
    }
    else
        echo "Error<br/>$sql<br />";
    
    db_close($db);
}



// I'm not a robot
if ($response != null && $response->success)
{    
    // Now, let's add this user to the database
    if ($error == false)
    {
        $password_encode = password_hash($password, PASSWORD_BCRYPT);
        add_user($username, $password_encode, $email);
        
    	echo 'You\'ll be redirected in about 3 secs. If not, click <a href="index.php">HERE</a>.<br/>';
    }
}
else
{
    echo "Please verify you are not a robot first";
}
?>
<script language='javascript' type='text/javascript'>
    window.location.href='index.php'
    </script>