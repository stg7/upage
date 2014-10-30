<!DOCTYPE html>
<html lang="de">
<head>
        <meta charset="utf-8">
        <title><?=$_['title']?></title>
        <link href="<?=$_['themedir']?>style.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="<?=$_['themedir']?>js/jquery-2.0.3.min.js" ></script>

        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
</head>
<body>
    <header>
        <img src="<?=$_['themedir']?>imgs/pp.jpg" style="width: 100%;" />

        <h1><?=$_['title']?></h1>
        <p><?=$_['subtitle']?></p>
    </header>

    <nav>
        <?=$_['menu'] ?>
    </nav>

    <article>
        <section>
            <?=$_['content']; ?>
        </section>
        <section>
            <?=$_['debug']; ?>
        </section>
    </article>

    <footer>
        by <?=$_['author']?>
    </footer>
</body>
</html>

