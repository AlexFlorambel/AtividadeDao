<?php
class PdoConexao
{
private static $instancia;

//Impedir instanciação
private function __constructor()
{

}

//Impedir clonar
private function __clone()
{

}

//Impedir utilização do Unserialize
public function __wakeup()
{

}

/**
*
* return object PDO connection
*
*/

public static function getInstancia()
{
    if(!isset(self::$instancia))
    {
        try
        {
            $dsn = "mysql:host=localhost;dbname=exemplocrud";

            $usuario = "root";

            $senha = "121018";

            //Instanciado um novo objeto PDO informando o DNS e parametros de Array

            self::$instancia = new PDO($dsn, $usuario, $senha);

            //Gerando uma Excessao do tipo PDOException com o código de erro

            self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $excecao)
        {
            echo $excecao->getMessage();
            //Encerra aplicativo

            exit();
        }

    }

    return self::$instancia;
}

}

?>