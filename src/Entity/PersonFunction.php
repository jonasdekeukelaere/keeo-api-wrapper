<?php

namespace FOSOpenScouting\Keeo\Entity;

class PersonFunction extends Entity
{
    protected $id;
    protected $name;
    protected $rank;
    protected $abbreviation;
    protected $number;
    protected $for_unit;
    protected $is_fos_function;
    protected $is_combinable;
    protected $is_unique_for_unit;
    protected $assign_by_national;
    protected $deleted;

    /**
     * @return mixed
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * @return mixed
     */
    public function getAssignByNational()
    {
        return $this->assign_by_national;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return mixed
     */
    public function getForUnit()
    {
        return $this->for_unit;
    }

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
    public function getIsCombinable()
    {
        return $this->is_combinable;
    }

    /**
     * @return mixed
     */
    public function getIsFosFunction()
    {
        return $this->is_fos_function;
    }

    /**
     * @return mixed
     */
    public function getIsUniqueForUnit()
    {
        return $this->is_unique_for_unit;
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
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }


}