<?php

namespace GSB\DAO;

use GSB\Domain\Activity;

class ActivityDAO extends DAO
{
    /**
     * Returns the list of all activites, sorted by trade name.
     *
     * @return array The list of all activities.
     */
    public function findAll() {
        $sql = "select * from activity order by activity_theme";
        $result = $this->getDb()->fetchAll($sql);
        
        // Converts query result to an array of domain objects
        $activities = array();
        foreach ($result as $row) {
            $activityId = $row['activity_id'];
            $activities[$activityId] = $this->buildDomainObject($row);
        }
        return $activities;
    }

    /**
     * Returns the activity matching a given id.
     *
     * @param integer $id The activity id.
     *
     * @return \GSB\Domain\Activity|throws an exception if no activity is found.
     */
    public function find($id) {
        $sql = "select * from activity where activity_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row){
            $activity = $this->buildDomainObject($row);
           // $activity->setDate($activity->getDate()." 00:00:00");
            return($activity);
        }
        else
            throw new \Exception("No activity found for id " . $id);
    }

    /**
     * Creates a Activity instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \GSB\Domain\Activity
     */
    protected function buildDomainObject($row) {
        $activity = new Activity();
        $activity->setId($row['activity_id']);
        $activity->setDate($row['activity_date']);
        $activity->setPlace($row['activity_place']);
        $activity->setTheme($row['activity_theme']);
        $activity->setPurpose($row['activity_purpose']);
        return $activity;
    }
    
        public function convertJsonObject($data){            
        $activity = new Activity();
        $activity->setId($data['id']);
        $activity->setDate($data['date']);
        $activity->setPlace($data['place']);
        $activity->setTheme($data['theme']);
        $activity->setPurpose($data['purpose']);
        return $activity;
    }
    
    /**
     * Saves an activity into the database.
     *
     * @param \GSB\Domain\Activity $activity The activity to save
     */
    public function save(Activity $activity) {
        $activityData = array(
            'activity_date' => $activity->getDate()->format('Y-m-d'),
            'activity_place' => $activity->getPlace(),
            'activity_theme' => $activity->getTheme(),
            'activity_purpose' => $activity->getPurpose(),
        );
        if ($activity->getId()) {
            // The article has already been saved : update it
            $this->getDb()->update('activity', $activityData, array('activity_id' => $activity->getId()));
        } else {
            // The article has never been saved : insert it
            $this->getDb()->insert('activity', $activityData);
            // Get the id of the newly created article and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $activity->setId($id);
        }
    }
}