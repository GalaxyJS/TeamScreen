<?php
require_once('Handler.php');
require_once('MemberHandler.php');
require_once(dirname(__FILE__) . '/../models/TimeOff.php');


/**
 * Class TimeOffHandler
 *
 * Authors: Dominic Dingena & Carina Boom
 */
class TimeOffHandler extends Handler {

    /**
     * Take a data row from the database, return it as object.
     *
     * @param array $row
     * @return mixed
     */
    protected function factory(array $row) {
        $timeOff = new TimeOff();
        $timeOff->setId($row['id']);
        $timeOff->setStartTime($row['start_time']);
        $timeOff->setEndTime($row['end_time']);
        $memberHandler = new MemberHandler($this->dbh);
        $member = $memberHandler->factory($row);
        $member->setId($row['member_id']);
        $timeOff->setMember($member);
        return $timeOff;
    }

    /**
     * Add a timeoff object to the database
     *
     * @param TimeOff $timeOff
     */
    public function add(TimeOff $timeOff): int {
        $query = "INSERT INTO time_off(start_time, end_time, member_id) VALUES (:start_time, :end_time, :member_id)";
        $statement = $this->dbh->prepare($query);
        $statement->bindValue(':start_time', $timeOff->getStartTime(), PDO::PARAM_STR);
        $statement->bindValue(':end_time', $timeOff->getEndTime(), PDO::PARAM_STR);
        $statement->bindValue(':member_id', $timeOff->getMemberId(), PDO::PARAM_STR);
        $statement->execute();
        $id = $this->dbh->lastInsertId();
        $timeOff->setId($id);
        return $id;
    }

    /**
     * Update a time-off object in the database
     *
     * @param Member $member
     */
    public function update(TimeOff $timeOff) {
        $query = "UPDATE time_off SET start_time=:start_time, end_time=:end_time, member_id=:member_id WHERE id= :id";
        $statement = $this->dbh->prepare($query);
        $statement->bindValue(':id', $timeOff->getId(), PDO::PARAM_INT);
        $statement->bindValue(':start_time', $timeOff->getStartTime(), PDO::PARAM_STR);
        $statement->bindValue(':end_time', $timeOff->getEndTime(), PDO::PARAM_STR);
        $statement->bindValue(':member_id', $timeOff->getMemberId(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Retrieve a team's time off this week from the database
     *
     * @param int $id
     * @return array
     */
    public function getByTeamThisWeek(int $id){
        $dt = new DateTime();
        // end of this week
        $dt->modify('this saturday');
        $thisSaturday = $dt->format('Y-m-d h:m:s');

        $query = 'select *
            from member m
            inner join time_off t on m.id = t.member_id
            where ((t.start_time between NOW() and :this_saturday)
            or (t.end_time between NOW() and :this_saturday)
            or (NOW() between t.start_time and t.end_time))
            and m.working_days LIKE concat("%", lower(dayname(now())), "%")
            and team_id = :team_id';
        $sth = $this->dbh->prepare($query);
        $sth->bindValue('team_id', $id);
        $sth->bindValue('this_saturday', $thisSaturday);
        $sth->execute();
        $rows = $sth->fetchAll();
        return $this->rowsToObjects($rows);
    }

    /**
     * Retrieve a team's time off next week from the database
     *
     * @param int $id
     * @return array
     */
    public function getByTeamNextWeek(int $id){
        $dt = new DateTime();
        // beginning of the next week
        $dt->modify('next sunday');
        $nextSunday = $dt->format('Y-m-d h:m:s');
        // arbitrary day within the next week
        $dt->modify('next wednesday');
        $nextWednesday = $dt->format('Y-m-d h:m:s');
        // end of the next week
        $dt->modify('next saturday');
        $nextSaturday = $dt->format('Y-m-d h:m:s');

        $query = 'select *
            from member m
            inner join time_off t on m.id = t.member_id
            where ((t.start_time between :next_sunday and :next_saturday)
            or (t.end_time between :next_sunday and :next_saturday)
            or (:next_wednesday between t.start_time and t.end_time))
            and m.working_days LIKE concat("%", lower(dayname(now())), "%")
            and team_id = :team_id';
        $sth = $this->dbh->prepare($query);
        $sth->bindValue('team_id', $id);
        $sth->bindValue('next_sunday', $nextSunday);
        $sth->bindValue('next_wednesday', $nextWednesday);
        $sth->bindValue('next_saturday', $nextSaturday);
        $sth->execute();
        $rows = $sth->fetchAll();
        return $this->rowsToObjects($rows);
    }

    /**
     * Retrieve a team's time off next week from the database
     *
     * @param int $id
     * @return array
     */
    public function getByTeamNextTwoWeeks(int $id){
        $dt = new DateTime();
        // advance 2 weeks
        $dt->modify('next saturday');
        $dt->modify('next saturday');
        $end = $dt->format('Y-m-d h:m:s');

        $query = 'select *
            from member m
            inner join time_off t on m.id = t.member_id
            where ((t.start_time between NOW() and :end)
            or (t.end_time between NOW() and :end)
            or (NOW() between t.start_time and t.end_time))
            and m.working_days LIKE concat("%", lower(dayname(now())), "%")
            and team_id = :team_id';
        $sth = $this->dbh->prepare($query);
        $sth->bindValue('team_id', $id);
        $sth->bindValue('end', $end);
        $sth->execute();
        $rows = $sth->fetchAll();
        return $this->rowsToObjects($rows);
    }



}
