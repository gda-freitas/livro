<?php 
class Usuario
{
    private $usu_login;
    private $usu_nome;
    private $usu_email;
    private $usu_senha;
    private $usu_administrador;
    private $usu_ativo;
    public function getUsu_login()
    {
        return $this->usu_login;
    }

    public function getUsu_nome()
    {
        return $this->usu_nome;
    }

    public function getUsu_email()
    {
        return $this->usu_email;
    }

    public function getUsu_senha()
    {
        return $this->usu_senha;
    }
    
    public function getUsu_administrador()
    {
        return $this->usu_administrador;
    }
    
    public function getUsu_ativo()
    {
        return $this->usu_ativo;
    }

    public function setUsu_login($usu_login)
    {
        $this->usu_login = $usu_login;
    }

    public function setUsu_nome($usu_nome)
    {
        $this->usu_nome = $usu_nome;
    }

    public function setUsu_email($usu_email)
    {
        $this->usu_email = $usu_email;
    }

    public function setUsu_senha($usu_senha)
    {
        $this->usu_senha = $usu_senha;
    }

    public function setUsu_administrador($usu_administrador)
    {
        $this->usu_administrador = $usu_administrador;
    }

    public function setUsu_ativo($usu_ativo)
    {
        $this->usu_ativo = $usu_ativo;
    }
    
    public function setUsu_data_atualizacao($usu_data_atualizacao)
    {
        $this->usu_data_atualizacao = $usu_data_atualizacao;
    }

    public function incluir()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("INSERT INTO usuario (usu_login, usu_nome, usu_email, usu_senha, usu_administrador, usu_ativo) ".
    						                 "VALUES (:usu_login,:usu_nome,:usu_email,:usu_senha,:usu_administrador,:usu_ativo) ");
    	$stm->bindValue(':usu_login', $this->getUsu_login());
		$stm->bindValue(':usu_nome', $this->getUsu_nome());
		$stm->bindValue(':usu_email', $this->getUsu_email());
		$stm->bindValue(':usu_senha', $this->getUsu_senha());
		$stm->bindValue(':usu_administrador', $this->getUsu_administrador());
		if($this->getUsu_ativo()===null){
		    $stm->bindValue(':usu_ativo', 'S');
		}else{
		    $stm->bindValue(':usu_ativo', $this->getUsu_ativo());	    
	    }
		if (!$stm->execute())
			return $stm->errorInfo();
    }

    public function alterar()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("UPDATE usuario SET ".
	                                    "usu_nome=:usu_nome, ". 
                                	    "usu_email=:usu_email, ".
                                	    "usu_senha=:usu_senha, ". 
    	                                "usu_administrador=:usu_administrador, ".
                                	    "usu_ativo=:usu_ativo ".
	                              "WHERE usu_login=:usu_login");
        $stm->bindValue(':usu_nome', $this->getUsu_nome());
        $stm->bindValue(':usu_email', $this->getUsu_email());
        $stm->bindValue(':usu_senha', $this->getUsu_senha());
        $stm->bindValue(':usu_administrador', $this->getUsu_administrador());
        $stm->bindValue(':usu_ativo', $this->getUsu_ativo());
        $stm->bindValue(':usu_login', $this->getUsu_login());
        if (!$stm->execute())
            return $stm->errorInfo();

    }

    public static function listar($login=null, $nome=null, $ativo=null) {
        $conexao = Database::connect();
    	$sql = "SELECT usu_login, ".
    				  "usu_nome, ".                   
                      "usu_email, ".
                      "usu_administrador, ".
                      "usu_ativo ".
                 "FROM usuario ";
        if ($login)
            $sql.="WHERE usu_login LIKE :usu_login ";
        else if ($nome && $ativo)
            $sql.="WHERE usu_ativo=:usu_ativo AND usu_nome LIKE :usu_nome ";
        else if ($nome)
            $sql.="WHERE usu_nome LIKE :usu_nome";
        else if ($ativo)
            $sql.="WHERE usu_ativo=:usu_ativo ";
            
        $stm= $conexao->prepare($sql);
                    
        if ($login)
            $stm->bindValue(':usu_login', $login);
        if ($nome)
            $stm->bindValue(':usu_nome', '%'.$nome.'%');
        if ($ativo)
            $stm->bindValue(':usu_ativo', $ativo);

        if (!$stm->execute())
            return $stm->errorInfo();  

        $usuarios = array();
        while ($resultado= $stm->fetch(PDO::FETCH_ASSOC)){
            $usuarios[]= array("usu_login" => $resultado['usu_login'],
                                "usu_nome" => $resultado['usu_nome'],
                               "usu_email" => $resultado['usu_email'],
                        "usu_administrador" => $resultado['usu_administrador'],
                               "usu_ativo" => $resultado['usu_ativo']);
        }
        return $usuarios;
    }
    
    public static function login($login=NULL, $senha=NULL) {
        $conexao = Database::connect();
        $sql = "SELECT usu_login, ".
            "usu_nome, ".
            "usu_senha, ".            
            "usu_administrador, ".
            "usu_ativo ".            
            "FROM usuario ".
            "WHERE usu_login LIKE :usu_login";
        
        $stm= $conexao->prepare($sql);        
        $stm->bindValue(':usu_login', $login);    
        
        if (!$stm->execute()){
            echo '<script language="javascript">alert("erro"); </script>';            
            return $stm->errorInfo();
        }
        
        $resultado= $stm->fetch(PDO::FETCH_ASSOC);
        $usuario = array();
        
        if($resultado != NULL){
            $usuario = array("usu_login" => $resultado['usu_login'],
                "usu_nome" => $resultado['usu_nome'],
                "usu_senha" => $resultado['usu_senha'],        
                "usu_ativo" => $resultado['usu_ativo'],                
                "usu_administrador" => $resultado['usu_administrador']);
        }
                
        return $usuario;
    }
    
    public function desativar($login)
    {
        $conexao = Database::connect();
        $stm = $conexao->prepare("UPDATE usuario SET ".
            "usu_ativo='N' ".
            "WHERE usu_login=:usu_login");
        $stm->bindValue(':usu_login', $login);
        if (!$stm->execute())
            return $stm->errorInfo();
            
    }
    
    public function autorizar($login)
    {
        $conexao = Database::connect();
        $stm = $conexao->prepare("UPDATE usuario SET ".
            "usu_ativo='S' ".
            "WHERE usu_login=:usu_login");
        $stm->bindValue(':usu_login', $login);
        if (!$stm->execute())
            return $stm->errorInfo();
            
    }
}
