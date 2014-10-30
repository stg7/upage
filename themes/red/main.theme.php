<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <title><?=$_['title']?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link media="screen,projection,handheld" href="<?=$_['themedir']?>style.css" type="text/css" rel="stylesheet">

</head>

<body>
    <div id="body-container">
        <div id="head">
            <h1><?=$_['title']?></h1>
            <p class="subtitle"><?=$_['subtitle']?></p>
        </div> <!-- end of #head -->

    <div id="outer-container">
        <div id="main">

        <?=$_['content']; ?>

        <br>
        <?=$_['debug']; ?>


        </div>



        <div id="menu">
            <?=$_['menu'] ?>


        </div>

        </div>


        <div id="footer">


            <p>
            by <?=$_['author']?>
            </p>
        </div> <!-- end of #footer -->

    </div>


</body>
</html>
