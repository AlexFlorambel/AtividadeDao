<?php
include "contato.php";
include "daocontato.php";
include "pdoconexao.php";


header("Content-Type: text/html; charset=utf-8",true);

function carregarClasse( $classe )
{
    if(file_exists( "{$classe}.php" )) 
    {
        include_once "{$classe}.php";
    }
    else
    {
        echo "O arquivo {$classe}.php da classe {$classe} não foi encontrado";
    }

}

spl_autoload_register('carregarClasse');

$tabelaContato = new DaoContato();

if(isset($_POST['new'])){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $novoContato = new Contato($nome, $email, $telefone);
    

    //adicionar contato na tabela
    $tabelaContato->create($novoContato);
    echo 'Conta criada com sucesso!';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade Dao</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div>
<h1>Cadastro</h1>

<form action="" method='post'>
    <label for="nome">Nome e Sobrenome:</label>
    <input type="text" id='nome' name='nome'>
    <br>
    <label for="email">Email:</label>
    <input type="email" id='email' name='email' required placeholder="seuemail@dominio.com">
    <br>
    <label for="telefone">Telefone:</label>
    <input type="tel" id='telefone' name='telefone' required >
    <br>
    <input type="submit" value='Cadastrar' name='new' class="cadastro">
</form>
</div>


<div>
<h1>Pegar cadastro</h1>

<form action="" method='post'>
    <label for="id">ID</label>
    <input type="text" id='id' name='id'>

    <input type="submit" value='Localizar' name='acharid' class="cadastro">
</form>

<?php
    if(isset($_POST['acharid']))
    {
        $id = $_POST['id'];

        $buscaContato = $tabelaContato->read($id);
       
        ?>
            <table border = 1>
                <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>EMAIL</th>
                    <th>TELEFONE</th>
                </tr>

                <tr>
                    <th><?php echo $buscaContato->getId()?></th>
                    <th><?php echo $buscaContato->getNome()?></th>
                    <th><?php echo $buscaContato->getEmail()?></th>
                    <th><?php echo $buscaContato->getTelefone()?></th>
                </tr>
            </table>
        <?php
    }

?>
</div>

<div>
    <h1>Atualizar cadastro</h1>

    <form action="" method="post">
        <label for="up_id">Id</label>
        <input type="number" id="up_id" name="up_id">
        <br>
        <label for="up_nome">Nome</label>
        <input type="text" id="up_nome" name="up_nome">
        <br>
        <label for="up_email">Email</label>
        <input type="text" id="up_email" name="up_email">
        <br>
        <label for="up_tel">Telefone</label>
        <input type="text" id="up_tel" name="up_tel">
        <br>
        <input type="submit" value="Atualizar dados" name="update_button" class="cadastro">
    </form>

    <?php
        if(isset($_POST['update_button']))
        {
            $up_id = (int)$_POST['up_id'];
            $up_nome = $_POST['up_nome'];
            $up_email = $_POST['up_email'];
            $up_tel = $_POST['up_tel'];

            $up_contato = new Contato($up_nome, $up_email, $up_tel);
            $up_contato->setId($up_id);

            $tabelaContato->update($up_contato);
            echo "Informacoes atualizadas com sucesso!";
        }
    ?>
</div>

<div>
    <h1>Excluir Cadastro</h1>
    <form action="" method='post'>
        <label for="">ID</label>
        <input type="text" id='del_id' name='del_id'>
        <input type="submit" value='Excluir cadastro' name='del_button' class="cadastro">

    </form>

    <?php
        if(isset($_POST['del_button']))
        {
            $del_id = (int)$_POST['del_id'];

            $tabelaContato->delete($del_id);

            echo "Contato deletado com sucesso!";
        }
    ?>
</div>

<div>
    <h1>Lista</h1>
    <?php
    $listaContato = $tabelaContato->readAll();

    ?>
        <table border='1'>
            <tr>
                <td>id</td>
                <td>nome</td>
                <td>email</td>
                <td>telefone</td>
            </tr>

    <?php
    
    foreach($listaContato as $celula)
    {
        echo"<tr>";
        echo"<td>".$celula['ID']."</td>";
        echo"<td>".$celula['NOME']."</td>";
        echo"<td>".$celula['EMAIL']."</td>";
        echo"<td>".$celula['TELEFONE']."</td>";
        echo"</tr>";
    }

    ?>

    </table>
</div>
    






</body>
</html>


