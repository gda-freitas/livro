<?php 
class Livro
{
    private $gen_codigo;
    private $aut_codigo;
    private $liv_codigo;
    private $liv_titulo;
    private $liv_isbn;    
    private $liv_disponivel;
    private $liv_ativo;
    
    public function getGen_codigo()
    {
        return $this->gen_codigo;
    }
    
    public function getAut_codigo()
    {
        return $this->aut_codigo;
    }
    
    public function getLiv_codigo()
    {
        return $this->liv_codigo;
    }

    public function getLiv_titulo()
    {
        return $this->liv_titulo;
    }

    public function getLiv_ativo()
    {
        return $this->liv_ativo;
    }
    
    public function getLiv_isbn()
    {
        return $this->liv_isbn;
    }
    
    public function getLiv_disponivel()
    {
        return $this->liv_disponivel;
    }
        
    public function setGen_codigo($gen_codigo)
    {
        $this->gen_codigo = $gen_codigo;
    }
    
    public function setAut_codigo($aut_codigo)
    {
        $this->aut_codigo = $aut_codigo;
    }
    
    public function setLiv_codigo($liv_codigo)
    {
        $this->liv_codigo = $liv_codigo;
    }

    public function setLiv_titulo($liv_titulo)
    {
        $this->liv_titulo = $liv_titulo;
    }

    public function setLiv_ativo($liv_ativo)
    {
        $this->liv_ativo = $liv_ativo;
    }
    
    public function setLiv_isbn($liv_isbn)
    {
        $this->liv_isbn = $liv_isbn;
    }
    
    public function setLiv_disponivel($liv_disponivel)
    {
        $this->liv_disponivel = $liv_disponivel;
    }
        
    public function incluir()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("INSERT INTO livro (liv_titulo, liv_ativo, liv_isbn, liv_disponivel, gen_codigo, aut_codigo) ".
    						                 "VALUES (:liv_titulo, :liv_ativo, :liv_isbn, :liv_disponivel, :gen_codigo, :aut_codigo) ");
    	$stm->bindValue(':liv_titulo', $this->getLiv_titulo());
    	$stm->bindValue(':liv_ativo', 'S');
    	$stm->bindValue(':liv_isbn', $this->getLiv_isbn());
    	$stm->bindValue(':liv_disponivel','S');
    	$stm->bindValue(':gen_codigo', $this->getGen_codigo());
		$stm->bindValue(':aut_codigo', $this->getAut_codigo());
		
