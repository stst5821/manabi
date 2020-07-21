<?php
require_once('../header.php');
?>

<?php

// sanitize関数の入っているcommon.phpを呼び出し
require_once('../common.php');

// $_POSTに入っている本文をsanitize関数で処理。スクリプトが書かれていたらただの文字に変換して$contentに代入
$content = sanitize($_POST);

print_r($content);

?>

<?php
require_once('../footer.php');
?>