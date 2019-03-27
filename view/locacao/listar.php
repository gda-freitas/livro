<?php	
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';

//$codigoloc=isset($_POST['loc_codigo'])?$_POST['loc_codigo']:null;
//$codigoliv=isset($_POST['liv_codigo'])?$_POST['liv_codigo']:null;

$liv_titulo= isset($_POST['liv_nome'])?$_POST['liv_nome']:null;
$liv_autor= isset($_POST['liv_autor'])?$_POST['liv_autor']:null;
$liv_genero= isset($_POST['liv_genero'])?$_POST['liv_genero']:null;
$usuario = isset($_POST['usu_login'])?$_POST['usu_login']:null;


if(isset($_GET['devolucao'])){
    Locacao::Devolucao($_GET['codigoloc'], $_GET['codliv']);
    header("Location: listar.php");
}
if(isset($_GET['renovar'])){
    Locacao::Renovar($_GET['codigoloc']);
    header("Location: listar.php");
}
//if(isset($_POST['Imprimir'])){
//    header("Location: ../pdf/gerar_pdf.php");
//}
$autores = Autor::listar();
$generos = Genero::listar();
if($_SESSION['administrador'] == 'U'){
        		 $usuario=$_SESSION['login'];
}
else{
        		$usuario=null;
}


$resultado= Locacao::listarLivros($liv_titulo, $liv_autor, $liv_genero,$usuario);

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
            	
        		<div class="col-sm-2">
        			<a href="..\pdf\gerar_pdf.php" target='_blank'  type='submit' action="..\pdf\gerar_pdf.php" class="btn btn-primary mb-2" name='Relatório' value='Relatorio' href="..\pdf\gerar_pdf.php">Relatório</a>
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
        		<th style="width:130px">Codigo Locação</th> 
        		<th>Codigo Livro</th>    
        		<th>Titulo</th>        		
        		<th>Gênero</th>        		
        		<th>Autor</th>
        		<th>Data de Locação</th>
        		<th>Data de Previsão de Retorno</th>
        		<th>Data de Devolução</th>
        		<th>Usuario</th>
        		<?php if($_SESSION['administrador'] == 'A'){?>      		
        		      		<th style="width:60px">Locado</th>
        		      		<th style="width:60px">Liberar</th>
        		<?php }?>        		     		
        		<?php if($_SESSION['administrador'] == 'U'){?>
        					<th style="width:60px">Renovar</th>
        		<?php }?>
        	</tr>
        	</thead>
        	
        	<tbody>
        	<?php foreach($resultado as $chave): ?>
        	<tr>
        		<td><?= $chave["loc_codigo"] ?></td>
        		<td><?= $chave["liv_codigo"] ?></td>        		
        		<td><?= $chave["liv_titulo"] ?></td>
        		<td><?= $chave["gen_descricao"] ?></td>
        		<td><?= $chave["aut_nome"] ?></td>
        		
        		<td><?= date('d/m/Y', strtotime($chave["loc_data_locacao"])) ?></td>
				<td><?= date('d/m/Y', strtotime($chave["loc_data_previsao_retorno"])) ?></td>
				<?php if($chave["loc_ativa"]=='S'){ ?>
				<td><?php echo 'Não entregue';?></td>
				<?php }else{?>
				<td><?= date('d/m/Y', strtotime($chave["loc_data_devolucao"])) ?></td>
				<?php }?>
				<td><?= $chave["usu_login"]?></td> 
    			<?php if($_SESSION['administrador'] == 'A'){?> 
    				    		
            		<?php if($chave["loc_ativa"]=='S'){ ?>
            		<td class="text-center"><a href='#'><img src="../../img/block.png" width="20" title="Indisponivel" /></a></td>
   					<td class="text-center"><a href='listar.php?devolucao=true&codigoloc=<?=$chave["loc_codigo"]?>&codliv=<?=$chave["liv_codigo"] ?>'onclick="return confirm('Deseja devolver este livro?')" ><img src="../../img/locar.png" width="20" title="devolucao" /></a></td>            		      		
        		<?php }else{?>    
					
					
					<td class="text-center"><a href='#' onclick="return confirm('Deseja devolver este livro?')" ><img src="../../img/locar.png" width="20" title="devolucao" /></a></td>
					<td class="text-center"><a href='#'><img src="../../img/block.png" width="20" title="Indisponivel" /></a></td>   			
        			<?php }?>
        		
        		<?php }else{?>
        			<td class="text-center"><a href='listar.php?renovar=true&codigoloc=<?=$chave["loc_codigo"]?>'onclick="return confirm('Deseja renovar este livro?')" ><img src="../../img/locar.png" width="20" title="renovar" /></a></td>            		      		
        		<?php }?>  
        		        		
        	</tr>
        	<?php endforeach; ?>
        	</tbody>	
        </table>
	</div>
</div>

<?php require_once '..\rodape_geral.php'; 
