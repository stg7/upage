<?php
/*
    upage

    author: Steve Göring
    contact: stg7@gmx.de

*/
/*
    This file is part of upage.

    upage is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    upage is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with upage.  If not, see <http://www.gnu.org/licenses/>.
*/

include_once("include.php");
include_once("config.php");


function loadMenu($selection, $config) {
    $files = "";
    $dirs = "";

    $content = array();

    foreach (rscandir($config["contentdir"], $config["contentext"]) as $c) {
        $key = str_replace(DIRECTORY_SEPARATOR, "/", str_replace($config["contentdir"], "", $c));
        if(basename($key) != $config["defaultpage"])
            $content[$key] = basename($key);
    }
    asort($content);

    $menu = array();

    // main menu entries
    foreach(rscandir($config["contentdir"], $config["contentext"], false) as $c) {
        $k = str_replace(DIRECTORY_SEPARATOR, "/", str_replace($config["contentdir"], "", $c));
        if(basename($k) != $config["defaultpage"])
            $menu[$k] = $k;
    }

    if ($selection != "" ) {

        foreach($content as $k => $c) {
            // get menu entries from child to root
            if(str_is_prefix($selection, $k)) {
                $menu[$k] = $k;
            }

            // get one leve higer
            if(str_is_prefix($selection, dirname($k))) {
                $menu[$k] = $k;
            }
        }
    }

    asort($menu);


    foreach($menu as $k => $path) {

        $name = basename($path);
        $name = str_replace(".".get_extension($name), "", $name); // TODO:

        $level = substr_count($path, '/');
        $entry = "";
        for($i = 1; $i <= $level; $i++) {
            $entry .= " ";
        }
        $entry .= "* ";
        $files .= $entry.make_link($name, get_script_url()."?".$path)."\n";
    }

    return $dirs."\n\n".$files;
}

function loadPreview($file, $config) {
    $content = file_get_contents($file);

    $firstlinePos = strpos($content, "\n") + 1;
    $headline = substr($content, 0, $firstlinePos - 1);

    $cutpos = $firstlinePos + min(90, strlen($content) - $firstlinePos);

    while ($cutpos < strlen($content) and $content[$cutpos] != " ") {
        $cutpos ++;
    }

    $prev = substr($content, $firstlinePos, $cutpos - $firstlinePos);
    $path = str_replace($config["contentdir"], "", $file);

    return $headline."\n".$prev."\n ... ".make_link("more", get_script_url()."?".$path);
}

function search($basedir) {
    include_once("sindex.php");
    return "form ".var_export($index, true);
}

function loadContent($selection, $config) {
    if(is_file($config["contentdir"].$selection)){
        return file_get_contents($config["contentdir"].$selection);
    } else {
        # print sumarisation of all files or submenu links?
        if (is_file($config["contentdir"].$selection."/".$config["defaultpage"]))
            return file_get_contents($config["contentdir"].$selection."/".$config["defaultpage"]);
        else {
            // print preview of all subpages
            $path = $config["contentdir"].$selection."/";
            $res = "";
            foreach (rscandir($path, $config["contentext"], false) as $c) {
                $res.= loadPreview($c, $config)." \n";
            }

            return $res."\n";
        }
    }
    // default case
    return file_get_contents($config["contentdir"].$config["defaultpage"]);
}

function print_bibliography($path, $themesdir) {
    $string = "hallo".$path;

    foreach (rscandir($path, array("bib"), false) as $pub) {
        $parser = new bibtexparser($pub);
        $parser->parse();

        ob_start();
        $parser->print_it(dirname(__file__)."/".$themesdir."bibtex.theme.php");
        $string=ob_get_contents();
        ob_end_clean();
    }
    return $string;
}

# TODO: build up cache function

// todo tidy up selection
$selection = rawurldecode($_SERVER['QUERY_STRING']);

$renderer = new Renderer();
// load selected menu
$_['menu'] = $renderer->get_html(loadMenu($selection, $config));

if(is_dir($config["contentdir"].$selection)) {
    $subpath = $selection;
}
else {
    $subpath = dirname($selection);
}

$path = dirname(get_script_url())."/".$config["contentdir"].$subpath."/";

$rules = array(
    '$$' => $path,
    '$P$' => get_pics(dirname(get_script_url())."/", $config["contentdir"].$subpath."/", $config["downloadext"]),
    '$F$' => get_files(dirname(get_script_url())."/", $config["contentdir"].$subpath."/", $config["downloadext"]),
    '$R$' => get_files_rek(dirname(get_script_url())."/", $config["contentdir"].$subpath."/", $config["downloadext"], $config["contentdir"].$selection."/"),
    '$Pub$' => print_bibliography($config["contentdir"].$subpath."/", $config['themesdir'].$config['theme']),
    '$S$' => search($config["contentdir"]),
);


$content = loadContent($selection, $config);

foreach($rules as $tok => $rep) {
    $content = str_replace($tok, $rep, $content);
}

$_['content'] = $renderer->get_html($content);

// print out theme..
function theme($_, $dir){
    if(is_file($dir."main.theme.php")) {
        include_once ($dir."main.theme.php");
    }else {
        echo "theme not fount";
    }
}

// just print debug infos if debug = true
$_['debug'] = "";
if ($config['debug']) {
    #$_['debug'] = "<pre>".var_export($_, true)."</pre>";
}


theme($_, $config['themesdir'].$config['theme']);



