<!DOCTYPE html>
<html lang="de">
<head>
        <meta charset="utf-8">
        <title>bibtex parser example</title>
        <link href="bib.css" type="text/css" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script type="text/javascript">

        window.onload = function() {

            var elements = document.getElementsByClassName("bib-entry");
            for(var i = 0; i < elements.length; i++) {
                var element = elements[i];
                console.log(element.id);
                element.onclick = function() {
                    var key = this.id;
                    console.log(key);
                    var pre = document.getElementById("plain-" + key);
                    if (pre.style.display == "block") {
                        pre.style.display = "none";
                    } else {
                        pre.style.display = "block";
                    }
                    return false;
                }
            }
        }

        </script>
</head>
<body>
    <header>
        <h1>Publications</h1>
    </header>

    <article>
    <?php
    include("bibtex.php");

    $parser = new bibtexparser("pub.bib");
    $parser->parse();
    $parser->print_it("bibtex.tpl");

    php?>

    </article>


</body>
</html>

