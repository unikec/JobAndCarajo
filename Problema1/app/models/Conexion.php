<?php
namespace Problema1\app\models;

use PDO;
use PDOException;


class Conexion {
    private $servidor;
    private $usuario;
    private $password;
    private $base_datos;
    private $chartset;
    private $tipoBaseDatos;
    
    public $dbh;
    static $_instance;
    
    
    
    /*La función construct es privada para evitar que el objeto pueda 
     * ser creado mediante new*/
    private function __construct(){
       
        $this->setConexion();
        $this->conectar();
    }
    
    /*Método para establecer los parámetros de la conexión*/
    private function setConexion(){
        $conf = CONFIGURATION::getInstance();
        $this->servidor=$conf->getHostDB();
        $this->base_datos=$conf->getDB();
        $this->usuario=$conf->getUserDB();
        $this->password=$conf->getPassDB();
        $this->tipoBaseDatos=$conf->getTipoBD();
        $this->chartset=$conf->getCharsetDB();
    }
    /** Siguiendo el patron Singleton las funciones, __clone(), y conectar() son privadas*/
    
    /*Evitamos el clonaje del objeto. Patrón Singleton*/
    private function __clone(){ }
    
   
    /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar
     *  desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
    public static function getInstance(){
        if (!(self::$_instance instanceof self)){
            self::$_instance=new self();
        }
        return self::$_instance;
    }
    
    /*Realiza la conexión a la base de datos.*/
    private  function conectar(){
     
        try{ 
           // $this->dbh=new PDO($this->tipoBaseDatos.':host='.$this->servidor.';dbname='.$this->base_datos,$this->usuario,$this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" ));
            $this->dbh=new PDO($this->tipoBaseDatos.':host='.$this->servidor.';dbname='.$this->base_datos,$this->usuario,$this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND =>$this->chartset ));

        }catch(PDOException $e){
            $e->getMessage();
            exit;
        }
        
       
    }
    
    
}

