<?php

include("db.php");

session_start();

$username = $_SESSION["username"];

$nickname=$_POST["nickname"];
$age=$_POST["age"];
$email=$_POST["email"];
$sexe=$_POST["sexe"];
$description=$_POST["description"];


function checkemail($email)
{
    $emailGood="Email is correct";
    
    // Check for email validity
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $emailGood="Invalid email format";
        return $emailGood;
    }
    return $emailGood;
}




if((($_FILES["file"]["type"]) == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") ||($_FILES["file"]["type"] == "image/pjpeg") && ($_FILES["file"]["size"] < 2000)){
        if($_FILES["file"]["error"] > 0){
        echo "Error: ".$_FILES["file"]["error"]."<br />";
        }
        else{
            echo "Upload:".$_FILES["file"]["name"]."<br />";
            echo "Type:".$_FILES["file"]["type"]."<br />";
            echo "Size:".($_FILES["file"]["size"] / 1024)."Kb<br />";
            echo "Stored in: ".$_FILES["file"]["tmp_name"]."<br />";
            
            if(file_exists("head_portrait/".$_FILES["file"]["name"])){
                echo $_FILES["file"]["name"]."already exists"."<br />";
            }
            else{
                move_uploaded_file($_FILES["file"]["tmp_name"], "head_portrait/".$_FILES["file"]["name"]);
                echo"Stored in: "."head_portrait/".$_FILES["file"]["name"];
            }
        }
}
else{
    echo "Invalid file <br>";
}

function add_head_portrait($user){
    $photo_path = "head_portrait/".$_FILES["file"]["name"];
    echo "$user <br>";
    $req = "UPDATE user1 SET photo = '".$photo_path."' WHERE username = '".$user."'";
    if($db = db_connect()){
        if(db_query($db, $req)){
            db_close($db);
        }
        else
            echo "query failed";
    }
    else
        echo "connect failed";
    db_close($db);
}




function change_nickname($username,$nickname){
    if(strlen($nickname) > 10){
        echo "Nickname: $nickname should be smaller than 10 characters. <br>";
    }
    else if($nickname == NULL){
        echo "Nickname does not change <br>";
        } 
        else{
            $req = "UPDATE user1 SET nickname = '".pg_escape_string(utf8_encode($nickname))."' WHERE username = '".$username."'";
            if($db = db_connect()){
                if(db_query($db, $req))
                    db_close($db);
                else
                    echo "query failed<br/>$req<br/>";
            }
            else
                echo "connect failed";
            db_close($db);
            echo "Nickname: $nickname <br>";
        }
}



function change_age($username, $age){
    //$row = get_information($username);
    if($age > 200 || $age < 0){
        echo "Age cannot smaller than 0 or biger than 200";
    }
    else{
         $req = "UPDATE user1 SET age = $age WHERE username = '".$username."'";
        if($db = db_connect()){
         if(db_query($db, $req)){
                db_close($db);
         }
         else
                echo "query failed";
        }
        else
          echo "connect failed";
        db_close($db);
        echo "Age : $age <br>";
    }
}

function change_email($username, $email){
    $checkemail = checkemail($email);
    if($checkemail != "Email is correct"){
        echo "Email is not correct <br>";
    }
    else if($email == NULL){
        echo "email does not change <br>";
    }
    else{
         $req = "UPDATE user1 SET email = '".$email."' WHERE username = '".$username."'";
         if($db = db_connect()){
         if(db_query($db, $req)){
                db_close($db);
         }
         else
                echo "query failed";
        }
        else
          echo "connect failed";
        db_close($db);
        echo "Email: $email <br>";
    }
}

function change_sexe($username, $sexe){
    if ($sexe == 0)
        $sexe = 'M';
    else
        $sexe = 'F';
    $req = "UPDATE user1 SET sexe = '".$sexe."' WHERE username = '".$username."'";
    if($db = db_connect())
    {
        if(db_query($db, $req))
            db_close($db);
        else
            echo "query failed";
    }
    else
        echo "connect failed";
    db_close($db);
    echo "Sexe : $sexe <br>";
}


function change_description($username, $description){
    if(strlen($description) > 100){
        echo "description need to be smaller than 100 characters. <br>";
    }
    $req = "UPDATE user1 SET description = '".pg_escape_string(utf8_encode($description))."' WHERE username = '".$username."'";
    if($db = db_connect()){
        if(db_query($db, $req)){
            db_close($db);
        }
        else
            echo "query failed<br/>$req";
    }
    else
        echo "connect failed";
    db_close($db);
    echo "Description : $description <br>";
}



add_head_portrait($username);
change_nickname($username,$nickname);
change_age($username,$age);
change_email($username,$email);
change_sexe($username,$sexe);
change_description($username,$description);

echo "It will go to your information page in 1 seconds<br/>";
?>

<script language="javascript" type="text/javascript"> 
setTimeout("location.href='information.php'", 3000);
</script>