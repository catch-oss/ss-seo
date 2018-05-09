<?php

if (Config::inst()->get('SiteConfig', 'enable_seo_cache_lifetime') == true) {
    SS_Cache::set_cache_lifetime('cacheblock', 28 * 24 * 60 * 60, 100);
}


