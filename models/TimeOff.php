<?php
/**
 * Class TimeOff
 *
 * Author: Vincent Huijts
 * Editor: Carina Boom
 */
class TimeOff{

    /**
     * Variables
     */
    private $id;
    private $startTime;
    private $endTime;
    private $memberId;
    private $member;

    /**
     * @return mixed
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param mixed $member
     */
    public function setMember($member)
    {
        $this->member = $member;
    }

    /**
     * TimeOff constructor.
     * @param null $id
     * @param null $startTime
     * @param null $endTime
     * @param null $memberId
     */
    function __construct($id=null, $startTime=null, $endTime=null, $memberId=null)
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->memberId = $memberId;
    }

    /**
     * Getter for MemberId
     * @return null
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Setter for MemberId
     * @param null $memberId
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    }

    /**
     * Getter for EndTime
     * @return mixed
     */
    public function getEndTime() {
        return $this->endTime;
    }

    /**
     * Getter for Id
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Getter for StartTime
     * @return mixed
     */
    public function getStartTime() {
        return $this->startTime;
    }

    /**
     * Setter for EndTime
     * @param mixed $endTime
     */
    public function setEndTime($endTime) {
        $this->endTime = $endTime;
    }

    /**
     * Setter for StartTime
     * @param null $startTime
     */
    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    /**
     * Setter for Id
     * @param null $id
     */
    public function setId($id) {
        $this->id = $id;
    }










}


