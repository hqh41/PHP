
  <?php //receive parametres from CreateArticle.html
        $title=$_POST["title"];
        $texte=$_POST["texte"];
        $ardate=$_POST["ardate"];
        $tag=$_POST["tag"];
        $userid=$_POST["userid"];
        
   //connect database postgresql
        enTete("CreateArticle successfully");
        $db = db_connect();

        if(!$db){
           echo "Error : Unable to open database\n";
        } else {
           echo "<h>Opened database successfully</p><br>\n";
        }

         $sql="
            INSERT INTO article (title,texte,ardate,tag,userid)
            VALUES ($title,$texte,$ardate,$tag,$userid)";


         $ret = db_query($db,$sql);
         if(!$ret){
            echo "Error";
        } else {
            echo "insertion successfully\n";
            echo '<a href=index.php>Return to home</a></br>';
        }
        
        db_close($db);
    















