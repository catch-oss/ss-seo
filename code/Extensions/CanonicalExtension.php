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

            $url = '/' . $controller->request->getURL() . '/';
            $link = $controller->Link();

            if ($url != $link) {
                return $controller->redirect($link, 301);
            }
        }
    }
}
