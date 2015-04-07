<?php

namespace Rit\Api;

/**
 * Class User
 * @package Rit\Api
 */
class User extends ApiConnection {

    /**
     * @param $json
     */
    function __construct($json) {

        if(is_array($json))
        {
            if(isset($json['data'])) {
                foreach ($json['data'] as $attribute => $value) {
                    if (is_array($value)) {
                        if (isset($value[0])) {
                            $this->$attribute = $value[0];
                        } else {
                            $this->$attribute = null;
                        }
                    } else {
                        $this->$attribute = $value;
                    }
                }
            } else {
                throw new \Exception('Invalid User');
            }
        }

        parent::__construct();

    }

    public function getMeetings() {

        $json = $this->doQuery('faculty/'.$this->cn."/meetings");
        $collection = $this->returnCollection($json,'Rit\Api\Meeting');

        return $collection;

    }

    public function getCourses() {

        $json = $this->doQuery('faculty/'.$this->cn."/courses");
        $collection = $this->returnCollection($json,'Rit\Api\Course');

        return $collection;
    }

    private function returnCollection($json,$object) {
        $collection = array();
        foreach($json as $meetingJson) {
            $collection[] = new $object($meetingJson);
        }

        return $collection;
    }

}