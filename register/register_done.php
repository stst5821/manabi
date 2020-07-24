<?php
require_once('../header.php');
?>

<?php

try 
{

print_r($_POST);

require_once('../common.php');
$post = sanitize($_POST);

$name = $post['name'];
$email = $post['email'];
$pass = $post['pass'];

$dsn = 'mysql:dbname=manabi;host=localhost;charset=utf8';
$user = 'root';
$password = '1234';
$dbh = new PDO ($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql = 'INSERT INTO member(name,email,password) VALUES(?,?,?)';
$stmt = $dbh->prepare($sql);
$data[] = $name;
$data[] = $email;
$data[] = $pass;
$stmt->execute($data);

$dbn = null;

print '会員登録できました！';

}
catch(Exception $e) 
{
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}


?>



<br><br>
<a href="../main/post_list.php">トップへ戻る</a>

<?php
require_once('../footer.php');
?>