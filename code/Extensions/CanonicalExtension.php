<?php

namespace CatchDesign\SS\SEO\Extensions;

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\CMS\Controllers\RedirectorPageController;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Extension;

/**
 * Does a lookup on init at the request URL and does a 301 redirect to page link if they are not same.
 */
class CanonicalExtension extends Extension
{
    public function contentcontrollerInit(): void
    {
        $controller = Controller::curr();
        if ($controller === null) {
            return;
        }

        // POST data gets lost on a 301, so skip non-GET requests
        if (!$controller->getRequest()->isGET()) {
            return;
        }

        if ($this->isHomePage($controller)) {
            $requestUrl = $this->getRequestUrl();

            if ($this->hasIndex()) {
                $url = $this->stripIndex($requestUrl);
                $controller->redirect($url, 301);
            }

            return;
        }

        if ($this->isPage($controller)) {
            $requestUrl = $this->getRequestUrl();
            $expectedUrl = $this->getExpectedUrl($controller);

            if ($requestUrl != $expectedUrl) {
                $controller->redirect($expectedUrl, 301);
            }
        }
    }

    protected function isHomePage(Controller $controller): bool
    {
        $url = $controller->getRequest()->getURL();
        return $url === 'home' || $url === '';
    }

    protected function hasIndex(): bool
    {
        $requestUrl = $this->getRequestUrl();
        return str_contains($requestUrl, 'index.php');
    }

    protected function isPage(Controller $controller): bool
    {
        return $controller instanceof ContentController;
    }

    public function getExpectedUrl(Controller $controller): string
    {
        $params = $controller->getRequest()->params();
        $url = $controller->link();

        if ($controller instanceof RedirectorPageController) {
            return $url;
        }

        $uri_parts = explode('?', $url, 2);
        $url = $uri_parts[0];

        $q = $this->getQueryString($controller->getRequest());
        $url = $this->stripIndex($url);

        foreach ($params as $k => $v) {
            if (!empty($v) && $k != 'Controller' && $k != 'URLSegment') {
                $url = rtrim($url, '/') . '/' . $v;
            }
        }

        if ($q) {
            $url = rtrim($url, '/') . '?' . $q;
        } else {
            $url = rtrim($url, '/');
        }

        return Controller::normaliseTrailingSlash($url);
    }

    protected function getQueryString(HTTPRequest $request): ?string
    {
        $url = $request->getURL(true);
        return parse_url($url, PHP_URL_QUERY) ?: null;
    }

    protected function getRequestUrl(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '';
    }

    protected function stripIndex(string $url): string
    {
        return str_replace('/index.php', '', $url);
    }
}
