<?php 
require_once '..\..\model\Usuario.php';
require_once '..\..\database\Database.php';

$login= isset($_GET['login'])?$_GET['login']:null;
$resultado= Usuario::listar($login);
$resultado[0]['usu_login'];
if(isset($_GET['login']) && $_SESSION['administrador'] == 'U'){
    $resultado= Usuario::listar($login);
    if($resultado[0]['usu_login'] != $_SESSION['login'])
        header("Location: ..\livro\listar.php");
}
else if($_SESSION['administrador'] != 'A'){
    header("Location: ..\livro\listar.php");
}
?>

<div class="pos-f-t">
      <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
			<a class="nav-link navbar-brand text-white" href='listar.php'>Listar Usuários</a>
			<a class="nav-link navbar-brand text-white" href='incluir.php'>Incluir Usuário</a>
		</div>
      </div>
      <nav class="navbar navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-brand">Usuário</span>
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>
    </div>

