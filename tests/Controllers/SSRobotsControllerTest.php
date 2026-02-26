<?php

namespace CatchDesign\SS\SEO\Tests\Controllers;

use CatchDesign\SS\SEO\Extensions\SSRobotsConfigExtension;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\SiteConfig\SiteConfig;

class SSRobotsControllerTest extends FunctionalTest
{
    protected $usesDatabase = true;

    protected static $required_extensions = [
        SiteConfig::class => [SSRobotsConfigExtension::class],
    ];

    public function testRobotsTxtReturns200(): void
    {
        // GIVEN the robots.txt route is configured
        // WHEN we request /robots.txt
        $response = $this->get('robots.txt');

        // THEN the response should be 200
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRobotsTxtReturnsTextPlainContentType(): void
    {
        // GIVEN the robots.txt route is configured
        // WHEN we request /robots.txt
        $response = $this->get('robots.txt');

        // THEN the Content-Type should be text/plain
        $this->assertStringContainsString('text/plain', $response->getHeader('Content-Type'));
    }

    public function testRobotsTxtReturnsConfiguredContent(): void
    {
        // GIVEN a SiteConfig with custom robots.txt content
        $config = SiteConfig::current_site_config();
        $config->SSRobotsRobotTXT = "User-agent: *\nDisallow: /admin/";
        $config->write();

        // WHEN we request /robots.txt
        $response = $this->get('robots.txt');

        // THEN the response body should match the configured content
        $this->assertEquals("User-agent: *\nDisallow: /admin/", $response->getBody());
    }

    public function testRobotsTxtReturnsEmptyBodyWhenNotConfigured(): void
    {
        // GIVEN a SiteConfig with no robots.txt content set
        $config = SiteConfig::current_site_config();
        $config->SSRobotsRobotTXT = null;
        $config->write();

        // WHEN we request /robots.txt
        $response = $this->get('robots.txt');

        // THEN the response body should be empty
        $this->assertEmpty($response->getBody());
    }
}
