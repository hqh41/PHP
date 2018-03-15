<?php
include("db.php");

$email=$_POST["email"];


// Check if this user exist in database
$db=db_connect();
$query="select * from user1 where username='$username' or email='$email'";
$result=db_query($db, $query);
$row=db_fetch($result);
if ($row)
{
    
}

db_close($db);