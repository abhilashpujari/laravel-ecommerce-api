<?php

namespace App\Auth;

use Illuminate\Support\Facades\Config;

/**
 * Class Identity
 * @package App\Auth
 */
class Identity
{
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $role;
    /**
     * @var string
     */
    protected $fullName;

    /**
     * Identity constructor.
     */
    public function __construct($id, $role, $fullName)
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->role = $role;
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->getRole() !== Config::get('role.guest');
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->getRole() === Config::get('role.super_admin');
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->getRole() === Config::get('role.admin');
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }
}
