<?php

include ("db.php");


 $admin = false;

session_start();

$username = $_SESSION["username"];





?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8" />

    <title>Personal Page</title>
    <link href="css/infor.css" rel="stylesheet">
    	 

</head>
<body class="big">

	
	
    
	<div class="back">
		
		<div class="logo">
      	<img src="photo/logo.png" alt="Chania" width="100" height="69">
   		 </div>
	</div>

<p>
	<div class="nav">
  <ul>
        <li><a href=index.php>           |      Home           |</a></li>
		<li><a href="CreateArticle.php">|      Create article  |</a></li>
  	    <li><a href=logout.php>         |      Log out         |</a></li>
  </ul>
</div>
</p>

<div style="width:800px;height:1px;margin:0 auto;padding:2px;background-color:rgb(196, 28, 91);overflow:hidden;"></div>
	<div class = "photo">
		<img src=<?php $row = get_information($username);
			if($row["photo"] == NULL){
				echo "photo/noimage.gif" ;
			}
			else {
				echo "$row[photo]";
			}
				?>  alt="Personalavatar" width="100" height="100"/>
		
	</div>
	
	<div class="hello">
		<div style="color:rgb(196, 28, 91)"><?php echo "Hello! $username";?> <a class="a" href=changePass.html>[change password]</a></div>
		<div class="nav">
	  		<table class="table" cellspacing="12" frame="hsides" rules=cols>
				<tr class="a">
					<td>Likes     </td>
					<td>Comments     </td>
					<td>Articles     </td>
				</tr>
				<tr class = "a">
					<td><?php $nom = get_nom_likes($username); echo "$nom";?></td>
					<td><?php $nom = get_nom_comments($username); echo "$nom";?></td>
					<td><?php $nom = get_nom_article($username); echo "$nom";?></td>
				</tr>
			</table>
		</div>
	</div>
	<div style="clear:both;"></div>
	<br/>
	<br/>
	<div style="width:800px;height:1px;margin:0 auto;padding:2px;background-color:rgb(196, 28, 91);overflow:hidden;"></div>
	<div class = "infor">
		<p><h class="tit">Personal Information </h><a class="a" href="changeinfo.php">[Modify]</a> </p>
	   <p>დდდ Nickname: <?php $row = get_information($username); echo ($row["nickname"]);?></p>
	   <p>დდდ Sexe: <?php $row = get_information($username); 
						  if($row["sexe"]=='M'){
							echo "♂";
						  }
						  else if($row["sexe"]=='F'){
						  	echo "♀";
						  }
						  else {echo "A Secret";}?></p>
		<p>დდდ Age: <?php $row = get_information($username); 
						  if($row["age"]==NULL){
							echo "A Secret";
						  }
						  else {echo $row["age"];}?></p>
		<p>დდდ Email : <?php $row = get_information($username); echo $row["email"];?></p>
		<p>დდდ Description: <?php $row = get_information($username); 
						  if($row["description"]==NULL){
							echo "You have no description";
						  }
						  else {echo ($row["description"]);}?></p>
		<p>დდდ Registration date: <?php $row = get_information($username); echo $row["register_date"];?></p>
		<p>დდდ Last login: <?php $row = get_information($username); echo $row["last_login"];?></p>
	<div>
		
<div style="width:800px;height:1px;margin:0 auto;padding:2px;background-color:rgb(196, 28, 91);overflow:hidden;"></div>
	<div class = "arti">
		<p><h class="tit">Your Articles</h><a class="a" href=CreateArticle.php>[Add]</a> </p>
    </div>
    
   
    
    <?php 
   
  
    	 
    	$num = get_nom_article($username); 
        $row = get_article($username);
        $i = 1;
        if($num == 0)
    		{echo "You have no articles.";}
    	else
    	{
    		while($result = db_fetch($row))
    		{
    			$path=$result["cover_path"];
    			$name = $result["title"];
    			if($i%5 == 0){echo "</br>";}
    			echo'<script type="text/javascript">
    function jump_with_url(picture) {
        window.open("openArticle.php?" + picture, "details", "toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no");
    }
  </script>';
      			echo "
      		
      			<div class=\"fl\">
					  </br> $name </br>
					  <img src=\"$path\" alt=\"Photo\" width=\"200\" height=\"150\" onclick=\"jump_with_url('$path')\">
					  </br>
					  <a class=\"a\" href=openArticle.php>$row[title]</a>
					  </div>";
				$i++;
    		}	
    	}
    	
?>



</body>
</html>