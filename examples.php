<?php
// Initialize Keeo
require_once('Keeo.php');
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

// get the event categories
$categories = $keeo->getEventCategories();

// get events
$events = $keeo->findEvents(
    1,   // category id
    DateTime::createFromFormat('Y-m-d', '2013-01-01'),  // start date from
    DateTime::createFromFormat('Y-m-d', '2013-12-31') , // start date until
    DateTime::createFromFormat('Y-m-d', '2015-05-01'),  // end date from
    DateTime::createFromFormat('Y-m-d', '2015-05-31')   // end date until
);

$event = $keeo->getEvent('SD2014');
