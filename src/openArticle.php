
<?php

include("db.php");

session_start();
$username=$_SESSION["username"];


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
  
  
  
  
     echo '
    <br><br>
    <div class="nav" style="text-align:center;">
     <a href=index.php>           |      Home           |</a></div>';

   $picture_url = $_SERVER["QUERY_STRING"];
   /*通过主页图片找到对应的aid 通过aid提取其他关于图片的内容 用这个aid提取别的关于图片的信息*/
   $aid = get_aid_from_picture_url($picture_url);
   
 
   $article = choseArticle($aid);
   
   echo'<h2 style= "text-align:center;" >'."Title : ".$article["title"].'</h2>';
   
    echo'<p style= "text-align:center;" >'."My Tag : ".$article["tag"].'</p>';
   
   echo'<p style= "text-align:center;" >'."Content : ".$article["content"].'</p>';
 
   
   //这里是图片
   
   echo '<div class="photo2">';
  echo '<img src="'.$picture_url.'" style="width:50%; display:block;margin:auto;padding:auto;">';
   echo '</div>';
   echo'<br><br><br><br>';
   echo'<script type="text/javascript">
    function jump_with_user(user) {
        window.open("otherinformation.php?" + user, "details", "toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no");
    }
  </script>';
  
  
    echo'<h3 style= "text-align:center;" >CREATED BY :
    <button onclick="jump_with_user(\''.$article["username"].'\')">'.$article["username"].'</button></h3>';
    

    
$nom = article_nom_like($aid);
    
//点赞  
echo "
<script language = javascript src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\">
</script>
<script>
$(document).ready(function(){
    $(\"#like3\").click(function(){
        if($(this).attr('class') == 'heart'){
                $(this).attr(\"class\",\"heart1\");
                $.ajax({
                    type: \"POST\",
                    url: \"update_like.php\",
                    data: {
                        \"aid\": $aid,
                        \"username\": \"$username\"
                    },
                    cache: false,
                    success: function(reponse){
                            $(\"#likeCount3\").html(reponse);
                            alert(\"Thank you\");
                    },
                });
        }
        else{
                $(this).attr(\"class\",\"heart\");
                $.ajax({
                    type: \"POST\",
                    url: \"update_like1.php\",
                    data: {
                        \"aid\": $aid,
                        \"username\": \"$username\"
                    },
                    cache: false,
                    success: function(reponse){
                        $(\"#likeCount3\").html(reponse);
                        alert(\"T.T\");
                    },
                });
        }
    });
});
$(document).ready(function(){
    $(\"button#delete\").click(function(){
                $.ajax({
                    type: \"POST\",
                    url: \"delete_article.php\",
                    data: {
                        \"aid\": $aid
                    },
                    cache: false,
                    success: function(reponse){
                            
                            alert(\"You have removed this article.\");
                            $(location).attr('href','index.php');
                    },
                });
    });
});
</script>
";



$if_like = if_like($username,$aid);


echo'
<div class="feed" id="feed1" >';

if($if_like){
echo'<div class="heart1" id="like3" rel="like"></div>';

}

else{
echo'<div class="heart" id="like3" rel="like"></div>';
}

echo'  <div class="likeCount" id="likeCount3" >'.$nom.'</div>
</div>  ';

//add comments

echo'<form action="addComment.php" method = "post" enctype="multipart/form-data" class="form1">';


echo'
        <h3>Please write your comments~: </h3>
        <input type="textarea" name="comment" id="area1" />
        </br>
        <input type="reset" value="Reset">
        <input type="submit" value="Submit">';
        echo'
        <input type="hidden" value="'.$aid.'"  name="aid"/>';
        echo'
        <input type="hidden" value="'.$username.'"  name="username"/>';
echo'</form>';


//afficher les commentaires

echo'
<div class="content" id="content" >';

echo '</div>';

list($usernames, $comcontents, $comdates)=get_comments($aid);
$size=count($usernames);
    for($i=0; $i<$size; $i++)
    {
        echo '<div class="commen" style="text-align:center;">';
        echo '<h4>'.$usernames[$i]." says: ".'</h4>';
        echo '<p>'.$comcontents[$i].'<p>';
        echo '<p>'." date ".$comdates[$i].'<p>';
        echo '---------------------------------------';
        echo '</div>';
    }
    



       if($_SESSION["admin"])
       {  
             echo '<button type="button" id="delete">Click Me for delete</button>';
       }     

echo'
  </body>
  </html>
  ';

