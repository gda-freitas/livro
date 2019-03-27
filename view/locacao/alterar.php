<?php
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
if($_SESSION['administrador'] != 'A'){
    header("Location: ..\livro\listar.php");
}
$mensagem= "";

$autores = Autor::listar(null,null,'S');
$generos = Genero::listar(null,null,'S');

if (isset($_POST['Salvar'])) {
    $liv_titulo= isset($_POST['liv_titulo'])?$_POST['liv_titulo']:null;
    $liv_autor= isset($_POST['liv_autor'])?$_POST['liv_autor']:null;
    $liv_genero= isset($_POST['liv_genero'])?$_POST['liv_genero']:null;
    $liv_isbn = isset($_POST['liv_isbn'])?$_POST['liv_isbn']:null;
    $liv_codigo= isset($_POST['liv_codigo'])?$_POST['liv_codigo']:null;
    
    $livro = new Livro();
    $livro->setLiv_codigo($liv_codigo);
    $livro->setLiv_ativo("S");
    $livro->setLiv_disponivel("S");
    $livro->setLiv_titulo($liv_titulo);
    $livro->setLiv_isbn($liv_isbn);
    $livro->setGen_codigo($liv_genero);
    $livro->setAut_codigo($liv_autor);
    
    $resultado = $livro->alterar();
    
    if (is_array($resultado))
        $mensagem= "Erro: ".$resultado[0].$resultado[2];
    else
        header('location: listar.php');
}

$codigo= isset($_GET['codigo'])?$_GET['codigo']:null;
$resultado= Livro::listar($codigo);

$liv_codigo= isset($resultado[0]['liv_codigo'])?$resultado[0]['liv_codigo']:null;
$liv_titulo= isset($resultado[0]['liv_titulo'])?$resultado[0]['liv_titulo']:null;
$liv_autor= isset($resultado[0]['liv_autor'])?$resultado[0]['liv_autor']:null;
$liv_genero= isset($resultado[0]['liv_genero'])?$resultado[0]['liv_genero']:null;
$liv_isbn = isset($resultado[0]['liv_isbn'])?$resultado[0]['liv_isbn']:null;
$liv_codigo= isset($resultado[0]['liv_codigo'])?$resultado[0]['liv_codigo']:null;

?>

<div>
	<div>
		<div><h3 class="font-weight-bold">Alterar</h3><hr /></div>
	
		<form method='POST'>
		
	    <input type='hidden' name='liv_codigo' id='liv_codigo' value='<?= $liv_codigo ?>'>
	   		  		
   		<div class="form-group row">
       		<div class="col-sm-1" align="right">
	            <label class="col-form-label" for="liv_titulo">Titulo:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input class="form-control" type='text' required="true" autofocus="true" placeholder="Titulo do Livro" name='liv_titulo' id='liv_titulo' value='<?= $liv_titulo ?>'>
	        </div>    
        </div>
        
        <div class="form-group row">
       		<div class="col-sm-1" align="right">
	            <label class="col-form-label" for="liv_isbn">ISBN:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input class="form-control" type='text' required="true" name='liv_isbn' id='liv_isbn' placeholder="ISBN do Livro" value='<?= $liv_isbn ?>'>
	        </div>    
        </div>
        
        <div class="form-group row">	
    		<div class="col-sm-1" align="right">
        		<label class="col-form-label" for="liv_autor" id='liv_autor'>Autor:</label>
        	</div>	
	    	<div class="col-sm-2">
        		<select name='liv_autor' class="form-control">
        			<?php foreach($autores as $autor): ?>
       					<option value='<?= $autor['aut_codigo'] ?>' <?php if($autor['aut_codigo'] == $liv_autor) ECHO 'SELECTED';?>><?= $autor['aut_nome'] ?></option>
    				<?php endforeach; ?>
        		</select>
        	</div>
		</div>	

        <div class="form-group row">
    		<div class="col-sm-1" align="right">
        		<label class="col-form-label" for="liv_genero" id='"liv_genero"'>Gênero:</label>
        	</div>	
	    	<div class="col-sm-2">
        		<select name='liv_genero' class="form-control">
        			<?php foreach($generos as $genero): ?>
       					<option value='<?= $genero['gen_codigo'] ?>' <?php if($genero['gen_codigo'] == $liv_genero) ECHO 'SELECTED';?>><?= $genero['gen_descricao'] ?></option>
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
