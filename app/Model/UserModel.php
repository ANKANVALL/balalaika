<?php 
namespace App\Model;

use App\Utils\Database;

class UserModel{

    private $database;
    public function __construct(){
        $this->database = new Database();

    }

    
}