		if (!$stm->execute())
			return $stm->errorInfo();
    }

    public function alterar()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("UPDATE livro SET ".
	                                    "liv_titulo=:liv_titulo, ".
                                	    "liv_ativo=:liv_ativo, ".
                                	    "liv_isbn=:liv_isbn, ".
                                	    "liv_disponivel=:liv_disponivel, ".
                                	    "gen_codigo=:gen_codigo, ".
                                	    "aut_codigo=:aut_codigo ".
	                              "WHERE liv_codigo=:liv_codigo");
    	$stm->bindValue(':liv_codigo', $this->getLiv_codigo());    	
    	$stm->bindValue(':liv_titulo', $this->getLiv_titulo());
    	$stm->bindValue(':liv_ativo', $this->getLiv_ativo());
    	$stm->bindValue(':liv_isbn', $this->getLiv_isbn());
    	$stm->bindValue(':liv_disponivel', $this->getLiv_disponivel());
    	$stm->bindValue(':gen_codigo', $this->getGen_codigo());
    	$stm->bindValue(':aut_codigo', $this->getAut_codigo());
        if (!$stm->execute())
            return $stm->errorInfo();

    }

    public static function listar($codigo=null, $titulo=null, $autor=null, $genero=null, $ativo=null, $atraso=null) {
        $conexao = Database::connect();
    	$sql = "SELECT L.liv_codigo, ".
        	            "L.liv_titulo,".
                	    "L.liv_ativo,".
                	    "L.liv_isbn,".
                	    "L.liv_disponivel,".
                	    "L.gen_codigo,".
                	    "L.aut_codigo,".
                	    "G.gen_descricao,".
                	    "A.aut_nome, ".
        	            "(select max(loc_data_previsao_retorno) ".
        	            "FROM locacao where liv_codigo = L.liv_codigo AND loc_ativa = 'S') loc_data_previsao_retorno ".
                 "FROM livro as L, genero as G, autor as A ".
                "WHERE L.gen_codigo = G.gen_codigo AND L.aut_codigo = A.aut_codigo";
    	if($codigo){
    	    $sql.=" AND liv_codigo=:liv_codigo";
    	}
    	if ($titulo)
            $sql.=" AND L.liv_titulo LIKE :liv_titulo";    	
    	if ($autor)
            $sql.=" AND L.aut_codigo = :aut_nome";    	
    	if ($genero)
            $sql.=" AND L.gen_codigo = :gen_descricao";  
    	if ($ativo)
    	    $sql.=" AND L.liv_ativo = 'S'";  
	    if ($atraso){
	        if($atraso == 'S')
	           $sql.=" AND loc_data_previsao_retorno < :data_atual";   
	        else if($atraso == 'N')
	           $sql.=" AND loc_data_previsao_retorno >= :data_atual";
	    }
    	
        $stm= $conexao->prepare($sql);
             
        if($codigo)
            $stm->bindValue(':liv_codigo', $codigo);
        if($titulo)
            $stm->bindValue(':liv_titulo', '%'.$titulo.'%');
        if($autor)
            $stm->bindValue(':aut_nome', $autor);
        if($genero)
            $stm->bindValue(':gen_descricao', $genero);                
        if ($atraso)
            $stm->bindValue(':data_atual', date("Y-m-d"));
                       
            
        if (!$stm->execute()){
            return $stm->errorInfo();
        }

        $livros = array();
        while ($resultado= $stm->fetch(PDO::FETCH_ASSOC)){
            $livros[]= array( "liv_codigo" => $resultado['liv_codigo'],
                               "liv_titulo" => $resultado['liv_titulo'],
                               "liv_ativo" => $resultado['liv_ativo'],
                               "liv_isbn" => $resultado['liv_isbn'],
                               "liv_disponivel" => $resultado['liv_disponivel'],
                               "gen_codigo" => $resultado['gen_codigo'],
                               "aut_codigo" => $resultado['aut_codigo'],
                               "aut_nome" => $resultado['aut_nome'],
                               "loc_data_previsao_retorno" => $resultado['loc_data_previsao_retorno'],                        
                               "gen_descricao" => $resultado['gen_descricao']);
        }
        return $livros;
    }
            
    public function desativar($codigo)
    {
        $conexao = Database::connect();
        $stm = $conexao->prepare("UPDATE livro SET ".
            "liv_ativo='N' ".
            "WHERE liv_codigo=:liv_codigo");
        $stm->bindValue(':liv_codigo', $codigo);
        if (!$stm->execute())
            return $stm->errorInfo();            
    }
    
    public function locar($codigo, $usuario)
    {
        $conexao = Database::connect();
        $stm = $conexao->prepare("INSERT INTO locacao (liv_codigo, usu_login, loc_data_locacao, loc_data_previsao_retorno, loc_ativa) ".
                "VALUES (:liv_codigo, :usu_login, :loc_data_locacao, :loc_data_previsao_retorno, :loc_ativa) ");
        $stm->bindValue(':liv_codigo', $codigo);
        $stm->bindValue(':usu_login', $usuario);
        $date = date("Y-m-d H:i:s");
        $date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " +1 month");
        $date = date("Y-m-d H:i:s",$date);        
        $stm->bindValue(':loc_data_locacao', date("Y-m-d H:i:s"));
        $stm->bindValue(':loc_data_previsao_retorno', $date);
        $stm->bindValue(':loc_ativa', 'S');
        if (!$stm->execute())
            return $stm->errorInfo();
        
        $stm = $conexao->prepare("UPDATE livro SET ".
            "liv_disponivel='N' ".
            "WHERE liv_codigo=:liv_codigo");
        $stm->bindValue(':liv_codigo', $codigo);
        if (!$stm->execute())
            return $stm->errorInfo();
            
    }
}
