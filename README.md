upage
=====

Upage is a minimal filebased php webpage framework, using wiki files for content storing.


setup
-----
Copy scripts to local installed webserver with php5, no more things (e.g. database,...) are needed.

confiuration
------------
For configuration modify config.php:
```php
$config = array (
    "contentdir" => "content/",
    "defaultpage" => "main.wiki",
    "themesdir" => "themes/",
    "theme" => "test2/",
    "contentext" => array ("wiki"),
    "downloadext" => array ("JPG","jpg","png","txt","zip", "pdf"),
    "debug" => true,
);


// blog infos
$_ = array (
    'title' => "title...",
    'subtitle' => " subtitle",
    'themedir' => $config["themesdir"].$config["theme"],
    'author' => "stg7 &copy; 2014",
);
```
