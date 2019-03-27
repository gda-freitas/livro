<!DOCTYPE html>
<?php	
session_start();
if(!isset($_SESSION) || !isset($_SESSION['login']))
{
    session_destroy();    
    header('location: http://localhost/livro/view/index.php');
}

$timeout = 1200; //20 minutos
if(isset($_SESSION['timeout'])) {
    $duracao = time() - (int) $_SESSION['timeout'];    
    if($duracao > $timeout) {
        $usu_login = $_SESSION['login'];
        session_destroy();
        header('location: http://localhost/livro/view/index.php?user='.$usu_login.'&men=2');
    }   
} $_SESSION['timeout'] = time();

    

?>
<html lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<script src="../../js/jquery-2.1.3.min.js"></script> 
	<script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/popper.min.js"></script>
	<script src="../../js/bootstrap.bundle.min.js"></script>	
	
	<title>Blibioteca</title>
</head>
<body>
    
	<div>		 
		<div>
			<div class="navbar navbar-expand-lg navbar-dark bg-primary">
    		    <div>    		
    		    	<h1>Gerenciamento Biblioteca</h1>    		
    		    	<?php if($_SESSION['administrador'] == 'A'){?>
	    		    	<a class="nav-item nav-link navbar-brand" href="../livro/listar.php">Livros</a>    		    	
        		    	<a class="nav-item nav-link navbar-brand" href="../usuario/listar.php">Usuários</a>
        				<a class="nav-item nav-link navbar-brand" href="../genero/listar.php">Gêneros</a>
        				<a class="nav-item nav-link navbar-brand" href="../autor/listar.php">Autores</a>
    		    	<?php }?>
    				
    		    </div>
    		    <ul class="nav navbar-nav ml-auto justify-content-end">
					<li class="nav-item dropleft">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opções</a>
						<div class="dropdown-menu perfil" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="../usuario/alterar.php?login=<?= $_SESSION['login'] ?>">Editar Perfil</a>
							<a class="dropdown-item" href="../login.php?logout=true">Sair</a>
						</div>
					</li>
				</ul>
    		    
			</div>
		</div>
	</div>	
</body>
</html>