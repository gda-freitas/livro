<?php	
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
    
$gen_descricao= isset($_POST['gen_descricao'])?$_POST['gen_descricao']:null;
$gen_ativo= isset($_POST['gen_ativo'])?$_POST['gen_ativo']:null;
$resultado= Genero::listar(null, $gen_descricao, $gen_ativo);

if(isset($_GET['desativar'])){
    Genero::Desativar($_GET['codigo']);
    header("Location: listar.php");
}
?>

<div>
	<div>
		<form method='POST'>
			<div><h3 class="font-weight-bold">Listar Gêneros</h3><hr /></div>
			
        	<div class="form-group row">	
        		<div class="col-sm-1" align="right">
        			<label class="col-form-label" for="gen_descricao">Descrição:</label>
        		</div>
        		<div class="col-sm-2">
        			<input type='text' name='gen_descricao' id='gen_descricao' class="form-control" placeholder="Descrição do Gênero" value='<?= $gen_descricao ?>'>
        		</div>
    		</div>		

    		<div class="form-group row">
        		<div class="col-sm-1" align="right">
	        		<label class="col-form-label" for="gen_ativo" id='gen_ativo'>Ativo:</label>
	        	</div>	
    	    	<div class="col-sm-2">
            		<select name='gen_ativo' class="form-control">
            			<option value='' <?php if ($gen_ativo=='') echo 'SELECTED'; ?>>Todos</option>
            			<option value='S' <?php if ($gen_ativo=='S') echo 'SELECTED'; ?>>Sim</option>
            			<option value='N' <?php if ($gen_ativo=='N') echo 'SELECTED'; ?>>Não</option>
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
        		<th>Descrição</th>        		
        		<th style="width:60px">Ativo</th>        		
        		<th style="width:60px">Alterar</th>
        		<th style="width:60px">Excluir</th>       
        	</tr>
        	</thead>
        	
        	<tbody>
        	<?php foreach($resultado as $chave): ?>
        	<tr>
        		<td><?= $chave["gen_codigo"] ?></td>
        		<td><?= $chave["gen_descricao"] ?></td>
        		<td><?= $chave["gen_ativo"]=='S'?'Sim':'Nao' ?></td>
        		<td class="text-center"><a href='alterar.php?codigo=<?= $chave["gen_codigo"] ?>'><img src="../../img/edit.png" width="20" title="Alterar" /></a></td>
        		<td class="text-center"><a href='listar.php?desativar=true&codigo=<?= $chave["gen_codigo"] ?>'onclick="return confirm('Este Gênero será desativado. Confirmar?')" ><img src="../../img/excluir.png" width="20" title="Excluir" /></a></td>        		
        	</tr>
        	<?php endforeach; ?>
        	</tbody>	
        </table>

	</div>
</div>

<?php require_once '..\rodape_geral.php'; 
