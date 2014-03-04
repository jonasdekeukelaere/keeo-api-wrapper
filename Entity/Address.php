<?php


namespace Keeo\Entity;


class Address extends Entity{
	protected $id;
	protected $street;
	protected $number;
	protected $postal_code;
	protected $city;
	protected $country_code;
	protected $residence_info;
	protected $cellphone_number;
	protected $phone_number;
	protected $fax_number;
	protected $email;
	protected $deleted;

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
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @return mixed
	 */
	public function getCountryCode()
	{
		return $this->country_code;
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
	public function getEmail()
	{
		return $this->email;
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
	public function getId()
	{
		return $this->id;
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
	public function getPhoneNumber()
	{
		return $this->phone_number;
	}

	/**
	 * @return mixed
	 */
	public function getPostalCode()
	{
		return $this->postal_code;
	}

	/**
	 * @return mixed
	 */
	public function getResidenceInfo()
	{
		return $this->residence_info;
	}

	/**
	 * @return mixed
	 */
	public function getStreet()
	{
		return $this->street;
	}


}