<?php
session_start();
session_regenerate_id(true);
?>

<?php
require_once('../header.php');
?>

投稿管理画面
<a href="index.php">トップへ戻る</a>
<br>
<br>
<?php

if(isset($_SESSION['login'])==false)
{
print '投稿を管理するには、<b>ログイン</b>してください。<br><br>';
print '<a href="../login/login.php">ログイン画面へ戻る</a><br><br>';
}

try{
    $pdo = new PDO('mysql:dbname=manabi;host=localhost;charset=utf8','root','1234');

} catch (PDOException $error) {
    //エラーの場合はエラーメッセージを吐き出す
    exit("データベースに接続できませんでした。<br>" . $error->getMessage());
}

$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

require_once('../common.php');

$myId = $_SESSION['user_id'];

// memberとpostテーブルをJOIN ONを使ってuser_idで結合し、レコードを取り出す。
// ログイン中の会員のuser_idを使いWHERE句で絞り込みして、自分の投稿だけを抽出している。
// ORDER BYでcreated_at(投稿日時)が新しい順にDESCで降順で並べ替え
// 条件に変数を使う場合、SELECT文全体をダブルクオートで囲む必要がある。シングルクオートだとダメ。
$sql = "SELECT * FROM member LEFT JOIN post ON member.user_id = post.user_id WHERE member.user_id = ? ORDER BY
created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $myId, PDO::PARAM_INT);
$stmt->execute();

print '<form method="post" action="../post/post_branch.php">';
print '<input type="submit" name="new" value="新規投稿">'.' ';
print '<input type="submit" name="edit" value="修正">'.' ';
print '<input type="submit" name="delete" value="削除">';


    print '<hr>';
    print '<br>';

// 記事を出力する

define('max_view',6);

$count = $pdo->prepare("SELECT COUNT(*) AS count FROM post WHERE user_id = '$myId'");
$count->execute();
// PDO::FETCH_ASSOCは、カラム名を添え字にした配列を返す。この為に、43行目のSELECT文においてAS countと書いて、取得したレコード数にcountというカラム名を付けた。
$total_count = $count->fetch(PDO::FETCH_ASSOC);
// ページ数を決める。記事数 / 最大表示数 ceil()は計算した結果の数字を小数点以下で切り上げる関数
$pages = ceil($total_count['count'] / max_view); 


//現在いるページのページ番号を取得
// $_GET['page_id']に値が入っていれば中身を$nowに代入。入っていなければ$nowに1を代入する。
if(isset($_GET['page_id'])){ 
    $now = $_GET['page_id'];
}else{
    $now = 1;
}

$select = $pdo->prepare("SELECT * FROM member LEFT JOIN post ON member.user_id = post.user_id WHERE member.user_id = $myId ORDER BY created_at DESC LIMIT :start,:max ");



if ($now == 1){
//1ページ目の処理
// $now-1 なので0番目のレコードからmaxviewの値まで取得する
    $select->bindValue(":start",$now -1,PDO::PARAM_INT);
    $select->bindValue(":max",max_view,PDO::PARAM_INT);
} else {
//1ページ目以外の処理
// $nowが2とすると、$now-1で1*maxviewから、maxview分のレコードを取得する
    $select->bindValue(":start",($now -1 ) * max_view,PDO::PARAM_INT);
    $select->bindValue(":max",max_view,PDO::PARAM_INT);
}
//実行
$select->execute(); 

while($data = $select->fetch(PDO::FETCH_ASSOC))
{   
$content = $data['post_content'];
$name = $data['name'];
$created = $data['created_at'];
$postId = $data['post_id'];

print $name;
print ' ';
print $created;
print '<br>';
print $content;
print '<br><br>';
print '<hr>';
print '<br>';
}

//ページネーションを表示
for ( $n = 1; $n <= $pages; $n ++){
    if ( $n == $now ){
        echo "<span style='padding: 5px;'>$now</span>";
    }else{
        echo "<a href='post_list.php?page_id=$n' style='padding: 5px;'>$n</a>";
    }
}

// while($rec = $stmt->fetch(PDO::FETCH_ASSOC))
// {
// $content = $rec['post_content'];
// $name = $rec['name'];
// $created = $rec['created_at'];
// $postId = $rec['post_id'];

// print "<input type='radio' name='post_id' value='$postId'>";
// print $name;
// print ' ';
// print $created;
// print '<br>';
// print $content;
// print '<br><br>';
// print '
// <hr>';
// print '<br>';
// }

// $dbh = null;

// print '</form>';


?>

<?php
require_once('../footer.php');
?>