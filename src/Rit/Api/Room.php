<?php

namespace Rit\Api;

/**
 * Class User
 * @package Rit\Api
 */
class Room extends ApiConnection {

    /**
     * @param $json
     */
    function __construct($json) {

        if(is_array($json))
        {
            if(isset($json[0])) {
                foreach ($json[0] as $attribute => $value) {
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
                throw new \Exception('Invalid Room');
            }
        }

        parent::__construct();
    }

}
