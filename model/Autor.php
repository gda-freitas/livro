<?php 
class Autor
{
    private $aut_codigo;
    private $aut_nome;
    private $aut_ativo;
    
    public function getAut_codigo()
    {
        return $this->aut_codigo;
    }

    public function getAut_nome()
    {
        return $this->aut_nome;
    }

    public function getAut_ativo()
    {
        return $this->aut_ativo;
    }

    public function setAut_codigo($aut_codigo)
    {
        $this->aut_codigo = $aut_codigo;
    }

    public function setAut_nome($aut_nome)
    {
        $this->aut_nome = $aut_nome;
    }

    public function setAut_ativo($aut_ativo)
    {
        $this->aut_ativo = $aut_ativo;
    }
    
    public function incluir()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("INSERT INTO autor (aut_nome, aut_ativo) ".
    						                 "VALUES (:aut_nome, :aut_ativo) ");
		$stm->bindValue(':aut_nome', $this->getAut_nome());
		$stm->bindValue(':aut_ativo', 'S');
		if (!$stm->execute())
			return $stm->errorInfo();
    }

    public function alterar()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("UPDATE autor SET ".
	                                    "aut_nome=:aut_nome, ".
                                	    "aut_ativo=:aut_ativo ".
	                              "WHERE aut_codigo=:aut_codigo");
        $stm->bindValue(':aut_nome', $this->getAut_nome());
        $stm->bindValue(':aut_ativo', $this->getAut_ativo());
        $stm->bindValue(':aut_codigo', $this->getAut_codigo());
        if (!$stm->execute())
            return $stm->errorInfo();

    }

    public static function listar($codigo=null, $nome=null, $ativo=null) {
        $conexao = Database::connect();
    	$sql = "SELECT aut_codigo, ".    
                        "aut_nome, ".
                        "aut_ativo ".
                 "FROM autor ";
    	if($codigo){
    	    $sql.="WHERE aut_codigo=:aut_codigo ";
    	}
    	else if ($nome && $ativo)
    	    $sql.="WHERE aut_nome LIKE :aut_nome AND aut_ativo=:aut_ativo ";
    	else if ($nome)
            $sql.="WHERE aut_nome LIKE :aut_nome ";
        else if ($ativo)
            $sql.="WHERE aut_ativo=:aut_ativo ";

        $stm= $conexao->prepare($sql);
             
        if($codigo)
            $stm->bindValue(':aut_codigo', $codigo);
        if ($nome)
            $stm->bindValue(':aut_nome', '%'.$nome.'%');
        if ($ativo)
            $stm->bindValue(':aut_ativo', $ativo);

        if (!$stm->execute())
            return $stm->errorInfo();  

        $autores = array();
        while ($resultado= $stm->fetch(PDO::FETCH_ASSOC)){
            $autores[]= array( "aut_codigo" => $resultado['aut_codigo'],
                               "aut_nome" => $resultado['aut_nome'],
                               "aut_ativo" => $resultado['aut_ativo']);
        }
        return $autores;
    }
    
}
