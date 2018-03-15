<?php
include ("db.php");
require_once(__DIR__ . '/../vendor/autoload.php');
//use Something\Example;

// grab recaptcha library
require_once "recaptchalib.php";

/*
// test the autoloader
$example = new Example();

// test the database connection
try {
    $user = 'tp_web';
    $pass = 'tp_web';
    $dbh = new PDO('pgsql:host=localhost;dbname=tp_web', $user, $pass);

    $tableRows = [];
    foreach ($dbh->query("select whatever from test limit 10;") as $row) {
        $tableRows[] = $row[0];
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
*/
 
  
echo'
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <title>The Rabbit Book</title>
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
    
  
 session_start();
 //$_SESSION["username"] === null;
 //$_SESSION["admin"] === null;
 if (isset($_SESSION["username"])) {
   echo '<p class="bonjour">Welcome, ';
   echo  $_SESSION["username"];
   echo '</p>';
 } 
 else {
   //  验证失败，将 $_SESSION["username"] 置为 null
   $_SESSION["username"] = null;
 }  

          
 echo '
    <br><br>
    <div class="nav">
      <ul>
          <li><a href=index.php>           |      Home           |</a></li>';
        
  if (isset($_SESSION["username"])) {
     echo'
          <li><a href="CreateArticle.php">|      Create article  |</a></li>
          <li><a href="information.php">  |       My  Profil     |</a></li>
          <li><a href=logout.php>         |      Log out         |</a></li>
          ';
  }
  else {
      echo '
          <li><a href=regis.html>         |      Sign up        |</a></li>
          <li><a href=login.html>         |      Log in         |</a></li>
          ';
      //  验证失败，将 $_SESSION["username"] 置为 null
      $_SESSION["username"] = null;
  }  
  
  
 echo '
      </ul>
    </div>
    <div class="container">
      <br>
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
    
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>
        
        
        
        <div class="nav">
        <ul>
        <h4 style="color:rgb(196, 28, 91); ">'."Tags ".'</h4>
        <li><a href=allFood.php>Food</a></li> 
        <li><a href=allAnimals.php>Animal</a> </li>
        <li> <a href=allFashion.php>Fashion</a> </li>
        <li><a href=allTour.php>Tour</a> </li>
        </ul>
        </div>
        
  <div class="container">
  <br>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="photo/famous.jpeg" alt="famous" width="460" height="345">
        </div>

        <div class="item">
          <img src="photo/famous2.jpeg" alt="Chania" width="460" height="345">
        </div>
    
        <div class="item">
          <img src="photo/famous3.jpeg" alt="Flower" width="460" height="345">
        </div>

        <div class="item">
          <img src="photo/famous4.jpeg" alt="Flower" width="460" height="345">
        </div>

    
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

  <br><br><br>
  
  
  <script type="text/javascript">
    function jump_with_url(picture) {
        window.open("openArticle.php?" + picture, "details", "toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no");
    }
  </script>
';

  
  


list($titles, $contents, $comments, $likes, $cover_photos)=get_articles_for_index();
  
$numArticle=count($titles);
$numRow=0;
$numRowMax=($numArticle-$numArticle%4)/4;
while ($numRow<$numRowMax) {
    echo '
  <div class="w3-row-padding w3-padding-16 w3-center" id="food">
    <div class="w3-quarter">
      <img src="' . $cover_photos[4 * $numRow] . '" alt="" width="250" height="200" onclick="jump_with_url(\'' . $cover_photos[4 * $numRow] . '\')">
      <div class="w3-container ">
      <p><b>' . $titles[4 * $numRow] . '</b></p>
      <p>' . $contents[4 * $numRow] . '</p>
        <a class="note-comment"> 
        <img src="photo/comment.png" alt="comment" width="20" height="20" style="vertical-align: top;">
          <span style="color:gray;">' . $comments[4 * $numRow] . '</span>
        </a>
        
        <a class="note-like">
          <img src="photo/heart.png" alt="heart" width="20" height="17" style="vertical-align: text-top;">
          <span style="color:gray;">' . $likes[4 * $numRow] . '</span>
        </a>
      </div>
    </div>
    <div class="w3-quarter">
      <img src="' . $cover_photos[4 * $numRow + 1] . '" alt="" width="250" height="200" onclick="jump_with_url(\'' . $cover_photos[4 * $numRow + 1] . '\')">
      <div class="w3-container">
      <p><b>' . $titles[4 * $numRow + 1] . '</b></p>
      <p>' . $contents[4 * $numRow + 1] . '</p>
        <a class="note-comment"> 
        <img src="photo/comment.png" alt="comment" width="20" height="20" style="vertical-align: top;">
          <span style="color:gray;">' . $comments[4 * $numRow + 1] . '</span>
        </a>
        <a class="note-like">
          <img src="photo/heart.png" alt="heart" width="20" height="17" style="vertical-align: text-top;">
          <span style="color:gray;">' . $likes[4 * $numRow + 1] . '</span>
        </a>
      </div>
    </div>
    <div class="w3-quarter">
      <img src="' . $cover_photos[4 * $numRow + 2] . '" alt="" width="250" height="200" onclick="jump_with_url(\'' . $cover_photos[4 * $numRow + 2] . '\')">
      <div class="w3-container ">
      <p><b>' . $titles[4 * $numRow + 2] . '</b></p>
      <p>' . $contents[4 * $numRow + 2] . '</p>
        <a class="note-comment">   
        <img src="photo/comment.png" alt="comment" width="20" height="20" style="vertical-align: top;">
          <span style="color:gray;">' . $comments[4 * $numRow + 2] . '</span>
        </a>
        <a class="note-like">
           <img src="photo/heart.png" alt="heart" width="20" height="17" style="vertical-align: text-top;">
          <span style="color:gray;">' . $likes[4 * $numRow + 2] . '</span>
        </a>
      
      </div>
    </div>
    <div class="w3-quarter">
      <img src="' . $cover_photos[4 * $numRow + 3] . '" alt="" width="250" height="200" onclick="jump_with_url(\'' . $cover_photos[4 * $numRow + 3] . '\')">
            <div class="w3-container">
      <p><b>' . $titles[4 * $numRow + 3] . '</b></p>
      <p>' . $contents[4 * $numRow + 3] . '</p>
      <a class="note-comment">   
        <img src="photo/comment.png" alt="comment" width="20" height="20" style="vertical-align: top;">
          <span style="color:gray;">' . $comments[4 * $numRow + 3] . '</span>
        </a>
        <a class="note-like">
        <img src="photo/heart.png" alt="heart" width="20" height="17" style="vertical-align: text-top;">
          <span style="color:gray;">' . $likes[4 * $numRow + 3] . '</span>
        </a>
      
      </div>
    </div>
  </div>
  ';
  $numRow++;
}

