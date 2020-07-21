<?php
require_once('../header.php');
?>

<?php
try {
    
// sanitize関数の入っているcommon.phpを呼び出し
require_once('../common.php');

// $_POSTに入っている本文をsanitize関数で処理。スクリプトが書かれていたらただの文字に変換して$contentに代入
$post = sanitize($_POST);
$content = $post["content"];

    $dsn = 'mysql:dbname=manabi;host=localhost;charset=utf8';
    $user = 'root';
    $password = '1234';
    $dbh = new PDO ($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql = 'INSERT INTO post(user_id,post_content) VALUES(?,?)';
    $stmt = $dbh->prepare($sql);
    $data[] = $user_id;
    $data[] = $content;
    $stmt->execute($data);

    $dbn = null;

}
catch(Exception $e) 
{
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}


?>
<p>投稿しました！</p>
<p>投稿内容</p>
<p>
    <?= $content ?>
</p>
<br>

<p><a href="post_list.php">投稿管理画面に戻る</a></p>
<p><a href="index.php">トップへ戻る</a></p>

<?php
require_once('../footer.php');
?>