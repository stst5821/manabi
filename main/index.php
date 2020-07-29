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

<hr>
<br>

<?php endif; ?>

<?php
    //一ページに表示する記事の数をmax_viewに定数として定義
    define('max_view',6);

    try{
        $pdo = new PDO('mysql:dbname=manabi;host=localhost;charset=utf8','root','1234');

    } catch (PDOException $error) {
        //エラーの場合はエラーメッセージを吐き出す
        exit("データベースに接続できませんでした。<br>" . $error->getMessage());
    }

    // データを抽出する
    $sql = "SELECT * FROM member LEFT JOIN post ON member.user_id = post.user_id ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    //必要なページ数を求める
    $count = $pdo->prepare('SELECT COUNT(*) AS count FROM post');
    $count->execute();
    $total_count = $count->fetch(PDO::FETCH_ASSOC);
    $pages = ceil($total_count['count'] / max_view);

    //現在いるページのページ番号を取得
    if(!isset($_GET['page_id'])){ 
        $now = 1;
    }else{
        $now = $_GET['page_id'];
    }

//表示する記事を取得するSQLを準備
    $select = $pdo->prepare("SELECT * FROM member LEFT JOIN post ON member.user_id = post.user_id ORDER BY created_at DESC LIMIT :start,:max ");

    if ($now == 1){
//1ページ目の処理
        $select->bindValue(":start",$now -1,PDO::PARAM_INT);
        $select->bindValue(":max",max_view,PDO::PARAM_INT);
    } else {
//1ページ目以外の処理
        $select->bindValue(":start",($now -1 ) * max_view,PDO::PARAM_INT);
        $select->bindValue(":max",max_view,PDO::PARAM_INT);
    }
//実行し結果を取り出しておく
    
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

?>

<?php
            //ページネーションを表示
            for ( $n = 1; $n <= $pages; $n ++){
                if ( $n == $now ){
                    echo "<span style='padding: 5px;'>$now</span>";
                }else{
                    echo "<a href='index.php?page_id=$n' style='padding: 5px;'>$n</a>";
                }
            }
        ?>

<br>
<hr>

<?php
require_once('../footer.php');
?>