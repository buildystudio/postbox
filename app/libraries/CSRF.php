<?php

class CSRF
{
	public static function generate() 
	{
		return Session::put('csrf', md5(uniqid()));
	}

	public static function check(string $token) 
	{
		if(Session::has('csrf') && $token === Session::get('csrf')) {
			Session::delete($token);
			return true;
		}

		return false;
	}
}