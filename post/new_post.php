<?php
require_once('../header.php');
?>

<h2>新規投稿</h2>
<form method="post" action="new_post_done.php">
    <textarea class="test" name="content" placeholder="本文を入力してください。" required="required"></textarea>
    <br><br>
    <input type="submit" value="投稿する">

</form>
<br><br>
<a href="post_list.php">投稿管理画面へ戻る</a>

<?php
require_once('../footer.php');
?>