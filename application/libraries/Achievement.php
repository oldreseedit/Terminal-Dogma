<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class Achievement
{
	abstract public function applies($userID);
}

?>