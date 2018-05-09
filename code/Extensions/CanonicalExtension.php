<?php

/*
 * Does a lookup on init at the request URL and does a 301 redirect to page link if they are not same
 */

class CanonicalExtension extends DataExtension
{

    public function contentcontrollerInit()
    {
        $controller = Controller::curr();

        if ($controller->request->getURL()) {

            $params = $controller->request->params();
            $url = $controller->request->getURL();
            $baseUrl = $this->parseUrl($url, $params);

            $link = $this->stripSlashes($controller->Link());

            if ($baseUrl != $link) {

                return $controller->redirect($link, 301);
            }
        }
    }

    protected function parseUrl($url, $params)
    {
        if (array_key_exists('ID', $params)) {
            $url = $this->stripID($url, $params['ID']);
            $url = $this->stripSlashes($url);
        }

        if (array_key_exists('Action', $params)) {
            $url = $this->stripAction($url, $params['Action']);
            $url = $this->stripSlashes($url);
        }

        return $url;
    }

    protected function stripSlashes($url)
    {
        return trim($url, '/');
    }

    protected function stripAction($url, $action)
    {
        return str_replace($action, "", $url);
    }

    protected function stripID($url, $id)
    {
        return str_replace($id, "", $url);
    }
}
