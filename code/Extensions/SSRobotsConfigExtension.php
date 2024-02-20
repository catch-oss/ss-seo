<?php
namespace CatchDesign\SS\SEO\Extensions;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;

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
        parent::updateCMSFields($fields);
        $fields->addFieldsToTab(
            'Root.Robots',
            [
                new TextareaField('SSRobotsRobotTXT', 'Robots Text')
            ]
        );
    }
}
