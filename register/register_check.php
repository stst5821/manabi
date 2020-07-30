<?php
require_once('../header.php');
?>

<h2>会員登録</h2>

<?php 

require_once('../common.php');

$post = sanitize($_POST);

$name = $post['name'];
$email = $post['email'];
$pass = $post['pass'];
$password2 = $post['password2'];

$preg_email = "/\A([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+\z/";
$preg_pass = "/\A[a-zA-Z0-9]+\z/";

$okflg = true;

try{
    $pdo = new PDO('mysql:dbname=manabi;host=localhost;charset=utf8','root','1234');

} catch (PDOException $error) {
    //エラーの場合はエラーメッセージを吐き出す
    exit("データベースに接続できませんでした。<br>" . $error->getMessage());
}

$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

// SELECT文で入力されたメルアドと一致するレコードの数を数える。結果をcountカラムと名付ける。
// 一致すれば1、しなければ0が返される。
$count = $pdo->prepare("SELECT COUNT(*) as count FROM member WHERE email='$email'");
$count->execute();
// カウントした数をfetchで取り出し、$total_countに代入。
$total_count = $count->fetch(PDO::FETCH_ASSOC);

$pdo = null;

// $total_count['count']が1であれば、入力したメルアドはDB登録済ということなので、エラーを出す。
if($total_count['count']==1)
{
    print 'すでに登録されているメールアドレスです。<br>別のアドレスで登録してください。';
    $okflg = false;
}

if(preg_match($preg_email,$email) == 0) {
    print 'メールアドレスを正しく入力してください。';
    $okflg = false;
}

if(preg_match($preg_pass,$pass) == 0)
{
    print 'パスワードは半角英数字のみです。';
    $okflg = false;
} 

if($pass != $password2) 
{
    print 'パスワードが一致しません<br>';
    $okflg = false;
}

if($okflg == true)
{

    print '■ニックネーム<br>';
    print $name.'<br><br>';
    print '■メールアドレス<br>';
    print $email.'<br><br>';
    print '■パスワード<br>';
    print '安全のため表示されません。<br><br>';

    $pass = md5($pass);
    print '<form method="post" action="register_done.php">';
    print '<input type="hidden" name="name" value="'.$name.'">';
    print '<input type="hidden" name="email" value="'.$email.'">';
    print '<input type="hidden" name="pass" value="'.$pass.'">';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="登録する"><br>';
}
else // 1つでもエラーがあれば、$okflgはfalseになっているので、elseの中身が実行される。
{
    print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '</form>';
}

?>

<br><br>
<a href="post_list.php">投稿管理画面へ戻る</a>

<?php
require_once('../footer.php');
?>