<?php 
class Locacao
{
    private $loc_codigo;
    private $liv_codigo;
    private $usu_login;
    private $loc_data_locacao;
    private $loc_data_previsao_retorno;   
    private $loc_data_devolucao;
    private $loc_ativa;
    
     
    public function getLoc_codigo()
    {
        return $this->loc_codigo;
    }

    public function getLiv_codigo()
    {
        return $this->liv_codigo;
    }

    public function getUsu_login()
    {
        return $this->usu_login;
    }

    public function getLoc_data_locacao()
    {
        return $this->loc_data_locacao;
    }

 
    public function getLoc_data_previsao_retorno()
    {
        return $this->loc_data_previsao_retorno;
    }

   
    public function getLoc_data_devolucao()
    {
        return $this->loc_data_devolucao;
    }

  
    public function getLoc_ativa()
    {
        return $this->loc_ativa;
    }

  
    public function setLoc_codigo($loc_codigo)
    {
        $this->loc_codigo = $loc_codigo;
    }

 
    public function setLiv_codigo($liv_codigo)
    {
        $this->liv_codigo = $liv_codigo;
    }

  
    public function setUsu_login($usu_login)
    {
        $this->usu_login = $usu_login;
    }

    public function setLoc_data_locacao($loc_data_locacao)
    {
        $this->loc_data_locacao = $loc_data_locacao;
    }

   
    public function setLoc_data_previsao_retorno($loc_data_previsao_retorno)
    {
        $this->loc_data_previsao_retorno = $loc_data_previsao_retorno;
    }

  
    public function setLiv_disponivel($loc_data_devolucao)
    {
        $this->liv_disponivel = $loc_data_devolucao;
    }

    
    public function setLoc_ativo($loc_ativa)
    {
        $this->loc_ativo = $loc_ativa;
    }

    

    public static function Listarlivros($titulo=null, $autor=null, $genero=null,$usuario=null) {
        $conexao = Database::connect();
    	  	
    	$sql = "SELECT lo.loc_codigo, ".
    	       "l.liv_codigo, ".
    	       "l.liv_titulo, ".
    	       "g.gen_descricao, ".
    	       "a.aut_nome, ".
    	       "l.liv_ativo, ".
    	       "lo.loc_data_locacao, ".
    	       "lo.loc_data_previsao_retorno, ".
    	       "lo.loc_data_devolucao, ".
    	       "lo.loc_ativa, ".
    	       "lo.usu_login ".
    	       "FROM livro as l, genero as g, autor as a, locacao as lo ".
    	       "WHERE l.liv_codigo=lo.liv_codigo AND l.gen_codigo=g.gen_codigo AND l.aut_codigo=a.aut_codigo";
    	
  	
    	if ($titulo)
            $sql.=" AND L.liv_titulo LIKE :liv_titulo";    	
    	if ($autor)
            $sql.=" AND L.aut_codigo = :aut_nome";    	
    	if ($genero)
            $sql.=" AND L.gen_codigo = :gen_descricao";  
    	if ($usuario)
    	    $sql.=" AND lo.usu_login = :usu_login";
    	
        $stm= $conexao->prepare($sql);
             
       
        
        if($titulo)
            $stm->bindValue(':liv_titulo', '%'.$titulo.'%');
        if($autor)
            $stm->bindValue(':aut_nome', $autor);
        if($genero)
            $stm->bindValue(':gen_descricao', $genero);   
        if($usuario)
            $stm->bindValue(':usu_login', $usuario); 
      
                       
            
        if (!$stm->execute()){
            return $stm->errorInfo();
        }

        $locacoes = array();
        while ($resultado= $stm->fetch(PDO::FETCH_ASSOC)){
            $locacoes[]= array("loc_codigo" => $resultado['loc_codigo'],
                               "liv_codigo" => $resultado['liv_codigo'],
                               "liv_ativo" => $resultado['liv_ativo'],
                               "liv_titulo" => $resultado['liv_titulo'],
                               "gen_descricao" => $resultado['gen_descricao'],
                               "aut_nome" => $resultado['aut_nome'],
                               "loc_data_locacao" => $resultado['loc_data_locacao'],  
                               "loc_data_previsao_retorno" => $resultado['loc_data_previsao_retorno'],
                               "loc_data_devolucao" => $resultado['loc_data_devolucao'],
                               "usu_login" => $resultado['usu_login'],
                               "loc_ativa" => $resultado['loc_ativa']);
        }
        return $locacoes;
    }
    
    public function locar()
    {
        $conexao = Database::connect();
        $stm = $conexao->prepare("INSERT INTO locacao (liv_codigo, usu_login, loc_data_locacao, loc_data_previsao_retorno, loc_ativa) ".
            "VALUES (:liv_codigo, :usu_login, :loc_data_locacao, :loc_data_previsao_retorno, :loc_ativa) ");
        $stm->bindValue(':liv_codigo', $this->getLiv_codigo());
        $stm->bindValue(':usu_login', $this->getUsu_login());
        $stm->bindValue(':loc_data_locacao', date("Y-m-d H:i:s"));        
        $date = strtotime(date("Y-m-d H:i:s", strtotime($this->getLoc_data_previsao_retorno())) . " +1 month");
        $date = date("Y-m-d H:i:s",$date);
        $stm->bindValue(':loc_data_previsao_retorno', $date);
        $stm->bindValue(':loc_ativa', 'S');
        if (!$stm->execute())
            return $stm->errorInfo();
            
            $stm = $conexao->prepare("UPDATE livro SET ".
                "liv_disponivel='N' ".
                "WHERE liv_codigo=:liv_codigo");
            $stm->bindValue(':liv_codigo', $this->getLiv_codigo());
            if (!$stm->execute())
                return $stm->errorInfo();
                
    }

        
    public function renovar($codigoloc){
        $conexao = Database::connect();
        $stm = $conexao->prepare("UPDATE locacao ".
            "SET loc_data_previsao_retorno=:loc_data_previsao_retorno ".
            "WHERE loc_codigo=:loc_codigo");
        $data = date("Y-m-d H:i:s");        
        $loc_data_previsao_retorno= strtotime(date("Y-m-d H:i:s", strtotime($data)) . " +1 week");
        $loc_data_previsao_retorno = date("Y-m-d H:i:s",$loc_data_previsao_retorno);
        $stm->bindValue(':loc_data_previsao_retorno', $loc_data_previsao_retorno);
        $stm->bindValue(':loc_codigo', $codigoloc);
        if (!$stm->execute())
            return $stm->errorInfo();         
        
    }

            
     public function Devolucao ($codigoloc,$codliv){
       
        $conexao = Database::connect();
        $stm = $conexao->prepare("UPDATE locacao as lo,livro as l ".
            "SET lo.loc_ativa='N',l.liv_disponivel='S', lo.loc_data_devolucao=:loc_data_devolucao ".
            "WHERE lo.loc_codigo=:loc_codigo AND l.liv_codigo=:liv_codigo ".
            "AND lo.loc_ativa='S' AND l.liv_disponivel='N'");
         $date = date("Y-m-d H:i:s");
         $stm->bindValue(':loc_codigo', $codigoloc);
         $stm->bindValue(':liv_codigo', $codliv);
         $stm->bindValue(':loc_data_devolucao', $date);
         
        
            if (!$stm->execute())
                return $stm->errorInfo();     
        

    }
  
}

