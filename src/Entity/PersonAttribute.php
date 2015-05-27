<?php

namespace FOSOpenScouting\Keeo\Entity;

class PersonAttribute extends Entity
{
	protected $id;
	protected $person_id;
	protected $person_attribute_id;
	protected $value;

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
	public function getPersonAttributeId()
	{
		return $this->person_attribute_id;
	}

	/**
	 * @return mixed
	 */
	public function getPersonId()
	{
		return $this->person_id;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}
}