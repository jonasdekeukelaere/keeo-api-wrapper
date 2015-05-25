<?php

// bootstrap keeo
require_once('Exceptions.php');
require_once('KeeoConnector.php');
require_once('Entity/Entity.php');
require_once('Entity/Event.php');
require_once('Entity/EventCategory.php');
require_once('Entity/EventSubscriptionStatus.php');
require_once('Entity/EventVisibility.php');
require_once('Entity/Address.php');
require_once('Entity/Person.php');
require_once('Entity/PersonAttribute.php');
require_once('Entity/PersonFunction.php');
require_once('Entity/PriceCategory.php');
require_once('Entity/Unit.php');

require_once('config.php');

class Keeo
{
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
	 * Checks if a user exists with the given attributes
	 *
	 * @param string $firstName
	 * @param string $name
	 * @param string $email
	 * @param string $birthDate		Format: Y-m-d, ex: 2011-06-28
	 * @return array
	 * @throws InvalidArgumentException
	 */
	public function findUser($firstName = '', $name = '', $email = '', $birthDate='') {
		$connector = new KeeoConnector();
		$foundUsers = array();

		// build search params
		$searchParams = array();
		if(!empty($firstName)){
			$searchParams['first_name'] = $firstName;
		}
		if(!empty($name)){
			$searchParams['name'] = $name;
		}
		if(!empty($email)){
			$searchParams['email'] = $email;
		}
		if(!empty($birthDate)){
			$birthDateObj = DateTime::createFromFormat('Y-m-d', $birthDate);

			if($birthDateObj->format('Y-m-d') == $birthDate) {
				$searchParams['birth_date'] = $birthDate;
			} else {
				throw new InvalidArgumentException('Please provide the birthDate in the Y-m-d format');
			}
		}

		if(!empty($searchParams)) {
			$response = $connector->post('/person/verify.json', $searchParams);

			if($response->headers['Status-Code'] == '200') {
				$foundUsers = json_decode($response->body);
			}
		} else {
			throw new InvalidArgumentException('At least one search parameter needs to be given.');
		}

		return $foundUsers;
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

	public function getNumberOfPersonsInUnit($unitNumber, $functionNumber = null) {
		$connector = new KeeoConnector();

		$params = array(
			'number' => $unitNumber
		);
		if(!empty($functionNumber)) $params['function_number'] = $functionNumber;

		$response = $connector->post('/unit/search-member-count.json', $params);
		$responseBody = json_decode($response->body, true);

		if(isset($responseBody['count'])) {
			$numberOfPersons = (int) $responseBody['count'];
		} else {
			throw new InvalidResponseException("Expected key 'count' not found in the response body");
		}

		return $numberOfPersons;
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


	/**
	 * Gets the event categories
	 *
	 * @return \Keeo\Entity\EventCategory[]
	 */
	public function getEventCategories() {
		$connector = new KeeoConnector();
        $categories = array();

		$response = $connector->get('/event/categories.json');
		$categoriesData = json_decode($response->body, true);

        if(isset($categoriesData['event_categories'])) {
            $categoriesData = $categoriesData['event_categories'];
        } else {
            throw new InvalidResponseException();
        }

        foreach($categoriesData as $categoryData) {
            $categories[] = new \Keeo\Entity\EventCategory($categoryData);
        }

		return $categories;
	}

    /**
     * Searches events based on given parameters
     *
     * @param int|null $categoryId   category id, found in getEventCategories()
     * @param DateTime|null $startDateFrom   start date later or equal to this value
     * @param DateTime|null $startDateUntil  start date earlier or equal to this value
     * @param DateTime|null $endDateFrom     end date later or equal to this value
     * @param DateTime|null $endDateUntil    end date earlier or equal to this value
     *
     * @return string[]     Event codes
     */
    public function findEvents(
        $categoryId = null,
        DateTime $startDateFrom = null,
        DateTime $startDateUntil = null,
        DateTime $endDateFrom = null,
        DateTime $endDateUntil = null
    )
    {
        $connector = new KeeoConnector();

        // build search params
        $searchParams = array();
        if(!empty($categoryId)){
            $searchParams['category_id'] = $categoryId;
        }
        if(!empty($startDateFrom)){
            $searchParams['start[from]'] = $startDateFrom->format('Y-m-d');
        }
        if(!empty($startDateUntil)){
            $searchParams['start[until]'] = $startDateUntil->format('Y-m-d');
        }
        if(!empty($endDateFrom)){
            $searchParams['end[from]'] = $endDateFrom->format('Y-m-d');
        }
        if(!empty($endDateUntil)){
            $searchParams['end[until]'] = $endDateUntil->format('Y-m-d');
        }

        $foundEvents = array();
        if(!empty($searchParams)) {
            $response = $connector->post('/event/search.json', $searchParams);

            if($response->headers['Status-Code'] == '200') {
                $foundEvents = json_decode($response->body);
                $foundEvents = $foundEvents->event_codes;
            }
        } else {
            throw new InvalidArgumentException('At least one search parameter needs to be given.');
        }

        return $foundEvents;
    }

    public function getEvent($eventCode)
    {
        $connector = new KeeoConnector();

        $response = $connector->get('/event/' . $eventCode . '.json');
        $eventData = json_decode($response->body, true);

        if(isset($eventData['event'])) $eventData = $eventData['event'];
        else throw new InvalidResponseException();

        return new \Keeo\Entity\Event($eventData);
    }
}