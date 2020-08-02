<?php
session_start();
session_regenerate_id(true);
?>

<?php
require_once('../header.php');
?>

記事の修正・削除をする記事を選択してください。
<br><br>
<a href="../main/post_list.php">投稿管理画面へ</a>


<?php
require_once('../footer.php');
?>