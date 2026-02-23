<?php

namespace CatchDesign\SS\SEO\Tests\Extensions;

use CatchDesign\SS\SEO\Extensions\SiteTreeRobotsExtension;
use Page;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\CheckboxSetField;

class SiteTreeRobotsExtensionTest extends FunctionalTest
{
    protected $usesDatabase = true;

    public function testXRobotsTagHeaderIsSetOnPageResponse(): void
    {
        // GIVEN a published page with default robots tag
        $page = Page::create();
        $page->Title = 'Robots Header Test';
        $page->URLSegment = 'robots-header-test';
        $page->write();
        $page->publishRecursive();

        // WHEN we visit the page
        $response = $this->get('robots-header-test');

        // THEN the X-Robots-Tag header should be present
        $this->assertNotNull(
            $response->getHeader('X-Robots-Tag'),
            'X-Robots-Tag header should be set on page responses'
        );
    }

    public function testDefaultRobotsTagIsAll(): void
    {
        // GIVEN a published page with no RobotsTag set
        $page = Page::create();
        $page->Title = 'Default Robots';
        $page->URLSegment = 'default-robots-tag';
        $page->write();
        $page->publishRecursive();

        // WHEN we visit the page
        $response = $this->get('default-robots-tag');

        // THEN the default X-Robots-Tag should be 'all'
        $this->assertEquals('all', $response->getHeader('X-Robots-Tag'));
    }

    public function testCustomRobotsTagValues(): void
    {
        // GIVEN a published page with 'noindex,nofollow' robots tag
        $page = Page::create();
        $page->Title = 'Custom Robots';
        $page->URLSegment = 'custom-robots-tag';
        $page->RobotsTag = 'noindex,nofollow';
        $page->write();
        $page->publishRecursive();

        // WHEN we visit the page
        $response = $this->get('custom-robots-tag');

        // THEN the X-Robots-Tag should contain the custom values
        $this->assertEquals('noindex,nofollow', $response->getHeader('X-Robots-Tag'));
    }

    public function testRobotsTagSanitizesSpecialCharacters(): void
    {
        // GIVEN a published page with special characters in the robots tag
        $page = Page::create();
        $page->Title = 'Sanitize Robots';
        $page->URLSegment = 'sanitize-robots-tag';
        $page->RobotsTag = 'no{index}!@#$,no follow';
        $page->write();
        $page->publishRecursive();

        // WHEN we visit the page
        $response = $this->get('sanitize-robots-tag');

        // THEN only lowercase alpha and commas remain (spaces, braces, symbols stripped)
        $this->assertEquals('noindex,nofollow', $response->getHeader('X-Robots-Tag'));
    }

    public function testRobotsTagSanitizesNumericCharacters(): void
    {
        // GIVEN a page with numeric characters in the robots tag
        $page = Page::create();
        $page->Title = 'Numeric Robots';
        $page->URLSegment = 'numeric-robots-tag';
        $page->RobotsTag = 'noindex123,nofollow456';
        $page->write();
        $page->publishRecursive();

        // WHEN we visit the page
        $response = $this->get('numeric-robots-tag');

        // THEN numbers should be stripped
        $this->assertEquals('noindex,nofollow', $response->getHeader('X-Robots-Tag'));
    }

    public function testSettingsFieldsContainsRobotsCheckboxSet(): void
    {
        // GIVEN a Page instance with the SiteTreeRobotsExtension applied
        $page = Page::create();

        // WHEN we get the settings fields
        $fields = $page->getSettingsFields();

        // THEN the RobotsTag field should be a CheckboxSetField
        $field = $fields->dataFieldByName('RobotsTag');
        $this->assertNotNull($field, 'RobotsTag field should be present in settings fields');
        $this->assertInstanceOf(CheckboxSetField::class, $field);
    }

    public function testRobotsCheckboxSetHasExpectedOptions(): void
    {
        // GIVEN a Page instance
        $page = Page::create();

        // WHEN we get the RobotsTag field from settings
        $fields = $page->getSettingsFields();
        $field = $fields->dataFieldByName('RobotsTag');

        // THEN the field should contain all expected robot directive options
        $source = $field->getSource();
        $expectedOptions = [
            'all', 'noindex', 'nofollow', 'none', 'noarchive',
            'nositelinkssearchbox', 'nosnippet', 'indexifembedded',
            'notranslate', 'noimageindex',
        ];
        foreach ($expectedOptions as $option) {
            $this->assertArrayHasKey($option, $source, "Option '{$option}' should be available");
        }
    }
}
