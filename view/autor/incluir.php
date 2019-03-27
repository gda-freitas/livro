<?php	
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
$mensagem= "";

$aut_nome = isset($_POST['aut_nome']) ? $_POST['aut_nome'] : null;

if (isset($_POST['Salvar'])) {       
    $autor = new Autor();
    $autor->setAut_nome($aut_nome);
    $resultado = $autor->incluir();
    
    if (is_array($resultado))
        $mensagem= "Erro: ".$resultado[0].$resultado[2];
    else
        header('location: listar.php');    
}

?>

<div>
	<div>
		<div><h3 class="font-weight-bold">Incluir novo Autor</h3><hr /></div>
		<form method='POST'>		
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