if (4*$numRow<$numArticle) {
    echo '
  <div class="w3-row-padding w3-padding-16 w3-center">
    <div class="w3-quarter">
      <img src="' . $cover_photos[4 * $numRow] . '" alt="" width="250" height="200" onclick="jump_with_url(\'' . $cover_photos[4 * $numRow] . '\')">
      <div class="w3-container">
      <p><b>' . $titles[4 * $numRow] . '</b></p>
      <p>' . $contents[4 * $numRow] . '</p>
        <a class="note-comment"> 
        <img src="photo/comment.png" alt="comment" width="20" height="20" style="vertical-align: top;">
          <span style="color:gray;">' . $comments[4 * $numRow] . '</span>
        </a>
        <a class="note-like">
        <img src="photo/heart.png" alt="heart" width="20" height="17" style="vertical-align: text-top;">
          <span style="color:gray;">' . $likes[4 * $numRow] . '</span>
        </a>
      </div>
    </div>
    ';

    if (4 * $numRow + 1 < $numArticle) {
        echo '
    <div class="w3-quarter">
      <img src="' . $cover_photos[4 * $numRow + 1] . '" alt="" width="250" height="200" onclick="jump_with_url(\'' . $cover_photos[4 * $numRow + 1] . '\')">
      <div class="w3-container ">
      <p><b>' . $titles[4 * $numRow + 1] . '</b></p>
      <p>' . $contents[4 * $numRow + 1] . '</p>
        <a class="note-comment">    
        <img src="photo/comment.png" alt="comment" width="20" height="20" style="vertical-align: top;">
          <span style="color:gray;">' . $comments[4 * $numRow + 1] . '</span>
        </a>
        <a class="note-like">
        <img src="photo/heart.png" alt="heart" width="20" height="17" style="vertical-align: text-top;">
          <span style="color:gray;">' . $likes[4 * $numRow + 1] . '</span>
        </a>
      </div>
    </div>
    ';

        if (4 * $numRow + 2 < $numArticle) {
            echo '
    <div class="w3-quarter">
      <img src="' . $cover_photos[4 * $numRow + 2] . '" alt="" width="250" height="200" onclick="jump_with_url(\'' . $cover_photos[4 * $numRow + 2] . '\')">
      <div class="w3-container ">
      <p><b>' . $titles[4 * $numRow + 2] . '</b></p>
      <p>' . $contents[4 * $numRow + 2] . '</p>
        <a class="note-comment"> 
        <img src="photo/comment.png" alt="comment" width="20" height="20" style="vertical-align: top;">
          <span style="color:gray;">' . $comments[4 * $numRow + 2] . '</span>
        </a>
        <a class="note-like">
        <img src="photo/heart.png" alt="heart" width="20" height="17" style="vertical-align: text-top;">
          <span style="color:gray;">' . $likes[4 * $numRow + 2] . '</span>
        </a>
      </div>
    </div>';
        }
    }
echo'
  </div>';
}
  
  
 echo' </body>
  </html>

';

/*
<!-- Pagination -->
  <div class="w3-center w3-padding-32">
    <div class="w3-bar">
      <a href="#" class="w3-bar-item w3-button w3-hover-black">《</a>
      <a href="#" class="w3-bar-item w3-black w3-button">1</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">2</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">3</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">4</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">》</a>
    </div>
  </div>
*/