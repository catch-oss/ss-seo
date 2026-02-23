<?php
namespace CatchDesign\SS\SEO\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Core\Extension;

/**
 * @author v2
 */
class SSRobotsConfigExtension extends Extension {

    private static $db = array(
        'SSRobotsRobotTXT' => 'Text'
    );

    /**
     * [updateCMSFields description]
     * @param  FieldList $fields [description]
     * @return [type]            [description]
     */
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldsToTab(
            'Root.Robots',
            [
                new TextareaField('SSRobotsRobotTXT', 'Robots Text')
            ]
        );
    }
}
