<?php	
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
$mensagem= "";



$codigo= isset($_GET['codigo'])?$_GET['codigo']:null;
$resultado= Livro::listar($codigo);

$autores = Autor::listar(null,null,'S');
$generos = Genero::listar(null,null,'S');
$usuarios = Usuario::listar(null,null,'S');

$liv_codigo= isset($resultado[0]['liv_codigo'])?$resultado[0]['liv_codigo']:null;
$liv_titulo= isset($resultado[0]['liv_titulo'])?$resultado[0]['liv_titulo']:null;
$liv_autor= isset($resultado[0]['aut_nome'])?$resultado[0]['aut_nome']:null;
$liv_genero= isset($resultado[0]['gen_descricao'])?$resultado[0]['gen_descricao']:null;

$usu_login= isset($_POST['usu_login'])?$_POST['usu_login']:null;
$loc_data_locacao = date("d/m/Y");
$data = date("Y-m-d");

$loc_data_previsao_retorno= strtotime(date("Y-m-d", strtotime($data)) . " +1 day");
$loc_data_previsao_retorno = date("Y-m-d",$loc_data_previsao_retorno);

$loc_data_previsao_retorno_max = strtotime(date("Y-m-d", strtotime($data)) . " +1 month");
$loc_data_previsao_retorno_max = date("Y-m-d",$loc_data_previsao_retorno_max);




if (isset($_POST['Salvar'])) {       
    $locacao = new Locacao();
    $locacao->setLiv_codigo($liv_codigo);
    $locacao->setUsu_login($_POST['usu_login']);
    $locacao->setLoc_data_previsao_retorno($_POST['loc_data_previsao_retorno']);
    $resultado = $locacao->locar();
    
    if (is_array($resultado))
        $mensagem= "Erro: ".$resultado[0].$resultado[2];
    else
        header('location: listar.php');    
}

?>

<div>
	<div>
		<div><h3 class="font-weight-bold">Incluir Locação</h3><hr /></div>
		<form method='POST'>
			
		<div class="form-group row">
       		<div class="col-sm-1" align="right">
	            <label class="col-form-label" for="codigo">Codigo Livro:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input class="form-control" type='text' required="true" autofocus="true" placeholder="Codigo do Livro" name='liv_codigo' id='liv_codigo' value='<?= $liv_codigo ?>' readonly>
	        </div>    
        </div>
			
   		<div class="form-group row">
       		<div class="col-sm-1" align="right">
	            <label class="col-form-label" for="liv_titulo">Titulo:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input class="form-control" type='text' required="true" autofocus="true" placeholder="Titulo do Livro" name='liv_titulo' id='liv_titulo' value='<?= $liv_titulo ?>' readonly>
	        </div>    
	    </div>
        
         <div class="form-group row">
    		<div class="col-sm-1" align="right">
        		<label class="col-form-label" for="liv_genero" id='"liv_genero"'>Gênero:</label>
        	</div>	
	    	<div class="col-sm-2">
        		<input class="form-control" type='text' required="true" autofocus="true" placeholder="Genero" name='liv_genero' id='liv_genero' value='<?= $liv_genero?>' readonly>
        		
        		
        	</div>	
    	</div> 
        
        <div class="form-group row">	
    		<div class="col-sm-1" align="right">
        		<label class="col-form-label" for="liv_autor" id='liv_autor'>Autor:</label>
        	</div>	
	    	<div class="col-sm-2" align="right">
	    		
	    		<input class="form-control" type='text' required="true" autofocus="true" placeholder="Autor" name='liv_autor' id='liv_autor' value='<?= $liv_autor ?>' readonly>
        		
        	</div>
		</div>	

        <div class="form-group row">
    		<div class="col-sm-1" align="right">
        		<label class="col-form-label" for="liv_genero" id='"loc_data_locacao"'>Data Locação:</label>
        	</div>	
	    	<div class="col-sm-2">
        		<input class="form-control" type='text' required="true" name='loc_data_locacao' id='loc_data_locacao' placeholder="Data Locacao" value='<?= $loc_data_locacao?>' readonly>
        		
        	</div>	
    	</div> 
    	<div class="form-group row">
       		<div class="col-sm-1" align="right">
	            <label class="col-form-label" for="loc_data_previsao_retorno">Data de Previsão de Retorno:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input class="form-control" type='date' required="true" autofocus="true" placeholder="Data de Previsão de Retorno" name='loc_data_previsao_retorno' id='loc_data_previsao_retorno' min='<?= $loc_data_previsao_retorno ?>' max='<?= $loc_data_previsao_retorno_max ?>' value='<?= $loc_data_previsao_retorno ?>' required>
	        </div>    
        </div>
        
         <div class="form-group row">
    		<div class="col-sm-1" align="right">
        		<label class="col-form-label" for="usu_login" id='"usu_login"'>Usuário:</label>
        	</div>	
	    	<div class="col-sm-2">
        		<select name='usu_login' class="form-control">
        			<?php foreach($usuarios as $usuario): ?>
       					<option value='<?= $usuario['usu_login'] ?>' <?php ECHO 'SELECTED';?>><?= $usuario['usu_login'] ?></option>
    				<?php endforeach; ?>
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
