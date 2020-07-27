<?php
session_start();
session_regenerate_id(true);
?>

<?php
require_once('../header.php');
?>

<?php

$post_code = $_POST['postId'];
$content = $_POST['content'];

$dsn = 'mysql:dbname=manabi;host=localhost;charset=utf8';
$user = 'root';
$password = '1234';
$dbh = new PDO ($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql = "UPDATE post SET post_content = '$content' WHERE post_id = $post_code";
$stmt = $dbh->prepare($sql);
$stmt->execute();

?>

<br><br>
修正しました！
<br><br><br>
<a href="../main/post_list.php">投稿管理画面へ戻る</a>
<br><br>
<a href="../main/index.php">トップへ戻る</a>

<?php
require_once('../footer.php');
?>