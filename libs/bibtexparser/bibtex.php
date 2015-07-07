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

/*
    Bibtex parser class,

    parsing is done using regex
*/
class bibtexparser {
    private $pub_file_name = "";
    private $entries = "";
    private $replacements = array(
            "{\\\"{o}}" => "ö",
            "{\\\"{u}}" => "ü",
            "{\\\"{a}}" => "ä",
            "{\\\"{O}}" => "O",
            "{\\\"{Ä}}" => "Ä",
            "{\\\"{Ä}}" => "Ä",
            "{\\\"{ss}}" => "ß",
            "{\\\"o}" => "ö",
            "{\\\"u}" => "ü",
            "{\\\"a}" => "ä",
            "{\\\"O}" => "O",
            "{\\\"Ä}" => "Ä",
            "{\\ss}" => "ß",
            "{" => "",
            "}" => "",
            "\"" => "",
        );
    private $months = array(
            "jan" => "January",
            "feb" => "Februrary",
            "mar" => "March",
            "apr" => "April",
            "may" => "May",
            "jun" => "June",
            "jul" => "July",
            "aug" => "August",
            "sep" => "September",
            "oct" => "October",
            "nov" => "November",
            "dec" => "December"
        );

    function __construct($filename) {
        $this->pub_file_name = $filename;
    }

    private function tidy_up($string) {
        foreach ($this->replacements as $bibtex => $replacement ) {
            $string = str_replace($bibtex, $replacement, $string);
        }
        return trim(preg_replace('/,$/', '', $string));
    }

    function parse() {
        $content = file_get_contents($this->pub_file_name);
        $entries = array();

        foreach (explode("@", $content) as $c) {
            $c = "@".$c;

            preg_match ("/@(?<type>\w+){(?<key>\w+).*,/", $c, $glob_matches);
            if (array_key_exists("type", $glob_matches) && array_key_exists("key", $glob_matches)) {

                $rest_c = preg_replace("/@(?<type>\w+){(?<key>\w+).*,/", "", $c);
                $rest_c = preg_replace("/}$/", "", $rest_c);

                preg_match_all("/(?<k>.*)=(?<v>.*).*/", $rest_c, $matches);

                $entry = array(
                        "type" => $glob_matches["type"],
                        "key" => $glob_matches["key"],
                        "bibentry" => $c,
                    );

                for($i = 0; $i < count($matches["k"]); $i++) {
                    $k = strtolower($this->tidy_up($matches["k"][$i]));
                    $v = $this->tidy_up($matches["v"][$i]);
                    $entry[$k] = $v;
                }
                $entries[$glob_matches["key"]] = $entry;
            }
        }
        $this->entries = $entries;
    }

    function get_json() {
        return json_encode($this->entries);
    }

    private function print_entry($templatename, $entry) {
        $_ = $entry;
        $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

        $_["entry"] = $url."?bibkey=".$_["key"];

        if (isset($_["month"])) {
            $_['month'] = $this->months[$_['month']];
        }

        include($templatename);
    }

    private function print_entries($templatename, $entries) {
        foreach ($entries as $entry) {
            $this->print_entry($templatename, $entry);
        }
    }

    private function yearsort($a, $b) {
        return (int)($a["year"]) < (int)($b["year"]);
    }

    function print_entries_by_year($templatename) {
        $entries = $this->entries;
        usort($entries, array($this,'yearsort'));

        $this->print_entries($templatename, $entries);
    }

    function print_it($templatename) {

        if (isset($_GET["bibkey"]) && array_key_exists($_GET["bibkey"], $this->entries)) {
            echo "<pre>";
            echo $this->entries[$_GET["bibkey"]]["bibentry"];
            echo "</pre>";
        }
        else {
            $this->print_entries_by_year($templatename);
        }
    }

}

