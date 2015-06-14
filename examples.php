<?php

// require the Composer autoloader
require __DIR__ . '/vendor/autoload.php';

// defines an array $config, see config.sample.php for its structure
require_once('config.php');
// Initialize Keeo
$keeo = new \FOSOpenScouting\Keeo\Keeo($config);

// check credentials
try {
    $isLoggedIn = $keeo->userLogin('2014000217', 'test123'); // username, password (unencrypted)
} catch (\FOSOpenScouting\Keeo\Exception\CredentialsDoNotMatchException $e) {
    // username and/or password are incorrect
}

// check if a person exists
$results = $keeo->findUser(
    'John',
    'Doe',
    'john.doe@fos.be',
    DateTime::createFromFormat('Y-m-d', '1992-04-23')
);

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

// find events, returns a list of event codes
$events = $keeo->findEvents(
    1,   // category id
    DateTime::createFromFormat('Y-m-d', '2013-01-01'),  // start date from
    DateTime::createFromFormat('Y-m-d', '2013-12-31') , // start date until
    DateTime::createFromFormat('Y-m-d', '2015-05-01'),  // end date from
    DateTime::createFromFormat('Y-m-d', '2015-05-31')   // end date until
);

// get event
$event = $keeo->getEvent('SD2014');

// subscribe person to an event
$keeo->subscribePersonToEvent(
    '2014000217',  // stemnumber from person to be subscribed to the event
    'SD2014',       // event code
    '2014000217',   // administrator stemnumber (administrator, unit with writing permissions or person to be subscribed)
    'test123',      // password from administrator
    6               // id of the price category
);