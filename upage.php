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
include_once("libs/wiki.php");


function loadMenu($selection, $config) {
    $files = "";
    $dirs = "";

    $content = array();

    foreach (rscandir($config["contentdir"],$config["contentext"]) as $c) {
        $key = str_replace(DIRECTORY_SEPARATOR,"/",str_replace($config["contentdir"], "", $c));
        if(basename($key) != $config["defaultpage"])
            $content[$key] = basename($key);
    }
    asort($content);

    $menu = array();

    // main menu entries
    foreach(rscandir($config["contentdir"],$config["contentext"],false) as $c) {
        $k = str_replace(DIRECTORY_SEPARATOR,"/",str_replace($config["contentdir"], "", $c));
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
        $name = str_replace(".".get_extension($name),"",$name); // TODO:

        $level = substr_count($path, '/');
        $entry = "";
        for($i = 0; $i < $level; $i++) {
            $entry .= " ";
        }
        $entry .= "* ";
        $files .= $entry."[[".get_script_url()."?".$path." | ".$name." ]] "."\n";
    }

    return $dirs."\n\n".$files;
}

function loadContent($selection, $config) {
    if(is_file($config["contentdir"].$selection)){
        return file_get_contents($config["contentdir"].$selection);
    } else {
        # print sumarisation of all files or submenu links?
        if (is_file($config["contentdir"].$selection."/".$config["defaultpage"]))
            return file_get_contents($config["contentdir"].$selection."/".$config["defaultpage"]);
        else
            return $config["contentdir"].$selection."/".$config["defaultpage"];
    }
    // default case
    return file_get_contents($config["contentdir"].$config["defaultpage"]);
}

$wiki = new Wiki();

// todo tidy up selection
$selection = rawurldecode($_SERVER['QUERY_STRING']);

// load selected menu
$_['menu'] = $wiki->get_html(loadMenu($selection, $config));

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

);


$content = loadContent($selection, $config);

foreach($rules as $tok => $rep) {
    $content = str_replace($tok, $rep, $content);
}

$_['content'] = $wiki->get_html($content);

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
    #$_['debug'] = "<pre>".var_export($_,true)."</pre>";
}


theme($_,$config['themesdir'].$config['theme']);




