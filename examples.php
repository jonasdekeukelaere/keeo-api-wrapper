<?php
// Initialize Keeo
require_once('keeo.php');
$keeo = new Keeo();

// check credentials
try {
	$isLoggedIn = $keeo->userLogin('2014000217', 'test123'); // username, password (unencrypted)
} catch (CredentialsDoNotMatchException $e) {
	// username and/or password are incorrect
}

// check if a person exists
$results = $keeo->findUser('John', 'Doe', 'john.doe@fos.be', '1992-04-23');

// get a person
$person = $keeo->getPerson('2013000708'); // stemnumber

// get a unit
$unit = $keeo->getUnit('500'); // unitnumber

// get all unit numbers
$unitNumbers = $keeo->getAllUnitNumbers();

// get all persons within an unit
$members = $keeo->getAllMembersInUnit('500'); // unitnumber

// get the number of persons within a unit
$numberOfPersons = $keeo->getNumberOfPersonsInUnit('500'); // unitnumber