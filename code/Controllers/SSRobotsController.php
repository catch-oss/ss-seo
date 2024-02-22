<?php

use SilverStripe\Control\Controller;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * @author v2
 */
class SSRobotsController extends Controller
{
    private static $url_handlers = array(
		'robots.txt' => 'index',
        '' => 'index'
    );

    public function index()
    {
        $conf = SiteConfig::current_site_config();
        $this->getResponse()->setBody($conf->SSRobotsRobotTXT);
        $this->getResponse()->addHeader('Content-Type', 'text/plain; charset="utf-8"');
        return $this->getResponse();
    }
}