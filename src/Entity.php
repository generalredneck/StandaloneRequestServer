<?php

namespace App;

class Entity {

    public function __get($name) {
        $function = 'get' . ucfirst($name);
        if (method_exists($this, $function)) {
            return $this->$function();
        }
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
    public function __set($name, $value) {
        $function = 'set' . ucfirst($name);
        if (method_exists($this, $function)) {
            return $this->$function();
        }
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
}
