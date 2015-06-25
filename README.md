upage
=====

Upage is a minimal filebased php webpage framework, using markdown files for content storing.


setup
-----
Copy scripts to local installed webserver with php5, no more things (e.g. database,...) are needed.

confiuration
------------
For configuration modify config.php:
```php
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
    'author' => "stg7 &copy; 2014",
);
```

search index (experimental)
---------------------------

start build_sindex.php and copy stdout to sindex.php, or build_sindex.php will create this file if it has the correct permissions.

it is just a small and simple basic search index based on term occurence.
