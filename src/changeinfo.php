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

    <title>Change Information</title>
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
				echo $row["photo"];
			}
				?>  alt="Personal avatar" width="100" height="100"/>
		
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
	</br>
	</br>
	<div style="width:800px;height:1px;margin:0px auto;padding:2px;background-color:rgb(196, 28, 91);overflow:hidden;"></div>
	<div class = "infor">
		<p><h class="tit">Change Your Information </h></p>

		<form action="change.php" method="POST" enctype="multipart/form-data">
			<br>
			<br>
	          	<label for="file">Photo:</label>
	          	<input type="file" name="file" id="file" />
				<br>
				<br>
				<br>
				<label class="input_name">Nickname</label>
          		<input class="input_field" type="text" name="nickname" id="nickname" value="<?php $row = get_information($username); echo $row[nickname];?>"/>
           		<br>
           		<br>
           		<br>
				<label class="input_name">Age</label>
          		<input class="input_field" type="text" name="age" id="age" value="<?php $row = get_information($username); echo $row[age];?>"/>
          		<br>
           		<br>
           		<br>
				<label class="input_name">Email</label>
          		<input class="input_field" type="text" name="email" id="email" value="<?php $row = get_information($username); echo $row[email];?>"/>
          		<br>
           		<br>
           		<br>
          		<label>Sexe</label> 
            		<select name="sexe" class="select"> 
						<option value="0">M</option> 
						<option value="1">F</option> 
					</select> 
				<br>
           		<br>
           		<br>
				<label class="input_name">Description(<100)</label>
          		<textarea id="description" name="description" rows="6" cols="40" >
          			<?php $row = get_information($username); echo $row[description];?>
          		</textarea>
          		<br>
           		<br>
           		<br>
           		<div class="container">		  
		        <div class="button-effect">
		          <a class="effect" href="information.php" title="information">Cancel</a>
		          <input type="submit" value="Change"/>
		        </div>
		       </div>
		</form>
	<div>
		



</body>
</html>