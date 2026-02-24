<?php

namespace CatchDesign\SS\SEO\Controllers;

use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\SiteConfig\SiteConfig;

class SSRobotsController extends Controller
{
    private static $url_handlers = [
        'robots.txt' => 'index',
        '' => 'index',
    ];

    public function index(): HTTPResponse
    {
        $conf = SiteConfig::current_site_config();
        $this->getResponse()->setBody($conf->SSRobotsRobotTXT);
        $this->getResponse()->addHeader('Content-Type', 'text/plain; charset="utf-8"');
        return $this->getResponse();
    }
}
