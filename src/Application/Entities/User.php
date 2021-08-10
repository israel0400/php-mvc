<?php

namespace Application\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity(repositoryClass="Application\Repositories\UserRepository")
 * @ORM\Table(name="users")
 */

class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    
    protected $username;

    /**
     * @ORM\Column(type="string")
     */

    protected $password;

    /**
     * @ORM\Column(type="string")
     */

    protected $email;

    /**
     * @ORM\Column(type="datetime")
     */

    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user", cascade={"persist","remove"})
     */
    protected $posts;

    public function __construct()
    {
        $this->created = new DateTime("now");
    }
    
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of created
     */ 
    public function getCreated()
    {
        return $this->created;
    }


    /**
     * Get the value of posts
     */ 
    public function getPosts()
    {
        return $this->posts;
    }
}