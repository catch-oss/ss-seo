<?php

namespace CatchDesign\SS\SEO\Extensions;

use SilverStripe\Control\Controller;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;

/**
 * Adds per-page robots meta tag control and sets X-Robots-Tag header on responses.
 */
class SiteTreeRobotsExtension extends Extension
{
    private static $db = [
        'RobotsTag' => 'Text',
    ];

    public function updateSettingsFields(FieldList $fields): void
    {
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
    }

    public function contentcontrollerInit(): void
    {
        $controller = Controller::curr();
        if ($controller === null) {
            return;
        }

        $res = $controller->getResponse();
        // Broad catch is intentional — data() can fail on ErrorPages, previews, or
        // controllers without a data record. Defaulting to 'all' is the safest fallback.
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
