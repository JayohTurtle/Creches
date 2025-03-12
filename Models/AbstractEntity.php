<?php

class AbstractEntity{

    public function __construct(array $data = [])
    {
        if (!empty ($data)){
            $this -> hydrate($data);
        }  
    }

    public function hydrate(array $data = []) {
        foreach ($data as $key => $value){
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
        
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}