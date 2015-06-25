<!DOCTYPE html>
<html lang="de">
<head>
        <meta charset="utf-8">
        <title><?=$_['title']?></title>
        <link href="<?=$_['themedir']?>style.css" type="text/css" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
</head>
<body>
    <header>
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
        <?=$_['author']?>
    </footer>
</body>
</html>

