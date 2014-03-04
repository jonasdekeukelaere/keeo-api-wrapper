<?php

class KeeoConnectionException extends RuntimeException {

}

class InvalidResponseException extends KeeoConnectionException {

}

class CredentialsDoNotMatchException extends RuntimeException {

}