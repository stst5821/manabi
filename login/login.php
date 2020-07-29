<?php
require_once('../header.php');
?>

<h2>ログイン</h2>

<form method="post" action="login_check.php">
    メールアドレス
    <br>
    <input type="text" name="email" required="required">
    <br>
    パスワード
    <br>
    <input type="password" name="pass" required="required">
    <br><br>
    <input type="submit" value="ログイン">
</form>

<br><br>
アカウントが無い方は、<a href="../register/register.php">こちら</a>から登録できます。

<br><br>
<a href="../main/index.php">トップへ戻る</a>

<?php
require_once('../footer.php');
?>