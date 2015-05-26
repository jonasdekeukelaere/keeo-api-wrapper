<?php


namespace FOSOpenScouting\Keeo\Entity;


class Person extends Entity{
	protected $id;
	protected $name;
	protected $first_name;
	protected $gender;
	protected $birth_date;
	protected $join_date;
	protected $totem;
	protected $pretotem;
	protected $email;
	protected $last_login_date;
	protected $password;
	protected $nutritional_requirement_id;
	protected $remarks;
	protected $valid_data;
	protected $reminder_flag;
	protected $disclaimer;
	protected $stemnumber;
	protected $phone_number;
	protected $fax_number;
	protected $cellphone_number;
	protected $photo;
	protected $facebook_url;
	protected $traffic_light;
	protected $token;
	protected $token_date;
	protected $changed_password;
	protected $deleted;
	protected $created_at;
	protected $updated_at;
	protected $addresses;
	protected $functions;
	protected $units;

	/**
	 * @return mixed
	 */
	public function getAddresses()
	{
		return $this->addresses;
	}

	/**
	 * @return mixed
	 */
	public function getBirthDate()
	{
		return $this->birth_date;
	}

	/**
	 * @return mixed
	 */
	public function getCellphoneNumber()
	{
		return $this->cellphone_number;
	}

	/**
	 * @return mixed
	 */
	public function getChangedPassword()
	{
		return $this->changed_password;
	}

	/**
	 * @return mixed
	 */
	public function getCreatedAt()
	{
		return $this->created_at;
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
	public function getDisclaimer()
	{
		return $this->disclaimer;
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
	public function getFacebookUrl()
	{
		return $this->facebook_url;
	}

	/**
	 * @return mixed
	 */
	public function getFaxNumber()
	{
		return $this->fax_number;
	}

	/**
	 * @return mixed
	 */
	public function getFirstName()
	{
		return $this->first_name;
	}

	/**
	 * @return mixed
	 */
	public function getFunctions()
	{
		return $this->functions;
	}

	/**
	 * @return mixed
	 */
	public function getGender()
	{
		return $this->gender;
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
	public function getJoinDate()
	{
		return $this->join_date;
	}

	/**
	 * @return mixed
	 */
	public function getLastLoginDate()
	{
		return $this->last_login_date;
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
	public function getNutritionalRequirementId()
	{
		return $this->nutritional_requirement_id;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @return mixed
	 */
	public function getPhoneNumber()
	{
		return $this->phone_number;
	}

	/**
	 * @return mixed
	 */
	public function getPhoto()
	{
		return $this->photo;
	}

	/**
	 * @return mixed
	 */
	public function getPretotem()
	{
		return $this->pretotem;
	}

	/**
	 * @return mixed
	 */
	public function getRemarks()
	{
		return $this->remarks;
	}

	/**
	 * @return mixed
	 */
	public function getReminderFlag()
	{
		return $this->reminder_flag;
	}

	/**
	 * @return mixed
	 */
	public function getStemnumber()
	{
		return $this->stemnumber;
	}

	/**
	 * @return mixed
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @return mixed
	 */
	public function getTokenDate()
	{
		return $this->token_date;
	}

	/**
	 * @return mixed
	 */
	public function getTotem()
	{
		return $this->totem;
	}

	/**
	 * @return mixed
	 */
	public function getTrafficLight()
	{
		return $this->traffic_light;
	}

	/**
	 * @return mixed
	 */
	public function getUnits()
	{
		return $this->units;
	}

	/**
	 * @return mixed
	 */
	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

	/**
	 * @return mixed
	 */
	public function getValidData()
	{
		return $this->valid_data;
	}


} 