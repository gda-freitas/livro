<?php	
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
    
$aut_nome= isset($_POST['aut_nome'])?$_POST['aut_nome']:null;
$aut_ativo= isset($_POST['aut_ativo'])?$_POST['aut_ativo']:null;
$resultado= Autor::listar(null, $aut_nome, $aut_ativo);

?>

<div>
	<div>
		<form method='POST'>
			<div><h3 class="font-weight-bold">Listar Autores</h3><hr /></div>
			
        	<div class="form-group row">	
        		<div class="col-sm-1" align="right">
        			<label class="col-form-label" for="aut_nome">Autor:</label>
        		</div>
        		<div class="col-sm-2">
        			<input type='text' name='aut_nome' id='aut_nome' class="form-control" placeholder="Nome do Autor" value='<?= $aut_nome ?>'>
        		</div>
    		</div>		

    		<div class="form-group row">
        		<div class="col-sm-1" align="right">
	        		<label class="col-form-label" for="aut_ativo" id='aut_ativo'>Ativo:</label>
	        	</div>	
    	    	<div class="col-sm-2">
            		<select name='aut_ativo' class="form-control">
            			<option value='' <?php if ($aut_ativo=='') echo 'SELECTED'; ?>>Todos</option>
            			<option value='S' <?php if ($aut_ativo=='S') echo 'SELECTED'; ?>>Sim</option>
            			<option value='N' <?php if ($aut_ativo=='N') echo 'SELECTED'; ?>>Não</option>
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
        		<th>Nome</th>        		
        		<th style="width:60px">Ativo</th>        		
        		<th style="width:60px">Alterar</th>
        	</tr>
        	</thead>
        	
        	<tbody>
        	<?php foreach($resultado as $chave): ?>
        	<tr>
        		<td><?= $chave["aut_codigo"] ?></td>
        		<td><?= $chave["aut_nome"] ?></td>
        		<td><?= $chave["aut_ativo"]=='S'?'Sim':'Nao' ?></td>
        		<td class="text-center"><a href='alterar.php?codigo=<?= $chave["aut_codigo"] ?>'><img src="../../img/edit.png" width="20" title="Alterar" /></a></td>
        	</tr>
        	<?php endforeach; ?>
        	</tbody>	
        </table>

	</div>
</div>

<?php require_once '..\rodape_geral.php'; 
