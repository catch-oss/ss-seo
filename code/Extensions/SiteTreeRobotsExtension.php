<?php
namespace CatchDesign\SS\SEO\Extensions;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;

/*
 * Does a lookup on init at the request URL and does a 301 redirect to page link if they are not same
 */

class SiteTreeRobotsExtension extends DataExtension
{
    private static $db = array(
        'RobotsTag' => 'Text'
    );

    public function updateSettingsFields(FieldList $fields) {
        $fields->addFieldToTab(
            'Root.Settings',
            FieldGroup::create(
                CheckboxSetField::create(
                    'RobotsTag',
                    'Options for this page',
                    [
                        'all' => 'all',
                        'noindex' => 'noindex',
                        'nofollow' => 'nofollow',
                        'none' => 'none',
                        'noarchive' => 'noarchive',
                        'nositelinkssearchbox' => 'nositelinkssearchbox',
                        'nosnippet' => 'nosnippet',
                        'indexifembedded' => 'indexifembedded',
                        'notranslate' => 'notranslate',
                        'noimageindex' => 'noimageindex',
                    ]
                )->setDescription('See <a href="https://developers.google.com/search/docs/advanced/robots/robots_meta_tag" target="_blank">docs</a> for more info')
            )->setTitle('Robots')
        );
        return $fields;
    }

    public function contentcontrollerInit()
    {
        $controller = Controller::curr();
        $res = $controller->getResponse();
        try {
            $data = $controller->data();
            $robotsTag = $data->RobotsTag ?? 'all';
        } catch (\Exception $e) {
            $robotsTag = 'all';
        }
        $val = preg_replace('/[^a-z,]/', '', $robotsTag);
        $res->addHeader('X-Robots-Tag', $val);
    }
}
