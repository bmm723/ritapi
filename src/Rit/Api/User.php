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
            if(isset($json)) {
                foreach ($json as $attribute => $value) {
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

        $json = $this->doQuery('users/'.$this->cn."/courses");
        $collection = $this->returnCollection($json,'Rit\Api\Meeting');

        return $collection;

    }

    public function getCourses($term = null) {

        if($term != null) {
            $options = array("term" => $term);
        } else {
            $options = array();
        }

        $json = $this->doQuery('users/'.$this->cn."/courses", $options);
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
