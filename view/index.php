<?php	
//require_once 'cabecalho_geral.php';
require_once '..\model\Usuario.php';
$usu_login=NULL;
$mensage=NULL;
if(isset($_GET["user"])){
    $usu_login= $_GET["user"];    
}
if(isset($_GET["men"])){
    if( $_GET["men"] == 0){
        $mensage = "Pedido criado com sucesso, aguarde a liberação.";
    }if( $_GET["men"] == 1){
        $mensage = "Usuario/Senha incorretos.";
    }if( $_GET["men"] == 2){
        $mensage = "Sessão expirada, entre novamente.";     
    }if( $_GET["men"] == 3){
        $mensage = "Usuário desativado!";   
    }if( $_GET["men"] == 4){
        $mensage = "Autorização de acesso pendente, aguarde a liberação.";
    }
}

?>
<html lang="pt-br">
	<head>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    	<script src="../js/jquery-2.1.3.min.js"></script> 
    	<script src="../js/bootstrap.min.js"></script>
    	<script src="../js/popper.min.js"></script>
    	<script src="../js/bootstrap.bundle.min.js"></script>    
        <meta charset="utf-8">
	</head>
	<body class="text-center">
		<div>
    		<h1>Gerenciamento Biblioteca</h1>     
    		<div>
    			<div class="navbar navbar-expand-lg navbar-dark bg-primary">
        		    <div>
        		    </div>
    			</div>
    		</div>
    	</div>	    
		<form action='login.php' method='POST'>            
            <h1 class="h3 mb-3 font-weight-normal">Bem-Vindo</h1>        	
            <div class="mx-auto" style="width: 300px;">
            	<input type="text" name="usu_login" id="usu_login" class="form-control" placeholder="Usuario" required="true" autofocus="true" value='<?= $usu_login ?>'>
            </div>
            <div class="mx-auto" style="width: 300px;">
            	<input type="password" name="usu_senha" id="usu_senha" class="form-control" placeholder="Senha" required="true">
            </div>            
            <?php
            if(isset($_GET["men"])){
            ?>            
				<div <?php if($_GET["men"]==0){?>class="text-success"<?php }else{?>class="text-warning"<?php }?>> <?= $mensage ?></div>         
			<?php }?>
			
            <div class="mx-auto" style="width: 300px;">
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Entrar</button>
            </div>
         	<a>Não possui uma conta? Crie-a</a><a href="register.php"> aqui</a>
		</form> 
<?php require_once 'rodape_geral.php';?>
