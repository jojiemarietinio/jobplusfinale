<?php
namespace App\Jobify;
class User{

   
    
   /** @var string */
    protected $id;
    protected $first_name;
    protected $last_name;
    /**
     * User constructor.
     * @param $id
     * @param $first_name
     * @param $last_name
     * @param $username
     */
    public function __construct($id = null, $first_name = null, $last_name = null)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
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
    public function getFirstName()
    {
        return $this->first_name;
    }
    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }
}  