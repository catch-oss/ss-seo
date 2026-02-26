<?php

namespace CatchDesign\SS\SEO\Tests\Extensions;

use CatchDesign\SS\SEO\Extensions\SSRobotsConfigExtension;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\TextareaField;
use SilverStripe\SiteConfig\SiteConfig;

class SSRobotsConfigExtensionTest extends SapphireTest
{
    protected $usesDatabase = true;

    protected static $required_extensions = [
        SiteConfig::class => [SSRobotsConfigExtension::class],
    ];

    public function testRobotsTextFieldAddedToSiteConfig(): void
    {
        // GIVEN a SiteConfig instance with the SSRobotsConfigExtension applied
        $config = SiteConfig::current_site_config();

        // WHEN we get the CMS fields
        $fields = $config->getCMSFields();

        // THEN the SSRobotsRobotTXT field should exist
        $field = $fields->dataFieldByName('SSRobotsRobotTXT');
        $this->assertNotNull($field, 'SSRobotsRobotTXT field should be present in CMS fields');
    }

    public function testRobotsTextFieldIsTextarea(): void
    {
        // GIVEN a SiteConfig instance
        $config = SiteConfig::current_site_config();

        // WHEN we get the CMS fields
        $fields = $config->getCMSFields();

        // THEN the SSRobotsRobotTXT field should be a TextareaField
        $field = $fields->dataFieldByName('SSRobotsRobotTXT');
        $this->assertInstanceOf(TextareaField::class, $field);
    }

    public function testRobotsTextFieldIsOnRobotsTab(): void
    {
        // GIVEN a SiteConfig instance
        $config = SiteConfig::current_site_config();

        // WHEN we get the CMS fields
        $fields = $config->getCMSFields();

        // THEN the Robots tab should exist
        $tab = $fields->findTab('Root.Robots');
        $this->assertNotNull($tab, 'Root.Robots tab should exist');
    }

    public function testRobotsTextFieldCanBeSavedAndRetrieved(): void
    {
        // GIVEN a SiteConfig with robots.txt content
        $config = SiteConfig::current_site_config();
        $config->SSRobotsRobotTXT = "User-agent: Googlebot\nAllow: /";
        $config->write();

        // WHEN we reload the SiteConfig
        $reloaded = SiteConfig::current_site_config();

        // THEN the saved content should persist
        $this->assertEquals("User-agent: Googlebot\nAllow: /", $reloaded->SSRobotsRobotTXT);
    }
}
