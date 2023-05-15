<?php

include('conexao/conexao.php');

$db = new Database();

class Crud{
    private $conn;
    private $table_name = "bundas";

    public function __construct($db){
        $this->conn = $db;

    }


    //funcao para criar registros
    public function create($postValues){

        $nome = $postValues['nome'];
        $genero = $postValues['genero'];
        $gravadora = $postValues['gravadora'];
        $num_discos = $postValues['num_discos'];
        $qtd_albuns = $postValues['qtd_albuns'];



        $query = "INSERT INTO ".$this->table_name. " (nome,genero,gravadora,num_discos,qtd_albuns) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$nome);
        $stmt->bindParam(2,$genero);
        $stmt->bindParam(3,$gravadora);
        $stmt->bindParam(4,$num_discos);
        $stmt->bindParam(5,$qtd_albuns);
    
        
        $rows = $this->read();
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    //funcao para ler registros
    public function read(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt-> execute();
        return $stmt;
    }
    //funcao para atualizar o registro
    public function update($postValues) {   
        $id = $postValues['id'];
        $nome = $postValues['nome'];
        $genero = $postValues['genero'];
        $gravadora = $postValues['gravadora'];
        $num_discos = $postValues['num_discos'];
        $qtd_albuns = $postValues['qtd_albuns'];
         

        if(empty($id) || empty($nome) || empty($genero) || empty($gravadora) || empty($num_discos) || empty($qtd_albuns)){
            return false;
        }
        

        $query = "UPDATE ". $this->table_name . " SET nome = ?, genero = ?, gravadora = ?, num_discos = ?, qtd_albuns = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $genero);
        $stmt->bindParam(3, $gravadora);
        $stmt->bindParam(4, $num_discos);
        $stmt->bindParam(5, $qtd_albuns);
        $stmt->bindParam(6, $id);
        
        if($stmt->execute()) {
            return true;
           
        } else {
            return false;
           
        }
    }

    public function readOne($id){
        $query = " SELECT * FROM " . $this->table_name . " WHERE id = ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    

    //funcao para deletar os registros
    public function delete($id){
        $query = " DELETE FROM " . $this->table_name . " WHERE id = ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);
        if($stmt->execute()){
            print "<script> alert('Registro atualizado com sucesso!!!')</script>";
            print "<script> location.href='?action=read';</script>";
            return true;
        }else{
            return false;
        }

    }
}