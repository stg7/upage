<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <title><?=$_['title']?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?=$_['themedir']?>style.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="<?=$_['themedir']?>js/jquery-2.0.3.min.js" ></script>

</head>

<body>
    <div id="container">

        <div id="head" >
            <img src="<?=$_['themedir']?>imgs/pp.jpg" style="width: 100%;" />

            <h1><?=$_['title']?></h1>
            <p><?=$_['subtitle']?></p>
         </div>

        <div id="menu">
            <?=$_['menu'] ?>   
        </div>


        <div id="main">
        
            <?=$_['content']; ?>

            <br>
            <?=$_['debug']; ?>
            
        </div>
            
        <div id="footer">
            by <?=$_['author']?>
        </div>
    </div>
</body>
</html>
