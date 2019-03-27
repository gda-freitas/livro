<?php
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
$mensagem= "";

if (isset($_POST['Salvar'])) {
    $gen_ativo = isset($_POST['gen_ativo']) ? $_POST['gen_ativo'] : null;
    $gen_descricao = isset($_POST['gen_descricao']) ? $_POST['gen_descricao'] : null;
    $gen_codigo= isset($_POST['gen_codigo'])?$_POST['gen_codigo']:null;
    
    $genero = new Genero();
    $genero->setGen_descricao($gen_descricao);
    $genero->setGen_ativo($gen_ativo);
    $genero->setGen_codigo($gen_codigo);
    
    $resultado = $genero->alterar();
    
    if (is_array($resultado))
        $mensagem= "Erro: ".$resultado[0].$resultado[2];
    else
        header('location: listar.php');
}

$codigo= isset($_GET['codigo'])?$_GET['codigo']:null;
$resultado= Genero::listar($codigo);

$gen_codigo= isset($resultado[0]['gen_codigo'])?$resultado[0]['gen_codigo']:null;
$gen_descricao= isset($resultado[0]['gen_descricao'])?$resultado[0]['gen_descricao']:null;
$gen_ativo= isset($resultado[0]["gen_ativo"])?$resultado[0]["gen_ativo"]:null;

?>

<div>
	<div>
		<div><h3 class="font-weight-bold">Alterar Gênero</h3><hr /></div>
	
		<form method='POST'>
		
	    <input type='hidden' name='gen_codigo' id='gen_codigo' value='<?= $gen_codigo ?>'>
	   		  		
   		<div class="form-group row">
       		<div class="col-sm-1" align="right">
	            <label class="col-form-label" for="gen_descricao">Descrição:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input class="form-control" required="true" autofocus="true" placeholder="Descrição do Gênero" type='text' name='gen_descricao' id='gen_descricao' value='<?= $gen_descricao ?>'>
	        </div>    
        </div>

        <div class="form-group row">
              <div class="col-sm-1" align="right">
              	<label class="col-form-label" for="gen_ativo">Ativo:</label>
              </div>
              <div  class="col-sm-2">
                <select class="form-control" name='gen_ativo' id='gen_ativo' >
                  <option value='S' <?php if ($gen_ativo=='S') echo 'SELECTED'; ?>>Sim</option>
                  <option value='N' <?php if ($gen_ativo=='N') echo 'SELECTED'; ?>>Não</option>
                </select>
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
