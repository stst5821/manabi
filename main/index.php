<?php
session_start();
session_regenerate_id(true);

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
    // prepareでSQLを準備し、executeで実行する
    // COUNT(*)にすると、格納されている値がNULLかどうか関係なくカウントする。
    // AS count で、取得したレコード数にcountというカラム名をつけている。
    $count = $pdo->prepare('SELECT COUNT(*) AS count FROM post');
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

    //表示する記事を取得するSQLを準備
    // LIMIT 第一引数, 第二引数 は、第一引数の行番号から、第二引数の値分、レコードを取得する。この場合、:startから:max分、レコードを取得するということ。
    $select = $pdo->prepare("SELECT * FROM member LEFT JOIN post ON member.user_id = post.user_id ORDER BY created_at DESC LIMIT :start,:max ");

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
            echo "<a href='index.php?page_id=$n' style='padding: 5px;'>$n</a>";
        }
    }
?>

<br>
<hr>

<?php
require_once('../footer.php');
?>