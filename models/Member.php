<?php

class Member {
    private $id;
    private $username;
    private $name;
    private $destination;
    // ENUM('koffie', 'thee', 'water')
    private $drinkPreference;
    // workday set, permitted values:
    // SET ('maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag') NULL,
    private $workingDays;
    private $teamId;

    private $timeOff;

    function __construct($id=null, $username=null, $name=null, $destination=null,
                         $drinkPreference=null, $workingDays=null, $timeOff=null, $teamId=null){
        $this->id = $id;
        $this->username = $username;
        $this->name = $name;
        $this->destination = $destination;
        $this->drinkPreference = $drinkPreference;
        $this->workingDays = $workingDays;
        $this->timeOff = $timeOff;
        $this->teamId = $teamId;
    }

    /**
     * @return null
     */
    public function getTeamId()
    {
        return $this->teamId;
    }

    /**
     * @param null $teamId
     */
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;
    }

    /**
     * @return null
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param null $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    function setTimeOff(array $timeOff){
        $this->timeOff = $timeOff;
    }

    function getTimeOff(){
        return $this->timeOff;
    }

    function getDrinkPreference() {
        return $this->drinkPreference;
    }

    function setDrinkPreference(string $drinkPreference){
        $this->drinkPreference = $drinkPreference;
    }

    function getWorkingDays() : string {
        return $this->workingDays;
    }

    function setWorkingDays(string $workingDays) {
        $this->workingDays = $workingDays;
    }

    function getId() : int {
        return $this->id;
    }

    function getUsername() : string {
        return $this->username;
    }

    function getName() : string {
        return $this->name;
    }


    function setId(int $id){
        $this->id = $id;
    }

    function setUsername(string $username){
        $this->username = $username;
    }

    function setName(string $name){
        $this->name = $name;
    }


}
