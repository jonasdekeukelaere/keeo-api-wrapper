<?php


namespace Keeo\Entity;


abstract class Entity {
	public function __construct($data = array()) {
		if(!empty($data)) $this->setData($data);
	}

	public function setData($data) {
		foreach($data as $key => $value) {
			if(!is_array($value)) {
				$this->{$key} = $value;
			} elseif($this->isArrayAnObject($value)) {
				$this->{$key} = $this->getObjectOfKey($key);
				$this->{$key}->setData($value);
			} else {
				$objects = array();
				foreach($value as $possibleObject) {
					if($this->isArrayAnObject($possibleObject)) {
						$object = $this->getObjectOfKey($key);
						$object->setData($possibleObject);
						$objects[] = $object;
					}
				}
				$this->{$key} = $objects;
			}
		}
	}

	/**
	 * checks if the given array is associative or not. When it's associative it, this array is in fact an object
	 *
	 * @param array $array
	 * @return bool
	 */
	private function isArrayAnObject(array $array)
	{
		return (bool) count(array_filter(array_keys($array), 'is_string'));
	}

	/**
	 * For a given key it will return an object for this key
	 *
	 * @param $key
	 * @return Entity
	 * @throws \InvalidResponseException
	 */
	private function getObjectOfKey($key)
	{
		$object = null;

		switch ($key) {
			case 'Unit':
			case 'Units':
				$object = new Unit();
				break;
			case 'Function':
			case 'Functions':
				$object = new PersonFunction();
				break;
			case 'Address':
			case 'Addresses':
				$object = new Address();
				break;
			case 'Person':
			case 'Persons':
			case 'unit_members':
				$object = new Person();
				break;
			default:

				throw new \InvalidResponseException('\'' . $key . '\' is not a known object name');

		}

		return $object;
	}


} 