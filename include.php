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

mb_internal_encoding('UTF-8'); // UTF8

function error_handler($errno, $errmsg, $filename, $linenum) {
    $errortype = array (
        E_WARNING => 'E_WARNING',
        E_NOTICE => 'E_NOTICE',
        E_USER_ERROR => 'E_USER_ERROR',
        E_USER_WARNING => 'E_USER_WARNING',
        E_USER_NOTICE => 'E_USER_NOTICE',
        E_STRICT => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR'
    );

    echo $errortype[$errno] . ': ' . $errmsg . ' in \'' . $filename . '\' at line ' . $linenum."<br>";
}

set_error_handler('error_handler');
error_reporting(E_ALL);


// returns file extension of $file
function get_extension($file) {
    return pathinfo($file, PATHINFO_EXTENSION);
}



function get_script_url(){
    return "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}



function rscandir($base='',$filter, $subfolder=true, &$data=array()) {

  $array = array_diff(scandir($base), array('.', '..')); # remove . and .. from the array */

  foreach($array as $value) { /* loop through the array at the level of the supplied $base */

    if (is_dir($base.$value)) { /* if this is a directory */
      $data[] = $base.$value; #.'/'; /* add it to the $data array */
      if ($subfolder) {
        $data = rscandir($base.$value.'/', $filter, true, $data); /* then make a recursive call with the
      current $value as the $base supplying the $data array to carry into the recursion */
      }
    }
    elseif(is_file($base.$value) ) { /* else if the current $value is a file */
      if(in_array(get_extension($base.$value), $filter) ) {
        $data[] = $base.$value; /* just add the current $value to the $data array */
      }
    }

  }

  return $data; // return the $data array

}

function str_is_prefix($haystack, $needle) {
    return !strncmp($haystack, $needle, strlen($needle));
}

function str_is_suffix($haystack, $needle) {
    return !strncmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle, strlen($needle));
}

function get_pics($linkpath, $path, $ext) {
    $ret = "";
    foreach(rscandir($path, $ext, false) as $c) {
      if(!is_dir($c)) {
        $ret.="[[ ".$linkpath.$c." | {{".$linkpath.$c."| ".basename($c)."  }} ]] "."\n";
      }

    }
    return $ret;
}
function get_files($linkpath, $path, $ext) {
    $ret = "";
    foreach(rscandir($path, $ext, false) as $c) {
      if(!is_dir($c)) {
        $ret.="* [[".$linkpath.$c."| ".basename($c)."  ]] "."\n";
      }
    }
    return $ret;
}
function get_files_rek($linkpath, $path, $ext, $selection) {
    $ret = '';
    foreach(rscandir($path, $ext, true) as $c) {
      $linkname = str_replace($selection,"",dirname($c))."/".basename($c);
      $level = substr_count($c, "/");

      for($i = 0; $i < $level; $i++) {
        $ret .= " ";
      }

      if(!is_dir($c)) {
        $ret .= "* [[".$linkpath.$c."| ".basename($linkname)."  ]] "."\n";
      } else {
        $ret .= "* " . basename($linkname) . "  " . "\n";
      }
    }
    return $ret;
}
