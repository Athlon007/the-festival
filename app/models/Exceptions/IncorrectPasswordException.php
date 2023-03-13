<?php

/**
 * Thrown when password verification fails.
 */
class IncorrectPasswordException extends Exception
{
    public function __construct(){
        parent::__construct("Incorrect password.");
    }
}
