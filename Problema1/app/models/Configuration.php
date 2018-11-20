<?php
namespace Problema1\app\models;
//require ''; 'confi.php';
class Configuration
{
   // private $_domain;
    private $_userdb;
    private $_passdb;
    private $_hostdb;
    private $_db;
    private $_tipoBaseDatos;
    private $_charset;
    
    static $_instance;
    
    private function __construct(){
        require 'confi.php';
       // $this->_domain=$domain;
        $this->_userdb=$user;
        $this->_passdb=$password;
        $this->_hostdb=$host;
        $this->_db=$db;
        $this->_tipoBaseDatos= $tipoBD;
        $this->_charset=$charset;
    }
    
    private function __clone(){ }
    
    public static function getInstance(){
        if (!(self::$_instance instanceof self)){
            self::$_instance=new self();
        }
        return self::$_instance;
    }
    
    public function getUserDB(){
        $var=$this->_userdb;
        return $var;
    }
    
    public function getHostDB(){
        $var=$this->_hostdb;
        return $var;
    }
    
    public function getPassDB(){
        $var=$this->_passdb;
        return $var;
    }
    
    public function getDB(){
        $var=$this->_db;
        return $var;
    }
    public function getTipoBD(){
        $var=$this->_tipoBaseDatos;
        return $var;
    }
    public function getCharsetDB(){
        $var=$this->_charset;
        return $var;
    }
    
}

