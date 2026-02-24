<?php

namespace CatchDesign\SS\SEO\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;

class SSRobotsConfigExtension extends Extension
{
    private static $db = [
        'SSRobotsRobotTXT' => 'Text',
    ];

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->addFieldsToTab(
            'Root.Robots',
            [
                TextareaField::create('SSRobotsRobotTXT', 'Robots Text'),
            ]
        );
    }
}
