<?php
namespace App\Libraries;

class AuthLibrary
{
    private $session;

	public function __construct()
	{
       $this->session = \Config\Services::session();
    }

    public function isLoggedIn()
	{
        return $this->session->isLoggedIn;
    }

    public function isAdminLoggedIn()
	{
        return $this->session->isAdminLoggedIn;
    }
}
