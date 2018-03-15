
<?php

include("db.php");



$aid = $_POST['aid'];
$username = $_POST['username'];
add_ar_like($aid,$username);
update_likes($aid);
$nom = article_nom_like($aid);
echo "$nom";


?>
