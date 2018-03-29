<?php

/**
 * Class Team
 * @author Dominic
 */
class Team {

    private $id;
    private $label;
    private $members;

    function __construct(int $id=null, string $label=null){
        $this->id = $id;
        $this->label = $label;
    }

    function setId(int $id){
        $this->id = $id;
    }

    function setLabel(string $label){
        $this->label = $label;
    }
    function setMembers(array $members){
        $this->members = $members;
    }

    function getId() : int {
        return $this->id;
    }

    function getLabel() : string {
        return $this->label;
    }

    function getMembers() : array {
        return $this->members;
    }

}
