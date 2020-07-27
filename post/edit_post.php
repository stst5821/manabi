<?php
session_start();
session_regenerate_id(true);
?>

<?php
require_once('../header.php');
?>

<?php

try
{

$post_code = $_GET['post_id'];

$dsn = 'mysql:dbname=manabi;host=localhost;charset=utf8';
$user = 'root';
$password = '1234';
$dbh = new PDO ($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM member LEFT JOIN post ON member.user_id = post.user_id WHERE post.post_id = $post_code";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

$content = $rec['post_content'];
$name = $rec['name'];
$created = $rec['created_at'];

$dbh = null;

}
catch(Exception $e) 
{
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>
<h2>投稿修正</h2>

<form method="post" action="edit_post_done.php">
    <input type="hidden" name="postId" value='<?= $post_code ?>'>
    <textarea class="test" name="content" required="required"><?= $content; ?></textarea>
    <br><br>
    <input type="submit" value="修正する">

</form>
<br><br>
<a href="../main/post_list.php">投稿管理画面へ戻る</a>

<a href="../main/index.php">トップへ戻る</a>

<?php
require_once('../footer.php');
?>