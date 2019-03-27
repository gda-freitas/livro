<?php
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
$mensagem= "";

if (isset($_POST['Salvar'])) {
    $aut_nome= isset($_POST['aut_nome'])?$_POST['aut_nome']:null;
    $aut_codigo= isset($_POST['aut_codigo'])?$_POST['aut_codigo']:null;
    
    $autor = new Autor();
    $autor->setAut_nome($aut_nome);
    $autor->setAut_codigo($aut_codigo);
    
    $resultado = $autor->alterar();
    
    if (is_array($resultado))
        $mensagem= "Erro: ".$resultado[0].$resultado[2];
    else
        header('location: listar.php');
}

$codigo= isset($_GET['codigo'])?$_GET['codigo']:null;
$resultado= Autor::listar($codigo);

$aut_codigo= isset($resultado[0]['aut_codigo'])?$resultado[0]['aut_codigo']:null;
$aut_nome= isset($resultado[0]["aut_nome"])?$resultado[0]["aut_nome"]:null;

?>

<div>
	<div>
		<div><h3 class="font-weight-bold">Alterar Autor</h3><hr /></div>
	
		<form method='POST'>
		
	    <input type='hidden' name='aut_codigo' id='aut_codigo' value='<?= $aut_codigo ?>'>
	   		  		
   		<div class="form-group row">
       		<div class="col-sm-1" align="right">
	            <label class="col-form-label" for="aut_nome">Nome:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input class="form-control" required="true" autofocus="true" placeholder="Nome do Autor" type='text' name='aut_nome' id='aut_nome' value='<?= $aut_nome ?>'>
	        </div>    
        </div>

		<div>
			<?= $mensagem ?>
		</div>
	
		<hr>
		<div class="form-group row">
    		<div class="col-sm-1" align="right">
    			<button class="btn btn-primary mb-2" type='submit' name='Salvar' value='Salvar' >Salvar</button>
    		</div>
    		<div>
				<button class="btn btn-primary mb-2" type="button" onclick='javascript:location.href="listar.php";'>Cancelar</button>
			</div>
		</div>
		
		</form>

	</div>
</div>

<?php require_once '..\rodape_geral.php'; 
