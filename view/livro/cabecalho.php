<?php 
require_once '..\..\model\Usuario.php';
require_once '..\..\model\Livro.php';
require_once '..\..\model\Genero.php';
require_once '..\..\model\Autor.php';
require_once '..\..\model\Locacao.php';
require_once '..\..\database\Database.php';
require_once "../../fpdf/fpdf.php";

?>
<div class="pos-f-t">
      <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
			<a class="nav-link navbar-brand text-white" href='listar.php'>Listar Livros</a>
			<?php if($_SESSION['administrador']=='A'){?>
			<a class="nav-link navbar-brand text-white" href='incluir.php'>Incluir novo Livro</a>
					
			<?php }?>
			<a class="nav-link navbar-brand text-white" href='..\locacao\listar.php'>Locações</a>	
		</div>
      </div>
      <nav class="navbar navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-brand">Livros</span>
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>
    </div>