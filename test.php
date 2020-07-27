<?php
  
$totalPage = 20;
$range = 3;

if (isset($_GET["page"]) &&
  $_GET["page"] > 0 &&
  $_GET["page"] <= $totalPage) 
{
  $page = (int)$_GET["page"];
} 
else 
{
  $page = 1;
}
  
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>サンプル</title>
</head>

<body>
    <p>現在 <?php echo $page; ?> ページ目です。</p>

    <p>
        <?php if ($page > 1) : ?>
        <a href="?page=<?php echo ($page - 1); ?>">前のページへ</a>
        <?php endif; ?>

        <?php for ($i = $range; $i > 0; $i--) : ?>
        <?php if ($page - $i < 1) continue; ?>
        <a href="?page=<?php echo ($page - $i); ?>"><?php echo ($page - $i); ?></a>
        <?php endfor; ?>

        <span><?php echo $page; ?></span>

        <?php for ($i = 1; $i <= $range; $i++) : ?>
        <?php if ($page + $i > $totalPage) break; ?>
        <a href="?page=<?php echo ($page + $i); ?>"><?php echo ($page + $i); ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPage) : ?>
        <a href="?page=<?php echo ($page + 1); ?>">次のページへ</a>
        <?php endif; ?>
    </p>

</body>

</html>