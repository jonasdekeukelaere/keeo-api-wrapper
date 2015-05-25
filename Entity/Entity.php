<?php


namespace Keeo\Entity;


abstract class Entity {
	public function __construct($data = array()) {
		if(!empty($data)) $this->setData($data);
	}

	/**
	 * Sets the data of this object
	 *
	 * @param array $data
	 */
	public function setData(array $data) {
		foreach($data as $key => $value) {
			$propertyName = strtolower($key);

			if(!is_array($value)) {
				$this->{$propertyName} = $value;
			} elseif($this->isArrayAnObject($value)) {
				$this->{$propertyName} = $this->getObjectOfKey($key);
				$this->{$propertyName}->setData($value);
			} else {
				$objects = array();
				foreach($value as $possibleObject) {
					if($this->isArrayAnObject($possibleObject)) {
						$object = $this->getObjectOfKey($key);
						$object->setData($possibleObject);
						$objects[] = $object;
					}
				}
				$this->{$propertyName} = $objects;
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
			case 'PersonAttribute':
			case 'PersonAttributes':
				$object = new PersonAttribute();
				break;
            case 'event_categories':
                $object = new EventCategory();
                break;
            case 'SubscriptionStatus':
                $object = new EventSubscriptionStatus();
                break;
            case 'EventVisibility':
                $object = new EventVisibility();
                break;
            case 'PriceCategory':
            case 'PriceCategories':
                $object = new PriceCategory();
                break;
			default:
				throw new \InvalidResponseException('\'' . $key . '\' is not a known object name');
		}

		return $object;
	}


} 