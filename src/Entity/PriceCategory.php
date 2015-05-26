<?php

namespace FOSOpenScouting\Keeo\Entity;


class PriceCategory extends Entity
{
    protected $id;
    protected $event_id;
    protected $name;
    protected $price;
    protected $is_default;
    protected $description;
    protected $event;

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
    public function getEventId()
    {
        return $this->event_id;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getIsDefault()
    {
        return $this->is_default;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }
}