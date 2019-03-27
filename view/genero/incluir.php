<?php	
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
$mensagem= "";

$gen_descricao = isset($_POST['gen_descricao']) ? $_POST['gen_descricao'] : null;

if (isset($_POST['Salvar'])) {       
    $genero = new Genero();
    $genero->setGen_descricao($gen_descricao);
    $resultado = $genero->incluir();
    
    if (is_array($resultado))
        $mensagem= "Erro: ".$resultado[0].$resultado[2];
    else
        header('location: listar.php');    
}

?>

<div>
	<div>
		<div><h3 class="font-weight-bold">Incluir novo Gênero</h3><hr /></div>
		<form method='POST'>		
   		<div class="form-group row">
       		<div class="col-sm-1" align="right">
	            <label class="col-form-label" for="gen_descricao">Descrição:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input required="true" autofocus="true" placeholder="Descrição do Gênero" class="form-control" type='text' name='gen_descricao' id='gen_descricao' value='<?= $gen_descricao ?>'>
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
