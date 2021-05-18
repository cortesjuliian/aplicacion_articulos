<?php

namespace Core;

use Exception;

class Conexion {
    /**
     * Data acces Object
     */
    public $dao;

    /**
     * Servidor de la BD
     * @var string $DBHost
     */
    private static $DBHost = DB_HOST;

    /**
     * Nombre de la BD
     * @var string $DBName
     */
    private static $DBName = DB_NAME;

    /**
     * Usuario para la conexión con la BD
     * @var string $DBUser
     */
    private static $DBUser = DB_USER;

    /**
     * Contraseña de acceso a la BD
     * @var string $DBPass
     */
    private static $DBPass = DB_PASS;
    
    public function OpenConnection() : void
    {
        try {
            $this->dao = new \PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', self::$DBHost, self::$DBName), self::$DBUser, self::$DBPass, array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_PERSISTENT => false
            ));
        } catch (\PDOException $ex) {
            throw new Exception("Ocurrió un error al conectar a la BD");
        }
    }

     /**
     * Cerrar la conexión
     */
    public function __destruct()
    {
        $this->dao = null;
    }
}


?>