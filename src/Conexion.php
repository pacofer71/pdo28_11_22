<?php
namespace Src;
use \PDO;
//require __DIR__."/../vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../");
$dotenv->safeLoad();

class Conexion{
    protected static $conexion;

    public function __construct()
    {
        if(self::$conexion==null){
            $this->conectarDb();
        }
    }
    private function conectarDb(): \PDO{
        $user=$_ENV['USER'];
        $pass=$_ENV['PASS'];
        $host=$_ENV['HOST'];
        $db=$_ENV['DATABASE'];

        $dsn = "mysql:dbname=$db;host=$host;charset=utf8mb4";
        try{
            self::$conexion=new \Pdo($dsn, $user, $pass);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $ex){
            die("Error en la conexión: ".$ex->getMessage());
        } 
        return self::$conexion;
    }

}
//new Conexion;