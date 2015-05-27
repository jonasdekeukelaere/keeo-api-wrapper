<?php

namespace FOSOpenScouting\Keeo\Entity;

class EventVisibility extends Entity
{
    protected $id;
    protected $name;
    protected $deleted;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}