<?php 
require_once '..\..\model\Usuario.php';
require_once '..\..\model\Autor.php';
require_once '..\..\database\Database.php';
if($_SESSION['administrador'] != 'A'){
    header("Location: ..\livro\listar.php");
}
?>
<div class="pos-f-t">
      <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
			<a class="nav-link navbar-brand text-white" href='listar.php'>Listar Autores</a>
			<a class="nav-link navbar-brand text-white" href='incluir.php'>Incluir Autor</a>
		</div>
      </div>
      <nav class="navbar navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-brand">Autor</span>
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>
    </div>