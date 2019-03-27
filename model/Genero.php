<?php 
class Genero
{
    private $gen_codigo;
    private $gen_descricao;
    private $gen_ativo;
    
    public function getGen_codigo()
    {
        return $this->gen_codigo;
    }

    public function getGen_descricao()
    {
        return $this->gen_descricao;
    }

    public function getGen_ativo()
    {
        return $this->gen_ativo;
    }

    public function setGen_codigo($gen_codigo)
    {
        $this->gen_codigo = $gen_codigo;
    }

    public function setGen_descricao($gen_descricao)
    {
        $this->gen_descricao = $gen_descricao;
    }

    public function setGen_ativo($gen_ativo)
    {
        $this->gen_ativo = $gen_ativo;
    }
    
    public function incluir()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("INSERT INTO genero (gen_descricao, gen_ativo) ".
    						                 "VALUES (:gen_descricao, :gen_ativo) ");
		$stm->bindValue(':gen_descricao', $this->getGen_descricao());
		$stm->bindValue(':gen_ativo', 'S');
		if (!$stm->execute())
			return $stm->errorInfo();
    }

    public function alterar()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("UPDATE genero SET ".
	                                    "gen_descricao=:gen_descricao, ".
                                	    "gen_ativo=:gen_ativo ".
	                              "WHERE gen_codigo=:gen_codigo");
        $stm->bindValue(':gen_descricao', $this->getGen_descricao());
        $stm->bindValue(':gen_ativo', $this->getGen_ativo());
        $stm->bindValue(':gen_codigo', $this->getGen_codigo());
        if (!$stm->execute())
            return $stm->errorInfo();

    }

    public static function listar($codigo=null, $descricao=null, $ativo=null) {
        $conexao = Database::connect();
    	$sql = "SELECT gen_codigo, ".    
                        "gen_descricao, ".
                        "gen_ativo ".
                 "FROM genero ";
    	if($codigo){
    	    $sql.="WHERE gen_codigo=:gen_codigo ";
    	}
    	else if ($descricao && $ativo)
    	    $sql.="WHERE gen_descricao LIKE :gen_descricao AND gen_ativo=:gen_ativo ";
    	else if ($descricao)
            $sql.="WHERE gen_descricao LIKE :gen_descricao ";
        else if ($ativo)
            $sql.="WHERE gen_ativo=:gen_ativo ";

        $stm= $conexao->prepare($sql);
             
        if($codigo)
            $stm->bindValue(':gen_codigo', $codigo);
        if ($descricao)
            $stm->bindValue(':gen_descricao', '%'.$descricao.'%');
        if ($ativo)
            $stm->bindValue(':gen_ativo', $ativo);

        if (!$stm->execute())
            return $stm->errorInfo();  

        $generos = array();
        while ($resultado= $stm->fetch(PDO::FETCH_ASSOC)){
            $generos[]= array( "gen_codigo" => $resultado['gen_codigo'],
                               "gen_descricao" => $resultado['gen_descricao'],
                               "gen_ativo" => $resultado['gen_ativo']);
        }
        return $generos;
    }
    
    public function desativar($codigo)
    {
        $conexao = Database::connect();
        $stm = $conexao->prepare("UPDATE genero SET ".
            "gen_ativo='N' ".
            "WHERE gen_codigo=:gen_codigo");
        $stm->bindValue(':gen_codigo', $codigo);
        if (!$stm->execute())
            return $stm->errorInfo();
            
    }
}
