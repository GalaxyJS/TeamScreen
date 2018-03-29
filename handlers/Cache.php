<?php
class Cache {
    /**
     * Wrapper class for cache functionality
     * Current version: using apcu
     */

    /**
     * @param $key the key
     * @return mixed the stored variable on success; false on failure
     */
    public function fetch($key){
        return $_SESSION[$key];
//        return apcu_fetch($key);
    }

    /**
     * @param $key the key
     * @param $value the value to store
     * @return bool true on success; false on failure
     */
    public function store($key, $value){
        $_SESSION[$key] = $value;
//        return apcu_store($key, $value);
    }

    /**
     * @param $key the key to delete
     * @return bool true on success; false on failure
     */
    public function delete($key) : bool{
        unset($_SESSION[$key]);
        return apcu_delete($key);
    }
}