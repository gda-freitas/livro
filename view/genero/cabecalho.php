<?php 
require_once '..\..\model\Genero.php';
require_once '..\..\database\Database.php';
if($_SESSION['administrador'] != 'A'){
    header("Location: ..\livro\listar.php");
}
?>

<div class="pos-f-t">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
		<a class="nav-link navbar-brand text-white" href='listar.php'>Listar Gêneros</a>
		<a class="nav-link navbar-brand text-white" href='incluir.php'>Incluir novo Gênero</a>
	</div>
  </div>
  <nav class="navbar navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-brand">Gênero</span>
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
</div>