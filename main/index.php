<?php
session_start();
session_regenerate_id(true);
?>

<?php
require_once('../header.php');
?>

<?php if(isset($_SESSION['login'])): ?>
<a href="../main/post_list.php">投稿管理画面へ</a>
<br><br>
<?php else: ?>
投稿するには、<a href="../login/login.php">ログイン</a>してください。
<br><br>
アカウントが無い方は、<a href="../register/register.php">こちら</a>から登録してください。
<br><br>

<?php endif; ?>

<?php 

try
{

require_once('../common.php');

$dsn = 'mysql:dbname=manabi;host=localhost;charset=utf8';
$user = 'root';
$password = '1234';
$dbh = new PDO ($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

// memberとpostテーブルをuser_idで結合し、レコードを取り出す。ORDER BYでcreated_at(投稿日時)が新しい順にDESCで降順で並べ替え
$sql = 'SELECT * FROM member,post WHERE member.user_id=post.user_id ORDER BY created_at DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();

print '<hr>';
print '<br>';

while($rec = $stmt->fetch(PDO::FETCH_ASSOC))
{   
    $content = $rec['post_content'];
    $name = $rec['name'];
    $created = $rec['created_at'];
    
    print $name;
    print ' ';
    print $created;
    print '<br>';
    print $content;
    print '<br><br>';
    print '<hr>';
    print '<br>';
}

}
catch(Exception $e) 
{
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>


<?php
require_once('../footer.php');
?>