<?php 
namespace App\Utils;

use ErrorException;
use Exception;
use PDO;
use PDOException;
use Dotenv\Dotenv;

class Database
{
    private $dbh ;
    private $envData;
    private $smtm = null;
    public function __construct(){
        $dotenv  = Dotenv::createImmutable(dirname(__DIR__,2));
        $dotenv->load();
        $this->envData = [
            'HOST' => $_ENV['DBHOST'],
            'DBNAME' => $_ENV['DBNAME'],
            'USER' => $_ENV['DBUSER'],
            'PASSWORD' => $_ENV['DBPASS'],
            'CHARSET' => $_ENV['DB_CHARSET'] ?? 'utf8',
        ];
    }

    private function goonect(){
        if(!is_null($this->dbh)){
            throw new ErrorException('No cuenta con datos en la base de datos');
        }
        try{
            $this->dbh = new PDO(
                "mysql:host={$this->envData['HOST']};dbname={$this->envData['DBNAME']};charset={$this->envData['CHARSET']}",
                $this->envData['USER'],
                $this->envData['PASSWORD']
            );
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die($e->getMessage());
        }
        return $this->dbh;
    }

    public function QueryGeneral(String $query){
        $this->smtm = $this->dbh->prepare($query);
    }

    public function Find($arr){
        $this->smtm = $this->dbh->prepare("SELECT {$arr['columnas']}
        FROM {$arr['tablas']} WHERE {$arr['condicion']}");
       return self::execution();
    }

    public function execution(){
        return $this->smtm->execute();
    }

    private function Bind(){
        
    }

}