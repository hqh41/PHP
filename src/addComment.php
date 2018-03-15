<?php
include("db.php");

session_start();

$comment=$_POST["comment"];
$datetime=date("Y-m-d G:i:s");
$username=$_POST["username"];
$aid=$_POST["aid"];



echo'
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      
        <link rel="stylesheet" type="text/css" href="css/normalize.css" />		
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<link rel="stylesheet" type="text/css" href="css/CreateArticle.css" />
    <title>Article</title>
          
  </head>
  <body>
      <div class="logo">
        <img src="photo/logo.png" alt="logo" width="100" height="69">
      </div>
   ';

if (isset($_SESSION["username"]))
{
    if ($comment=="")
    {
        echo "Comment invalid, it can't be empty.<br/>";
    }
    else
    {
        $db=db_connect();
        
        $sql = "INSERT INTO commentaire (username, aid, comcontent, comdate) VALUES ('".$username."','".$aid."','".pg_escape_string(utf8_encode($comment))."','".$datetime."')";
        // $sql="INSERT INTO commentaire (username, aid, comcontent, comdate) VALUES (".'"$username"'.", $aid,".'"$comment"'.",".'"$datetime"'." )";
        if (db_query($db, $sql))
        {
        echo "Comment added<br/>";
            update_comments($aid);
        }
        else
            echo "Error<br/>$sql<br/>";
        db_close($db);
    }
}
else echo "Please log in first<br/>";

echo
"<script language=javascript>history.back();</script>";



echo'
  </body>
  </html>
  ';