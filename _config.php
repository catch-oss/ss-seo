<?php
// Ensure compatibility with PHP 7.2 ("object" is a reserved word),
// with SilverStripe 3.6 (using Object) and SilverStripe 3.7 (using SS_Object)
if (!class_exists('SS_Object')) class_alias('Object', 'SS_Object');

// if (Config::inst()->get('SiteConfig', 'enable_seo_cache_lifetime') == true) {
//     SS_Cache::set_cache_lifetime('cacheblock', 28 * 24 * 60 * 60, 100);
// }


