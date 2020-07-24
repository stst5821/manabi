<?php
session_start();
session_regenerate_id(true);
?>

<?php
require_once('../header.php');
?>

<h2>投稿削除</h2>
<form method="post" action="delete_post_done.php">
    <textarea class="test" name="content" placeholder="まなびの記録を残しましょう！" required="required"></textarea>
    <br><br>
    <input type="submit" value="投稿する">

</form>
<br><br>
<a href="../main/post_list.php">投稿管理画面へ戻る</a>

<a href="../main/index.php">トップへ戻る</a>

<?php
require_once('../footer.php');
?>