<?php
include("config.php");

function db_connect(){
    global $nom_hote, $nom_user, $nom_base, $mdp;
    return pg_connect("host=$nom_hote user=$nom_user dbname=$nom_base password=$mdp");
}

function db_query($db,$query){
	return pg_query($db, $query);
}

function db_transaction($db,$query_array){
    pg_query($db,"BEGIN");
    $res=1;
    foreach ($query_array as $req) {
        $res *= pg_query($db,$req);
    }
    if($res==0){
        pg_query($db,"ROLLBACK");
    }
    else{
        pg_query($db, "COMMIT");
    }
}

function db_fetch($rep){
	return pg_fetch_assoc( $rep );
}


function db_count($rep){
	return pg_num_rows( $rep );
}


function db_close($db){
	return pg_close( $db );
}



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}





// Get newest articles, the path to its cover photo for index.php, number of comments and number of likes
function get_articles_for_index()
{
    $db = db_connect();
    $sql = "SELECT title, content, comments, likes, cover_path FROM article ORDER BY ardate DESC LIMIT 16";
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


function addArticle($title,$content,$tag,$username)
{
    $datetime=date("Y-m-d G:i:s");
    $sql = "INSERT INTO article (title, content, ardate, tag, username) 
        VALUES ('".pg_escape_string(utf8_encode($title))."','".pg_escape_string(utf8_encode($content))."','".$datetime."','".$tag."','".$username."')";
    if($db = db_connect()){  
        if (db_query($db, $sql)){
            echo "Data saved<br/>";
            db_close($db);
            return 1;
        }
        else
        {
            echo "Error of insert <br/>$sql<br />";
            db_close($db);
        }
    }
    else {
        echo "Error of connect<br/>$sql<br />";
        db_close($db);
    }
    return 0;
}

function get_aid_de_photo(){
    if($db = db_connect()){
        $req = "SELECT * FROM article order by aid DESC limit 1";
        $rep = db_query($db, $req);
        $result = db_fetch($rep);
        db_close($db);
        //echo "aid: ".$result["aid"];
        return $result["aid"];
    }
    return NULL;
}


function set_cover_photo($aid, $path)
{
    $db = db_connect();
    $sql = "UPDATE article SET cover_path = '$path' WHERE aid = '$aid'";
    db_query($db,$sql);
    db_close($db);
}

function add_photo(){
    $aid = get_aid_de_photo();
    $photo_path = "upload/".$_FILES["file"]["name"];
    echo $photo_path;
    $req = "INSERT INTO photo (aid, path) VALUES ('".$aid."','".$photo_path."')";
    if($db = db_connect()){
        $result = db_query($db, $req);
        db_close($db);
        set_cover_photo($aid, $photo_path);
        return $result;
    }
    return null;
}


function choseArticle($num)
{
    $db = db_connect();
    //chose the title of article.
    $sql = "SELECT * from article WHERE article.aid='$num'";
    if($result = db_query($db,$sql))
    {
         $row = db_fetch($result);
         return $row;
    }     
         
    else{
        db_close($db);
        return false;
    }
}




function choseCommentaire($num)
{
    $db = db_connect();
    $sql = "SELECT * FROM article WHERE aid = '$num' ";
    $result = db_query($db,$sql);
    if($row=db_fetch($result))
    {
        db_close($db);
        return $row;
    }
    else {
        db_close($db);
        return false;
    }
}

function get_aid_from_picture_url($path){
    if($db = db_connect()){
        $sql = "SELECT * FROM photo WHERE path = '$path'";
        if($rep = db_query($db, $sql)){
            if($result = db_fetch($rep)){
                db_close($db);
                return $result["aid"];
            }
        }
    }
    return null;
}

function get_information($username){
     $db = db_connect();
     $sql = "SELECT * FROM user1 WHERE username = '$username'";
     $result = db_query($db,$sql);
     if($row=db_fetch($result)){db_close($db); return $row;}
     else {db_close($db); return false;}
}
function get_nom_likes($username){
	$db = db_connect();
     $sql = "SELECT * FROM like_ar, article WHERE article.username = '$username' AND like_ar.aid = article.aid";
     $result = db_query($db,$sql);
     $nom = db_count($result);
     db_close($db);
     return  $nom;
}
function get_nom_comments($username){
	 $db = db_connect();
     $sql = "SELECT cid FROM commentaire, article WHERE article.username = '$username' AND commentaire.aid= article.aid";
     $result = db_query($db,$sql);
     $nom = db_count($result); 
     db_close($db);
     return  $nom;
}
function get_nom_article($username){
	$db = db_connect();
     $sql = "SELECT aid FROM article WHERE article.username = '$username'";
     $result = db_query($db,$sql);
     $nom = db_count($result);
     db_close($db);
     return  $nom;
}
function get_article($username){
	$db = db_connect();
    $sql = "SELECT * FROM article WHERE article.username = '".$username."'";
    $result = db_query($db,$sql);
    db_close($db);
    return $result;
}


// Return the famous article, with its aid, title, content, ardate, tag, username and number of likes
function get_famous_article()
{
    $db = db_connect();
    $sql = "SELECT article.aid, title, content, ardate, tag, article.username, count(*) AS likes FROM article JOIN like_ar USING (aid) GROUP BY aid ORDER BY likes DESC";
    $result = db_query($db,$sql);
    if($row = db_fetch($result)){
        db_close($db);
        return $row;
    }
    else {
        db_close($db); 
        return NULL;
    }
}


// Return the weekly famous article, with its aid, title, content, ardate, tag, username and number of likes
function get_weekly_famous_article()
{
    $db = db_connect();
    $datetime=date("Y-m-d G:i:s");
    $sql = "SELECT article.aid, title, content, ardate, tag, article.username, count(*) AS likes FROM article JOIN like_ar USING (aid) WHERE ".'"$datetime"'."-ardate <= '7 0:0:0'  GROUP BY aid ORDER BY likes DESC";
    $result = db_query($db,$sql);
    if($row = db_fetch($result)){
        db_close($db);
        return $row;
    }
    else {
        db_close($db); 
        return NULL;
    }
}


function get_photo($aid){
	$db = db_connect();
    $sql = "SELECT * FROM photo WHERE aid = '$aid'";
    $result = db_query($db,$sql);
    if($row = db_fetch($result)){db_close($db);
    	return $row["path"];
    }
    else {db_close($db); return NULL;}
}


// Collect all comments corresponding to article $aid in an array
function get_comments($aid)
{
    $db = db_connect();
    $sql = "SELECT username, comcontent, comdate FROM commentaire WHERE aid = '$aid' ORDER BY comdate DESC";
    $result = db_query($db,$sql);
    $size=db_count($sql);
    $usernames=array_fill(0, $size, "");
    $comcontents=array_fill(0, $size, "");
    $comdates=array_fill(0, $size, "");
    $i=0;
    while ($row=db_fetch($result))
    {
        $usernames[$i]=$row["username"];
        $comcontents[$i]=$row["comcontent"];
        $comdates[$i]=$row["comdate"];
        $i=$i+1;
    }
    db_close($db);
    return array($usernames,$comcontents, $comdates);
}


function article_nom_like($aid){
     $db = db_connect();
     $sql = "SELECT likes FROM article WHERE aid = '$aid'";
     $result = db_query($db,$sql);
     $row = db_fetch($result);
     db_close($db);
     return  $row['likes'];
}

function add_ar_like($aid,$username){
    $req = "INSERT INTO like_ar (aid, username) VALUES ('".$aid."','".$username."')";
    if($db = db_connect()){
        db_query($db, $req);
        db_close($db);
    }
}

function delete_ar_like($aid,$username){
    $req = "DELETE FROM like_ar WHERE aid = '$aid' AND username = '$username'";
    if($db = db_connect()){
        db_query($db, $req);
        db_close($db);
    }
}


// Update number of likes in article table
function update_likes($aid){
    $db = db_connect();
    // Collect number of likes
    $sql = "SELECT count(*) AS likes FROM like_ar WHERE aid = '$aid' GROUP BY (aid)";
    $result = db_query($db,$sql);
    $row = db_fetch($result);

    // Update in table article
    $sql = "UPDATE article SET likes = '".$row["likes"]."' WHERE aid = '$aid'";
    db_query($db,$sql);
    db_close($db);
}


// Update number of comments in article table
function update_comments($aid){
    $db = db_connect();
    // Collect number of comments
    $sql = "SELECT count(*) AS comments FROM commentaire WHERE aid = '$aid' GROUP BY (aid)";
    $result = db_query($db,$sql);
    $row = db_fetch($result);

    // Update in table article
    $sql = "UPDATE article SET comments = '".$row["comments"]."' WHERE aid = '$aid'";
    db_query($db,$sql);
    db_close($db);
}


// Delete a photo from a file directory
function deletePhoto($path)
{   
    if (!unlink($path))
    {
        echo ("Error deleting $path<br/>");
    } 
    else
    {
        echo ("Deleted $path<br/>");
    }
}


// Delete an article and all its contents (comments, likes and photos)
function deleteArticle($aid)
{   
    echo "...";
    if ($db = db_connect())
    {
        // Delete comments
        $sql = "DELETE FROM commentaire WHERE aid = $aid";
        if ($result = db_query($db, $sql))
            echo "Comments deleted<br/>";
        else
            echo "Failed to delete comments<br/>";

        // Delete likes
        $sql = "DELETE FROM like_ar WHERE aid = $aid";
        if ($result = db_query($db, $sql))
            echo "Likes deleted<br/>";
        else
            echo "Failet to delete likes<br/>";

        // Delete photos from file directory
        $sql = "SELECT * FROM photo WHERE aid = $aid";
        if ($result = db_query($db, $sql))
            while ($row = db_fetch($result))
                deletePhoto($row['path']);

        // Delete photos from table
        $sql = "DELETE FROM photo WHERE aid = $aid";
        if ($result = db_query($db, $sql))
            echo "Photos deleted<br/>";
        else
            echo "Failet to delete photos<br/>";

        // Delete articles
        $sql = "DELETE FROM article WHERE aid = $aid";
        if ($result = db_query($db, $sql))
            echo "Article $aid deleted<br/>";
        else
            echo "Failet to delete article $aid<br/>";
    }
    else 
        echo "Failed to connect to database<br/>";

    db_close($db);
}

//Si  clients deja like
function if_like($username,$aid){
     $db = db_connect();
     $sql = "SELECT username FROM like_ar WHERE aid = '$aid'";
     $result = db_query($db,$sql);
     while($row = db_fetch($result)){
         if($row['username'] == $username){
            db_close($db);
             return 1;
         }
         else{
            continue;
         }
     }
     db_close($db);
     return 0;

}
