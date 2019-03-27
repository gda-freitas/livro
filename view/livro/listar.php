<?php	
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
    
$liv_titulo= isset($_POST['liv_nome'])?$_POST['liv_nome']:null;
$liv_autor= isset($_POST['liv_autor'])?$_POST['liv_autor']:null;
$liv_genero= isset($_POST['liv_genero'])?$_POST['liv_genero']:null;

if(isset($_GET['desativar'])){
    Livro::Desativar($_GET['codigo']);
    header("Location: listar.php");
}
if(isset($_GET['locar'])){
    Livro::Locar($_GET['codigo'], $_GET['usuario']);
    header("Location: listar.php");
}

$autores = Autor::listar();
$generos = Genero::listar();

if($_SESSION['administrador'] == 'U'){
    $resultado= Livro::listar(null, $liv_titulo, $liv_autor, $liv_genero, 'S');
}else{
    $resultado= Livro::listar(null, $liv_titulo, $liv_autor, $liv_genero);
}
//echo 'alert("livros'.count($resultado).'");';

?>
<div>
	<div>
		<form method='POST'>
			<div><h3 class="font-weight-bold">Listar Livros</h3><hr /></div>
			
        	<div class="form-group row">	
        		<div class="col-sm-1" align="right">
        			<label class="col-form-label" for="liv_nome">Titulo:</label>
        		</div>
        		<div class="col-sm-2">
        			<input type='text' name='liv_nome' id='liv_nome' class="form-control" placeholder="Titulo do Livro" value='<?= $liv_titulo ?>'>
        		</div>
    		</div>	
    			
			<div class="form-group row">	
        		<div class="col-sm-1" align="right">
	        		<label class="col-form-label" for="liv_autor" id='liv_autor'>Autor:</label>
	        	</div>	
    	    	<div class="col-sm-2">
            		<select name='liv_autor' class="form-control">
            		        <option value=''>Todos</option>
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
            		        <option value=''>Todos</option>
            			<?php foreach($generos as $genero): ?>
           					<option value='<?= $genero['gen_codigo'] ?>' <?php if($genero['gen_codigo'] == $liv_genero) ECHO 'SELECTED';?>><?= $genero['gen_descricao'] ?></option>
        				<?php endforeach; ?>
            		</select>
            	</div>
        		<div class="col-sm-2">
        			<button  type='submit' class="btn btn-primary mb-2" name='Pesquisar' value='Pesquisar'>Pesquisar</button>
        		</div>
    		</div>
		</form>

        <table class="table table-striped table-bordered table-hover">
        	<thead class="thead-dark">
        	<tr>
        		<th style="width:130px">Codigo</th> 
        		<th>Titulo</th>        		
        		<th>Gênero</th>        		
        		<th>Autor</th>
        		<th>Data de Liberação</th>
        		<th style="width:60px">Ativo</th>
				<?php if($_SESSION['administrador'] == 'A'){?>  		
        		<th style="width:60px">Alterar</th>
        		<th style="width:60px">Excluir</th>        		
        		<?php }?>        		     		
        		<th style="width:60px">Locar</th>
        	</tr>
        	</thead>
        	
        	<tbody>
        	<?php foreach($resultado as $chave): ?>
        	<tr>
        		<td><?= $chave["liv_codigo"] ?></td>
        		<td><?= $chave["liv_titulo"] ?></td>
        		<td><?= $chave["gen_descricao"] ?></td>
        		<td><?= $chave["aut_nome"] ?></td>
        		<?php if($chave["liv_disponivel"]=='N'){?>
				<td><?= date('d/m/Y', strtotime($chave["loc_data_previsao_retorno"])) ?></td>
    			<?php }else{?> <td>Disponivel</td> <?php }?>
    			<td><?= $chave["liv_ativo"]=='S'?'Sim':'Nao' ?></td>
        		<?php if($_SESSION['administrador'] == 'A'){?>        		
            		
            		<td class="text-center"><a href='alterar.php?codigo=<?= $chave["liv_codigo"] ?>'><img src="../../img/edit.png" width="20" title="Alterar" /></a></td>
            		<td class="text-center"><a href='listar.php?desativar=true&codigo=<?= $chave["liv_codigo"] ?>'onclick="return confirm('Este Livro será desativado. Confirmar?')" ><img src="../../img/excluir.png" width="20" title="Excluir" /></a></td>        		
        		<?php } if($chave["liv_disponivel"]=='S'){?>    
        					<td class="text-center"><a href='../locacao/incluir.php?codigo=<?= $chave["liv_codigo"] ?>'><img src="../../img/locar.png" width="20" title="Locar" /></a></td>
    			<?php }else{?>        				
    						<td class="text-center"><a href='#'><img src="../../img/block.png" width="20" title="Indisponivel" /></a></td>        				
        		<?php }?>
        	</tr>
        	<?php endforeach; ?>
        	</tbody>	
        </table>

	</div>
</div>

<?php require_once '..\rodape_geral.php'; 
