<?php

namespace FOSOpenScouting\Keeo\Entity;

class Unit extends Entity
{
	protected $id;
	protected $name;
	protected $number;
	protected $city;
	protected $setup_date;
	protected $tie_color;
	protected $logo;
	protected $website;
	protected $description;
	protected $flickr_url;
	protected $email;
	protected $deleted;

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return $this->city;
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
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return mixed
	 */
	public function getFlickrUrl()
	{
		return $this->flickr_url;
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
	public function getLogo()
	{
		return $this->logo;
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
	public function getSetupDate()
	{
		return $this->setup_date;
	}

	/**
	 * @return mixed
	 */
	public function getTieColor()
	{
		return $this->tie_color;
	}

	/**
	 * @return mixed
	 */
	public function getWebsite()
	{
		return $this->website;
	}


}