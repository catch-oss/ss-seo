<?php
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
