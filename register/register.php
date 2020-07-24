<?php
require_once('../header.php');
?>

<h2>会員登録</h2>
<form method="post" action="register_check.php">
    ニックネーム
    <br>
    <input type="text" name="name" required="required">
    <br><br>
    メールアドレス
    <br>
    <input class="email" type="text" name="email" required="required">
    <br><br>
    パスワード
    <br>
    <input type="password" name="pass" required="required">
    <br><br>
    パスワードをもう一度入力してください。
    <br>
    <input type="password" name="password2" required="required">
    <br>
    <br>
    <input type="submit" value="登録する">

</form>
<br><br>
<a href="../main/index.php">トップへ戻る</a>
<br><br>
<a href="post_list.php">投稿管理画面へ戻る</a>

<?php
require_once('../footer.php');
?>