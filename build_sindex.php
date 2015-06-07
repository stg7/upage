#!/usr/bin/env php
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

echo "<pre>";
$index = array();
foreach (rscandir($config["contentdir"], $config["contentext"]) as $c) {
    $key = str_replace(DIRECTORY_SEPARATOR, "/", str_replace($config["contentdir"], "", $c));
    if (is_file($c)) {
        $content = preg_replace("/([^a-zäöüß0-9]+)/", " ", strtolower(file_get_contents($c)));
        $terms = explode(" ", $content);

        foreach($terms as $term) {
            if (array_key_exists($term, $index)) {
                //$index[$term] =
                if (! in_array($key, $index[$term])) {
                    array_push($index[$term], $key);
                }
            } else {

                $index[$term] = array($key);
            }
        }
    }
}
$value = "<?php\n".'$index='.var_export($index, true).";";
echo $value;

file_put_contents("sindex.php", $value);

echo "</pre>";