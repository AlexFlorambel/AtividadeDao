<?php

require 'intefaceIDAOModeCrud.php';

class DaoContato implements iDaoModeCrud {
    private $instanciaConexaoPdoAtiva;
    private $tabela;
    
    public function __construct()
    {

        $this->instanciaConexaoPdoAtiva = PdoConexao::getInstancia();
        $this->tabela = "contatos";        
    }

    //CREATE: Insere informacoes no banco de dados
    public function create($objeto)
    {
        $id = $this->getNewIdContato();
        $nome = $objeto->getNome();
        $email = $objeto->getEmail();
        $telefone = $objeto->getTelefone();

        $sqlStmt = "INSERT INTO {$this->tabela} (ID, NOME, EMAIL, TELEFONE) VALUES (:id, :nome, :email, :telefone)";

        try
        {
            $operacao = $this->instanciaConexaoPdoAtiva->prepare($sqlStmt);
            $operacao->bindValue(":id", $id, PDO::PARAM_INT);
            $operacao->bindValue(":nome", $nome, PDO::PARAM_STR);
            $operacao->bindValue(":email", $email, PDO::PARAM_STR);
            $operacao->bindValue(":telefone", $telefone, PDO::PARAM_STR);

            if($operacao->execute())
            {
                if($operacao->rowCount() > 0) 
                {
                    $objeto->setID($id);
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
            
        }
        catch( PDOException $excecao )
        {
            echo $excecao->getMessage();
        } 
    }


    //READ: Retorna um objeto refletindo um contato
    /*
    @param int $id
    @return object
    */
    public function read($id)
    {
        $sqlStmt = "SELECT * from {$this->tabela} WHERE ID=:id";

        try
        {
            $operacao = $this->instanciaConexaoPdoAtiva->prepare($sqlStmt);
            $operacao->bindValue(":id", $id, PDO::PARAM_INT);
            $operacao->execute();

            $getRow = $operacao->fetch(PDO::FETCH_OBJ);
            $nome = $getRow->nome;
            $email = $getRow->email;
            $telefone = $getRow->telefone;

            $objeto = new Contato( $nome, $email, $telefone );
            $objeto->setId($id);
            return $objeto;
        }
        catch ( PDOException $excecao )
        {
            echo $excecao->getMessage();
        }
    }


    //UPDATE: Atualiza um contato

    public function update($objeto)
    {
        $id = $objeto->getId();
        $nome = $objeto->getNome();
        $email = $objeto->getEmail();
        $telefone = $objeto->getTelefone();
        $sqlStmt = "UPDATE {$this->tabela} SET NOME=:nome, EMAIL=:email, TELEFONE=:telefone WHERE ID=:id";
    
        try
        {
            $operacao = $this->instanciaConexaoPdoAtiva->prepare($sqlStmt);
            $operacao->bindValue(":id", $id, PDO::PARAM_INT);
            $operacao->bindValue(":nome", $nome, PDO::PARAM_STR);
            $operacao->bindValue(":email", $email, PDO::PARAM_STR);
            $operacao->bindValue(":telefone", $telefone, PDO::PARAM_STR);

            if($operacao->execute())
            {
                if($operacao->rowCount() > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }

            }
            else
            {
                return false;
            }
        }
        catch ( PDOException $excecao )
        {
            echo $excecao->getMessage();
        }
    }

    //DELETE: Exclui um contato no banco de dados conforme informado por id
    public function delete ($id)
    {
        $sqlStmt = "DELETE FROM {$this->tabela} WHERE ID=:id";

        try
        {
            $operacao = $this->instanciaConexaoPdoAtiva->prepare($sqlStmt);
            $operacao->bindValue(":id", $id, PDO::PARAM_INT);

            if($operacao->execute())
            {
                if($operacao->rowCount() > 0) 
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        catch ( PDOException $excecao )
        {
            echo $excecao->getMessage();
        }
    }


    //getNewIdContato retorna um novo id para novos registros
    private function getNewIdContato()
    {
        $sqlStmt = "SELECT MAX(ID) AS ID FROM {$this->tabela}";

        try
        {
            $operacao = $this->instanciaConexaoPdoAtiva->prepare($sqlStmt);

            if($operacao->execute()) 
            {
                if($operacao->rowCount() > 0)
                {
                    $getRow = $operacao->fetch(PDO::FETCH_OBJ);
                    $idReturn = (int) $getRow->ID + 1;
                    return $idReturn;
                }
                else
                {
                    throw new Exception("correu um problema com o banco de dados");
                    exit();
                }
            }
            else
            {
                throw new Exception("Ocorreu um problema com o banco de dados");
                exit();
            }
        }
        catch(PDOException $excecao)
        {
            echo $excecao->getMessage();
        }
    }
}

?>