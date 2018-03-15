<?php

include ("db.php");


//include("CreateArticle.php");
session_start();
$username = $_SESSION["username"];

echo'
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      
        <link rel="stylesheet" type="text/css" href="css/normalize.css" />		
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<link rel="stylesheet" type="text/css" href="css/CreateArticle.css" />
        <title>AddArticle</title>
  </head>
  <body>
      <div class="logo">
        <img src="photo/logo.png" alt="logo" width="100" height="69">
      </div>
      <br>
      <div class="nav">
          <ul>
        <li><a href=index.php>           |      Home           |</a></li>
  	    <li><a href=logout.php>         |      Log out         |</a></li>
		
         </ul>
      </div>
      
   ';


$title=$_POST["title"];
$content=$_POST["content"];
$photo=$_POST["photo"];
$tag=$_POST["tag"];
$file=$_FILES["file"];

function check_title ($title)
{
    $max_len = 30 ;
    $min_len = 1;
    $title_good = "title is correct";
    
    // Check for empty title
    if ($title == "")
    {
        $title_good = "title can't be empty";
        return $title_good;
    }
    
    // Check for title length
    if (strlen($title)>$max_len)
    {
        $title_good = "title too long !";
        return $title_good;
    }
    if(strlen($title)<$min_len)
    {
        $title_good = "title too short !";
        return $title_good;
    }
    
    return $title_good;
}


function check_content ($content)
{
    $max_len = 500 ;
    $min_len = 1;
    $content_good = "content is correct";
    
    
    if ($content == "")
    {
        $title_good = "content can't be empty";
        return $title_good;
    }
    
    
    if (strlen($content)>$max_len)
    {
        $content_good = "content too long !";
        return $content_good;
    }
    if(strlen($content)<$min_len)
    {
        $content_good = "content too short !";
        return $content_good;
    }
    
    return $content_good;
}


if ($file==NULL)
{
    echo "You must upload a photo.";
}
else 
{

$title_good = check_title($title);
$content_good = check_content($content);

$error = false;

if ($title_good != "title is correct")
{
    $error = true;
    echo $title_good."<br/>";
}

if ($content_good != "content is correct")
{
    $error = true;
    echo $content_good."<br/>";
}









if((($file["type"]) == "image/gif") || ($file["type"] == "image/jpeg") || ($file["type"] == "image/pjpeg") && ($file["size"] < 2000)){
    if($file["error"] > 0){
        echo "Error: ".$file["error"]."<br />";
    }
    else{
        echo "Upload: ".$file["name"]."<br />";
        echo "Type: ".$file["type"]."<br />";
        echo "Size: ".($file["size"] / 1024)."<br />";
        echo "Stored in: ".$file["tmp_name"]."<br />";
        
        if(file_exists("upload/".$file["name"])){
            echo $file["name"]."already exists"."<br />";
        }
        else{
            move_uploaded_file($file["tmp_name"], "upload/".$file["name"]);
            echo "Stored in: "."upload/".$file["name"];
        }
    }
}
else{
    echo "Invalid file, image can only be .gif, .jpeg, .pjeg<br/>File size should be less than 2000kB.<br/>";
}

// Creating a new artitle if no error

if ($error == false)
{
    if(addArticle($title,$content,$tag,$username))
        echo "$username, a new article has been created. </br>Redirection in about 5 second. If not, click <a href='index.php'>HERE</a>.<br/>";
    /*header("refresh:5; index.php");*/
}


$aid = get_aid_de_photo();
$result = add_photo();
}

echo'
  </body>
  </html>
  ';
  
?>