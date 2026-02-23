<?php

namespace CatchDesign\SS\SEO\Tests\Extensions;

use CatchDesign\SS\SEO\Extensions\CanonicalExtension;
use Page;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Session;
use SilverStripe\Dev\SapphireTest;

class CanonicalExtensionTest extends SapphireTest
{
    protected $usesDatabase = true;

    protected function setUp(): void
    {
        parent::setUp();

        // Push a controller to satisfy Controller::curr() calls
        $request = new HTTPRequest('GET', '/');
        $request->setSession(new Session([]));
        $controller = Controller::create();
        $controller->setRequest($request);
        $controller->pushCurrent();
    }

    protected function tearDown(): void
    {
        $controller = Controller::curr();
        if ($controller) {
            $controller->popCurrent();
        }
        parent::tearDown();
    }

    public function testGetExpectedUrlReturnsPageUrl(): void
    {
        // GIVEN a published page with a known URL segment
        $page = Page::create();
        $page->Title = 'Canonical Test';
        $page->URLSegment = 'canonical-test';
        $page->write();
        $page->publishRecursive();

        // WHEN we compute the expected URL via a ContentController
        $contentController = ContentController::create($page);
        $request = new HTTPRequest('GET', 'canonical-test');
        $request->setSession(new Session([]));
        $contentController->setRequest($request);

        $ext = $page->getExtensionInstance(CanonicalExtension::class);
        $ext->setOwner($page);
        $expectedUrl = $ext->getExpectedUrl($contentController);

        // THEN the URL should contain the page's URL segment
        $this->assertStringContainsString('canonical-test', $expectedUrl);
    }

    public function testGetExpectedUrlStripsIndexPhp(): void
    {
        // GIVEN a published page
        $page = Page::create();
        $page->Title = 'Strip Index Test';
        $page->URLSegment = 'strip-index-test';
        $page->write();
        $page->publishRecursive();

        // WHEN we compute the expected URL
        $contentController = ContentController::create($page);
        $request = new HTTPRequest('GET', 'strip-index-test');
        $request->setSession(new Session([]));
        $contentController->setRequest($request);

        $ext = $page->getExtensionInstance(CanonicalExtension::class);
        $ext->setOwner($page);
        $expectedUrl = $ext->getExpectedUrl($contentController);

        // THEN the URL should not contain index.php
        $this->assertStringNotContainsString('index.php', $expectedUrl);
    }

    public function testContentcontrollerInitSkipsNonGetRequests(): void
    {
        // GIVEN a published page and a POST request
        $page = Page::create();
        $page->Title = 'POST Test';
        $page->URLSegment = 'post-test';
        $page->write();
        $page->publishRecursive();

        $contentController = ContentController::create($page);
        $request = new HTTPRequest('POST', 'post-test');
        $request->setSession(new Session([]));
        $contentController->setRequest($request);
        $contentController->pushCurrent();

        // WHEN the contentcontrollerInit hook fires
        $ext = $page->getExtensionInstance(CanonicalExtension::class);
        $ext->setOwner($page);
        $ext->contentcontrollerInit();

        // THEN no redirect should be set (response status is not 301)
        $response = $contentController->getResponse();
        $this->assertNotEquals(301, $response->getStatusCode());

        $contentController->popCurrent();
    }

    public function testExtensionIsAppliedToSiteTree(): void
    {
        // GIVEN a Page instance (which extends SiteTree)
        $page = Page::create();

        // WHEN we check for the CanonicalExtension
        $ext = $page->getExtensionInstance(CanonicalExtension::class);

        // THEN it should be applied
        $this->assertNotNull($ext, 'CanonicalExtension should be applied to SiteTree');
    }
}
