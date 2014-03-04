<?php

// bootstrap keeo
require_once('Exceptions.php');
require_once('KeeoConnector.php');
require_once('Entity/Entity.php');
require_once('Entity/Address.php');
require_once('Entity/Person.php');
require_once('Entity/PersonFunction.php');
require_once('Entity/Unit.php');

require_once('config.php');

class Keeo {
	/**
	 * Checks the given credentials against keeo. Returns true if the credentials are correct.
	 * Throws an exception when the login failed.
	 *
	 * @param $stemnumber
	 * @param $password
	 * @return bool
	 * @throws InvalidResponseException
	 * @throws CredentialsDoNotMatchException
	 */
	public function userLogin ($stemnumber, $password) {
		$credentialsCorrect = false;
		$connector = new KeeoConnector();

		$response = $connector->post('/person/login.json', array(
			'login' => $stemnumber,
			'password' => $password
		));

		// validate response
		if(!empty($response->headers['X-Json'])){
			// remove the ( and ) at the beginning en ending of this string
			$json = substr($response->headers['X-Json'], 1, -1);
			$receivedData = json_decode($json, true);

			if(isset($receivedData['result']) && $receivedData['result'] = 'ok' && isset($receivedData['authenticated'])) {
				if($receivedData['authenticated']) {
					if(!isset($receivedData['hash'])) throw new InvalidResponseException();
					// check the hash
					$receivedHash = $receivedData['hash'];
					$calculatedHash = md5($stemnumber.KEEO_USERLOGIN_SALT.$password.date('YmdH'));

					if($receivedHash == $calculatedHash) {
						$credentialsCorrect = true;
					}
				} else {
					if(isset($receivedData['message'])) {
						$message = $receivedData['message'];
					}
					throw new CredentialsDoNotMatchException($message);
				}
			} else {
				throw new InvalidResponseException();
			}
		}

		return $credentialsCorrect;
	}

	/**
	 * Get a person from Keeo
	 *
	 * @param $stemnumber
	 * @return \Keeo\Entity\Person
	 * @throws InvalidResponseException
	 */
	public function getPerson($stemnumber) {
		$connector = new KeeoConnector();

		$response = $connector->get('/person/'.$stemnumber.'.json');
		$personData = json_decode($response->body, true);

		if(isset($personData['person'])) $personData = $personData['person'];
		else throw new InvalidResponseException();

		return new \Keeo\Entity\Person($personData);
	}

	/**
	 * Get a function from Keeo
	 *
	 * @return \Keeo\Entity\PersonFunction
	 */
	public function getFunctions() {
		$functions = array();
		$connector = new KeeoConnector();

		$response = $connector->get('/person/functions.json');
		$functionsData = json_decode($response->body, true);

		if(isset($functionsData['functions'])) $functionsData = $functionsData['functions'];
		else throw new InvalidResponseException();

		foreach($functionsData as $functionData) {
			$functions[] = new \Keeo\Entity\PersonFunction($functionData);
		}

		return $functions;
	}

	/**
	 * Get a unit from Keeo
	 *
	 * @param $unitNumber
	 * @return \Keeo\Entity\Unit
	 */
	public function getUnit($unitNumber)
	{
		$connector = new KeeoConnector();

		$response = $connector->get('/unit/'.$unitNumber.'.json');
		$unitData = json_decode($response->body, true);

		if(isset($unitData['unit_data'])) $unitData = $unitData['unit_data'];
		else throw new InvalidResponseException();

		return new \Keeo\Entity\Unit($unitData);
	}

	/**
	 * Get all members in a unit
	 *
	 * @param $unitNumber
	 * @return array<\Keeo\Entity\Person>
	 */
	public function getAllMembersInUnit($unitNumber) {
		return $this->searchMembersInUnit($unitNumber);
	}

	/**
	 * @param $unitNumber
	 * @param string $functionNumber
	 * @return array<\Keeo\Entity\Person>
	 * @throws InvalidResponseException
	 */
	public function searchMembersInUnit($unitNumber, $functionNumber = null) {
		$connector = new KeeoConnector();

		$params = array(
			'number' => $unitNumber
		);
		if(!empty($functionNumber)) $params['function_number'] = $functionNumber;

		$response = $connector->get('/unit/search-members.json', $params);
		$membersData = json_decode($response->body, true);

		if(isset($membersData['unit_members'])) {
			$membersData = $membersData['unit_members'];
		} else {
			throw new InvalidResponseException();
		}

		foreach($membersData as $memberData) {
			$members[] = new \Keeo\Entity\Person($memberData);
		}

		return $members;
	}

	public function getUnitCategories() {
		$connector = new KeeoConnector();

		$response = $connector->get('/unit/categories.json');
		$categories = json_decode($response->body, true);

		return $categories;
	}

	/**
	 * Get all unitnumbers in Keeo
	 *
	 * @return array<string>
	 */
	public function getAllUnitNumbers() {
		return $this->getUnitsNumbersInCategory(1);
	}

	/**
	 * Get all unit numbers within a category
	 *
	 * @param $categoryId
	 * @return mixed
	 * @throws InvalidResponseException
	 */
	public function getUnitsNumbersInCategory($categoryId)
	{
		$connector = new KeeoConnector();

		$params = array();
		if(!empty($categoryId)) $params['category_id'] = $categoryId;

		$response = $connector->get('/unit/select-by-category-id.json', array(
			'category_id' => $categoryId
		));
		$unitData = json_decode($response->body, true);

		if(isset($unitData['unit_numbers'])) {
			$unitNumbers = $unitData['unit_numbers'];
		} else {
			throw new InvalidResponseException();
		}

		return $unitNumbers;
	}

}