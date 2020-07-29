<?php
session_start();
session_regenerate_id(true);
?>

<?php
require_once('../header.php');
?>

投稿管理画面
<br><br>
<a href="index.php">トップへ戻る</a>

<?php

if(isset($_SESSION['login'])==false)
{
print '投稿を管理するには、<b>ログイン</b>してください。<br><br>';
print '<a href="../login/login.php">ログイン画面へ戻る</a><br><br>';
}
else
{
    print '<a href="../post/new_post.php">新規投稿</a><br><br>';

try
{

require_once('../common.php');



$myId = $_SESSION['user_id'];

$dsn = 'mysql:dbname=manabi;host=localhost;charset=utf8';
$user = 'root';
$password = '1234';
$dbh = new PDO ($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

// memberとpostテーブルをJOIN ONを使ってuser_idで結合し、レコードを取り出す。
// ログイン中の会員のuser_idを使いWHERE句で絞り込みして、自分の投稿だけを抽出している。
// ORDER BYでcreated_at(投稿日時)が新しい順にDESCで降順で並べ替え
// 条件に変数を使う場合、SELECT文全体をダブルクオートで囲む必要がある。シングルクオートだとダメ。
$sql = "SELECT * FROM member LEFT JOIN post ON member.user_id = post.user_id WHERE member.user_id = $myId ORDER BY
created_at DESC";
$stmt = $dbh->prepare($sql);
$stmt->execute();

print '<form method="post" action="../post/post_branch.php">';
    print '<input type="submit" name="edit" value="修正">';
    print '<input type="submit" name="delete" value="削除">';


    print '
    <hr>';
    print '<br>';

    while($rec = $stmt->fetch(PDO::FETCH_ASSOC))
    {
    $content = $rec['post_content'];
    $name = $rec['name'];
    $created = $rec['created_at'];
    $postId = $rec['post_id'];

    print "<input type='radio' name='post_id' value='$postId'>";
    print $name;
    print ' ';
    print $created;
    print '<br>';
    print $content;
    print '<br><br>';
    print '
    <hr>';
    print '<br>';
    }

    $dbh = null;

    }
    catch(Exception $e)
    {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
    }

    print '</form>';

}
?>

<?php
require_once('../footer.php');
?>