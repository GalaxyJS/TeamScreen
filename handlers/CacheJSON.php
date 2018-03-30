<?php

/**
 * Class CacheJSON
 * @author Dominic
 */
class CacheJSON {
    private $file;

    public function __construct(string $path)
    {
        $this->file = $path;
    }

    /**
     * @return mixed the object stored on succes; false on failure
     */
    public function fetch(){
        if (file_exists($this->file)){
            $json = file_get_contents($this->file);
            return json_decode($json);
        }
        return false;
    }

    /**
     * @param $obj the variable to store
     * @return int|bool the number of bytes written on succes, false on failure
     */
    public function store($obj){
        $json = json_encode($obj);
        return file_put_contents($this->file, $json);
    }
}