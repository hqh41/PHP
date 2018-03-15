<?php
include ("db.php");

echo'
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <title>Fashion</title>
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

echo '<br/><br/><br/><br/>';


echo '        <div class="nav">
        <ul>
        <h4 style="color:rgb(196, 28, 91); ">'."Tags: ".'</h4>
        <li><a href=allFood.php>Food</a></li> 
        <li><a href=allAnimals.php>Animal</a> </li>
        <li> <a href=allFashion.php>Fashion</a> </li>
        <li><a href=allTour.php>Tour</a> </li>
        </ul>
        </div>';

echo  ' <script type="text/javascript">
    function jump_with_url(picture) {
        window.open("openArticle.php?" + picture, "details", "toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no");
    }
  </script>
';

function get_fashion_articles()
{
    $db = db_connect();
    $sql = "SELECT title, content, comments, likes, cover_path FROM article WHERE tag='fashion' ORDER BY ardate DESC";
    $result = db_query($db, $sql);
    // Get the count of articles in database
    $size=db_count($sql);

    // Collect data about articles
    $titles=array_fill(0, $size, "");
    $contents=array_fill(0, $size, "");
    $comments=array_fill(0, $size, "");
    $likes=array_fill(0, $size, "");
    $photos=array_fill(0, $size, "");
    $i = 0;
    while($row = db_fetch($result))
    {
        $titles[$i] = $row["title"];
        $contents[$i] = $row["content"];
        $comments[$i] = $row["comments"];
        $likes[$i] = $row["likes"];
        $photos[$i] = $row["cover_path"];
        $i++;
    }
    db_close($db);
    return array($titles, $contents, $comments, $likes, $photos);
}

list($titles, $contents, $comments, $likes, $cover_photos)=get_fashion_articles();

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
