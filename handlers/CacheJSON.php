<?php
class CacheJSON {
    private $file;

    public function __construct(string $path)
    {
        $this->file = $path;
    }


    /**
     * @return mixed the object stored
     */
    public function fetch(){
        $json = file_get_contents($this->file);
        return json_decode($json);
    }

    /**
     * @param $obj the variable to store
     */
    public function store($obj){
        $json = json_encode($obj);
        file_put_contents($this->file, $json);
    }
}