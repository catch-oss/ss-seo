<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataExtension;

/**
 * @author v2
 */
class SSRobotsConfigExtension extends DataExtension {

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
