<?php

//incluir o arquivo da classe e o arquivo de conexao

require_once ('classes/crud.php');
require_once ('conexao/conexao.php');

$database = new Database();
$db = $database->getConnection();
$crud = new Crud($db);

if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'create':
            $crud->create($_POST);
            $rows = $crud->read();
            break;
        case 'read':
            $rows = $crud->read();
            break;
            
        case 'update':
            if(isset($_POST['id'])){
                $crud->update($_POST);
            }
            $rows = $crud->read();  
            break;

        case 'delete':
            $crud->delete($_GET['id']);
            $rows = $crud->read();
            break;

        default:
            $rows = $crud->read();
            break;
    }
}else{
    $rows = $crud->read();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema De Bandas</title>
    <style>
        body {
            background-color: #f7e2c8;
            font-family: Arial, sans-serif;
        }
        
        form {
            display:flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px #ddd;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #555;
        }
        
        label {
            display: block;
            margin-top: 20px;
            font-size: 16px;
            color: #555;
        }
        
        input[type=text], 
        input[type=number],
        input[type=file],
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            color: #555;
        }
        
        input[type=submit] {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            font-size: 16px;
        }
        
        input[type=submit]:hover {
            background-color: #45a049;
        }
        
        input[type=submit]:focus {
            outline: none;
        }
        table {
        border-collapse: collapse;
        width: 100%;
        font-family: Arial, sans-serif;
        font-size: 15px;
        color: #333;
        }

        th, td {
        text-align: center;
        padding: 1px;
        border: 1px solid #ddd;
        background-color: #f2f2f2;
        }

        th {
        
        font-weight: bold;
        }

        tr:nth-child(even) {
        background-color: #f9f9f9;
        }

        a {
        display: inline-block;
        margin-top: 0.9em;
        padding: 6px 6px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        }

        a:hover {
        background-color: #0069d9;
        }

        a.delete {
        background-color: #dc3545;
        }

        a.delete:hover {
        background-color: #c82333;
        }

    </style>
</head>
<body>

    <?php
        if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){
        $id = $_GET['id'];
        $result = $crud->readOne($id);
            
            if(!$result){
                echo "REGISTRO NÃO ENCONTRADO.";
                exit();
            }
            $nome = $result['nome'];
            $genero = $result['genero'];
            $gravadora = $result['gravadora'];
            $num_discos = $result['num_discos'];
            $qtd_albuns = $result['qtd_albuns'];

    ?>
    <form method="POST" action="?action=update">
        <h1>Editar Banda</h1>
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <label for="nome_banda">Nome da Banda:</label>
        <input type="text" id="nome_banda" name="nome" value ="<?php echo $nome ?>">

        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero" value ="<?php echo $genero ?>">

        <label for="gravadora">Gravadora:</label>
        <input type="text" id="gravadora" name="gravadora" value ="<?php echo $gravadora ?>">

        <label for="num_discos">Número de Discos:</label>
        <input type="number" id="num_discos" name="num_discos" value ="<?php echo $num_discos ?>">

        <label for="qtd_albuns">Quantidade de Álbuns:</label>
        <input type="number" id="qtd_albuns" name="qtd_albuns" value ="<?php echo $qtd_albuns ?>">


        <input type="submit" value="Atualizar" name="enviar" >

        <a href="index.php">Voltar ao formulario de criação</a>
    </form>

        <?php
            }else{

            
        ?>

    <form method="POST" action="?action=create">
        <h1>Sistem of Bandas</h1>
        <label for="nome_banda">Nome da Banda:</label>
        <input type="text" id="nome_banda" name="nome" required>

        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero" required>

        <label for="gravadora">Gravadora:</label>
        <input type="text" id="gravadora" name="gravadora" required>

        <label for="num_discos">Número de Discos:</label>
        <input type="number" id="num_discos" name="num_discos" required>

        <label for="qtda_albuns">Quantidade de Álbuns:</label>
        <input type="number" id="qtda_albuns" name="qtd_albuns" required>

        <input type="submit" value="Enviar">
    </form>
        <?php
            }
        ?>
    <table>
        <tr>
            <th>Id</th>
            <th>Nome da Banda</th>
            <th>Genero</th>
            <th>Gravadora</th>
            <th>Numero de discos</th>
            <th>Quantidade de Albuns</th>
            <th>Ações</th>
            
        </tr>
        <?php

    if (isset($rows)) {
        foreach($rows as $row){
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['nome']."</td>";
            echo "<td>".$row['genero']."</td>";
            echo "<td>".$row['gravadora']."</td>";
            echo "<td>".$row['num_discos']."</td>";
            echo "<td>".$row['qtd_albuns']."</td>";
            echo "<td>";
            echo "<a href='?action=update&id=".$row['id']."'>Editar</a>";
            echo "<a href='?action=delete&id=".$row['id']."' onclick='return confirm(\"Tem certeza que deseja deletar esse registro?\")' class='delete'>Excluir</a>";
            echo "</td>";
            echo "</tr>";

        }
    }else{
        echo "Não há registros a serem exibidos.";
    }
        ?>
    </table>
</body>
</html>
