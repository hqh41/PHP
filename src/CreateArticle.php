<?php 
 
    session_start();
    // Test if user isconnected
    if (! isset($_SESSION["username"])) 
    {
        header("refresh:3; url=login.html");
        echo "You have not right to create an article, please login first.<br/>";
        echo 'You\'ll be redirected to login page in about 3 secs. If not, click <a href="login.html">HERE</a>.';
    }
    else{

echo'
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
      
        <link rel="stylesheet" type="text/css" href="css/normalize.css" />		
	    <link rel="stylesheet" type="text/css" href="css/demo.css" />
	    <link rel="stylesheet" type="text/css" href="css/component.css" />
	    <link rel="stylesheet" type="text/css" href="css/CreateArticle.css" />
        
        <title>Create article</title>
        <script type="text/javascript">   
        
            function readAsDataURL(){  
        
                var file = document.getElementById("file").files;
                var result=document.getElementById("result");
                for(var i = 0; i< file.length; i++) {
                    var reader = new FileReader();    
                    reader.readAsDataURL(file[i]);  
                    reader.onload=function(e){  
                        result.innerHTML = result.innerHTML + \'<img src="\' + 
                            this.result +\'" alt="" style="width:200px;height:160px"/>\';
                    }
                }
            } 
        </script>        
    </head>
    <body>
        <div class="logo">
            <img src="photo/logo.png" alt="logo" width="100" height="69">
        </div>
   ';
   
echo'
   
    <form action="addArticle.php" method = "post" enctype="multipart/form-data" class="form1">
        <h3 class="title">Title(1~30)</h3>
        <br>
        <div class="container" style="text-align: center;">
            <span class="input input--haruki">
                <input class="input__field input__field--haruki" type="text" id="input-1" name="title"/>
                <label class="input__label input__label--haruki" for="input-1">
                    <span class="input__label-content input__label-content--haruki">   </span>
                </label>
            </span>
        </div>
        <br>
        <h3 class="content">Content(1~500)</h3>
        <br>
        <input type="textarea" name="content" id="area1" />
         
        <br>
          
        <h3 class="tag">Select a tag</h3>
        <br>
        <span class="tag">food</span><input type="radio" name="tag" value="food"/>
        <span class="tag">fashion</span><input type="radio" name="tag" value="fashion"/>
        <span class="tag">tour</span><input type="radio" name="tag" value="tour"/>
         <span class="tag">animal</span><input type="radio" name="tag" value="animal"/>
         
        <br /><br />
        <input type="file" name="file" id="file" />
         
        <br><br>
        <input type="reset" value="Reset">
        <input type="submit" value="Submit">
    </form>
</body>
</html>
';
    }