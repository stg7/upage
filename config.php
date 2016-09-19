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

// config settings
$config = array (
    "contentdir" => "content/",
    "defaultpage" => "main.md",
    "themesdir" => "themes/",
    "theme" => "test2/",
    "contentext" => array ("md"),
    "downloadext" => array ("JPG","jpg","png","txt","zip", "pdf"),
    "debug" => true,
);

// blog infos
$_ = array (
    'title' => "title...",
    'subtitle' => " subtitle",
    'themedir' => $config["themesdir"].$config["theme"],
    'author' => "stg7 &copy; ".date("Y"),
);

include_once("libs/renderer.php");
