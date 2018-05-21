<?php

/*
 * Does a lookup on init at the request URL and does a 301 redirect to page link if they are not same
 */

class CanonicalExtension extends DataExtension
{

    public function contentcontrollerInit()
    {
        $controller = Controller::curr();

        if ($this->isHomePage($controller)) {

            $requestUrl = $this->getRequestUrl();

            if ($this->hasIndex()) {
                $url = $this->stripIndex($requestUrl);
                return $controller->redirect($url, 301);
            }

            return true;
        }

        if ($this->isPage($controller)) {

            $requestUrl = $this->getRequestUrl();
            $expectedUrl = $this->getExpectedUrl($controller);
            if ($requestUrl != $expectedUrl) {
                return $controller->redirect($expectedUrl, 301);
            }
        }
    }

    protected function isHomePage($controller)
    {
        if ($controller->request->getURL() == 'home' || $controller->request->getURL() == '') {
            return true;
        } else {
            return false;
        }
    }

    protected function hasIndex()
    {
        $requestUrl = $this->getRequestUrl();
        if (strpos($requestUrl, 'index.php') == false) {
            return false;
        } else {
            return true;
        }
    }

    protected function isPage($controller)
    {
        if ($controller->request->getURL()) {
            return true;
        } else {
            return false;
        }
    }

    public function getExpectedUrl($controller)
    {
        $params = $controller->request->params();
        $url = $controller->link();
        $q = $this->getQueryString($controller->request);

        $url = $this->stripIndex($url);

        if (!empty($params['Action'])) {
            $url = rtrim($url, '/') . '/' . $params['Action'];
        }

        if (!empty($params['ID'])) {
            $url = rtrim($url, '/') . '/' . $params['ID'];
        }

        if ($q) {
            $url = rtrim($url, '/') . '?' . $q;
        } else {
            $url = rtrim($url, '/') . '/';
        }

        return $url;
    }

    protected function getQueryString($request)
    {
        $url = $request->getUrl(true);
        return parse_url($url, PHP_URL_QUERY);
    }

    protected function getRequestUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        return $url;
    }

    protected function stripIndex($url)
    {
        return str_replace('/index.php', "", $url);
    }
}
