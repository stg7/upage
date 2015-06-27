<p class="bib">
<?php
if (isset($_['author'])) { ?>
<span class="bib-author"><?=$_['author']?>.</span>
<?php } ?>
<?php
if (isset($_['title'])) { ?>
<span class="bib-title"><?=$_['title']?>,</span>
<?php } ?>
<?php
if (isset($_['booktitle'])) { ?>
<span class="bib-booktitle">In <?=$_['booktitle']?>,</span>
<?php } ?>
<?php
if (isset($_['publisher'])) { ?>
<span class="bib-publisher"><?=$_['publisher']?>,</span>
<?php } ?>
<?php
if (isset($_['month'])) { ?>
<span class="bib-month"><?=$_['month']?> </span>
<?php } ?>
<?php
if (isset($_['year'])) { ?>
<span class="bib-year"><?=$_['year']?>,</span>
<?php } ?>
<?php
if (isset($_['series'])) { ?>
<span class="bib-series"><?=$_['series']?>,</span>
<?php } ?>
<?php
if (isset($_['url'])) { ?>
<a class="bib-url" target="_blank" href="<?=$_['url']?>">[url]</a>
<?php } ?>
<?php
if (isset($_['entry'])) { ?>
<a class="bib-entry" target="_blank" href="#" id=<?=$_['key']?>>[bib]</a>
<?php } ?>
<?php
if (isset($_['bibentry'])) { ?>
<pre class="bib-plain" style="display:none" id="plain-<?=$_['key']?>">
<?=$_['bibentry']?>
</pre>
<?php } ?>
</p>
