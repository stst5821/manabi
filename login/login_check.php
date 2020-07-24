<?php
require_once('../header.php');
?>

<?php 

try
{


require_once('../common.php');

$post = sanitize($_POST);

$email = $post['email'];
$pass = $post['pass'];
$pass = MD5($pass);

$dsn = 'mysql:dbname=manabi;host=localhost;charset=utf8';
$user = 'root';
$password = '1234';
$dbh = new PDO ($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

// 入力されたメルアドとパスワードを使ってDB内容を検索し、見つかった場合、nameカラムのデータを取り出す。
$sql = 'SELECT name,user_id FROM member WHERE email=? AND password=?';
$stmt = $dbh->prepare($sql);
$data[] = $email;
$data[] = $pass;
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

if($rec == false)
{
    print 'メールアドレスかパスワードが違います。<br>';
    print '<a href="login.php">戻る</a>';
}
else
{
    session_start();
    $_SESSION['login'] = 1;
    $_SESSION['name'] = $rec['name'];
    $_SESSION['user_id'] = $rec['user_id'];
    header('Location:../main/index.php');
    exit();
}

}
catch(Exception $e) 
{
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<!-- <br><br>
<a href="../main/index.php">投稿管理画面へ戻る</a> -->

<?php
require_once('../footer.php');
?>