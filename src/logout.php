<?php
    session_start();
    // Delete session information
    session_unset($_SESSION['username']);
    session_unset($_SESSION['admin']);
    session_destroy();
    // Come back to index
    header("refresh:1;url=index.php");
    
echo'
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <title>Log out</title>
    <link href="css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function openwin() {  
               window.open("openArticle.php", "newwindow", "height=700px, width=500px,top=100px, left=200px,toolbar =no, menubar=no, scrollbars=no, resizable=no, location=no, status=no")   
         }
    </script>
  </head>
  <body>
    <div class="logo">
      <img src="photo/logo.png" alt="Chania" width="100" height="69">
    </div>
    <br>
    ';
  
    echo "You are now logged out<br/>";

 echo' </body>
  </html>

';