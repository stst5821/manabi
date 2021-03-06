<?php
session_start();
session_regenerate_id(true);
?>

<?php
require_once('../header.php');
?>

<h2>投稿削除</h2>

<p>以下の記事を削除します。よろしいですか？</p>
<hr>
<?php

try
{

$post_code = $_GET['post_id'];

$dsn = 'mysql:dbname=manabi;host=localhost;charset=utf8';
$user = 'root';
$password = '1234';
$dbh = new PDO ($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

// memberとpostテーブルをJOIN ONを使ってuser_idで結合し、レコードを取り出す。
// ログイン中の会員のuser_idを使いWHERE句で絞り込みして、自分の投稿だけを抽出している。
// ORDER BYでcreated_at(投稿日時)が新しい順にDESCで降順で並べ替え
// 条件に変数を使う場合、SELECT文全体をダブルクオートで囲む必要がある。シングルクオートだとダメ。
$sql = "SELECT * FROM member LEFT JOIN post ON member.user_id = post.user_id WHERE post.post_id = $post_code ORDER BY created_at DESC";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

$content = $rec['post_content'];
$name = $rec['name'];
$created = $rec['created_at'];

print $name;
print ' ';
print $created;
print '<br>';
print $content;

$dbh = null;

}
catch(Exception $e) 
{
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<hr>

<form method="post" action="delete_post_done.php">
    <br><br>
    <input type="hidden" name="postId" value='<?= $post_code ?>'>
    <input type="submit" value="削除する">

</form>
<br><br>
<a href="../main/post_list.php">投稿管理画面へ戻る</a>

<a href="../main/index.php">トップへ戻る</a>

<?php
require_once('../footer.php');
?>