<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/5b114103c4.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="../style.scss"> -->
    <link rel="stylesheet" href="../style.css">
    <title>まなびのあしあと</title>
</head>

<body>
    <header>
        <div class="header_wrap">
            <h1>まなびのあしあと</h1>
            <div class="login_status">
                <?php

                    if(isset($_SESSION['login'])==false)
                    {
                    print '<p>ログインされていません</p><br><br>';
                    }
                    else
                    {
                    print '<p>'.$_SESSION['name'].'さん ログイン中</p>';
                    print '<a href="logout.php">ログアウト</a>';
                    }
                ?>
            </div>
        </div>
    </header>

    <hr>