<?php

namespace Rit\Api;

class Course extends ApiConnection {

    public function __construct($json) {
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
                throw new \Exception('Invalid Course');
            }
        }

        parent::__construct();
    }

}