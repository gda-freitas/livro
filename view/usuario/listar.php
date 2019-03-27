<?php	
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
    
$usu_nome= isset($_POST['usu_nome'])?$_POST['usu_nome']:null;
$usu_ativo= isset($_POST['usu_ativo'])?$_POST['usu_ativo']:null;
$resultado= Usuario::listar(null, $usu_nome, $usu_ativo);

if(isset($_GET['desativar'])){
    Usuario::Desativar($_GET['codigo']);
    header("Location: listar.php");
}
if(isset($_GET['autorizar'])){
    Usuario::Autorizar($_GET['codigo']);
    header("Location: listar.php");
}

?>

<div>
	<div>
		<form method='POST'>
			<div><h3 class="font-weight-bold">Listar Usuários</h3><hr /></div>
        	<div class="form-group row">	
        		<div class="col-sm-1" align="right">
        			<label class="col-form-label" for="usu_nome">Usuário:</label>
        		</div>
        		<div class="col-sm-2">
        			<input type='text' name='usu_nome' id='usu_nome' placeholder="Nome do Usuario" class="form-control" value='<?= $usu_nome ?>'>
        		</div>
    		</div>		

    		<div class="form-group row">
        		<div class="col-sm-1" align="right">
	        		<label class="col-form-label" for="usu_ativo" id='usu_ativo'>Ativo:</label>
	        	</div>	
    	    	<div class="col-sm-2">
            		<select name='usu_ativo' class="form-control">
            			<option value='' <?php if ($usu_ativo=='') echo 'SELECTED'; ?>>Todos</option>
            			<option value='S' <?php if ($usu_ativo=='S') echo 'SELECTED'; ?>>Sim</option>
            			<option value='N' <?php if ($usu_ativo=='N') echo 'SELECTED'; ?>>Não</option>
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
        		<th>Login</th>
        		<th>Nome</th>        		
        		<th>E-mail</th>        		        		
        		<th>Privilegio</th>        		        		
        		<th style="width:60px">Ativo</th>        		
        		<th style="width:60px">Alterar</th>  
        		<th style="width:60px">Excluir</th> 
        		<th style="width:60px">Autorizar</th>        	
        	</tr>
        	</thead>
        	
        	<tbody>
        	<?php foreach($resultado as $chave): ?>
        	<tr>
        		<td><?= $chave["usu_login"] ?></td>
        		<td><?= $chave["usu_nome"] ?></td>
        		<td><?= $chave["usu_email"] ?></td>
        		<td><?= $chave["usu_administrador"]=='A'?'Administrador':'Usuario' ?></td>
        		<?php if($chave["usu_ativo"]=='P'){ ?>
        			<td>Pendente</td>
        		<?php }else{?>
        			<td><?= $chave["usu_ativo"]=='S'?'Sim':'Nao' ?></td>
        		<?php }?>
        		<td class="text-center"><a href='alterar.php?login=<?= $chave["usu_login"] ?>'><img src="../../img/edit.png" width="20" title="Alterar" /></a></td>
        		<?php if($chave["usu_login"]==$_SESSION['login']){ ?>        		
        		<td class="text-center"><a href='#'><img src="../../img/block.png" width="20" title="Indisponivel" /></a></td> 
        		<?php }else{?>
        		<td class="text-center"><a href='listar.php?desativar=true&codigo=<?= $chave["usu_login"] ?>'onclick="return confirm('Este Usuário será desativado. Confirmar?')" ><img src="../../img/excluir.png" width="20" title="Excluir" /></a></td>
        		<?php }?> 
        		<?php if($chave["usu_ativo"]=='P'){ ?>
        		<td class="text-center"><a href='listar.php?autorizar=true&codigo=<?= $chave["usu_login"] ?>'><img src="../../img/autorizar.png" width="20" title="Alterar" /></a></td>
        		<?php }else{?> 
        		<td class="text-center"><a href='#'><img src="../../img/block.png" width="20" title="Indisponivel" /></a></td> <?php }?>
        	</tr>
        	<?php endforeach; ?>
        	</tbody>	
        </table>

	</div>
</div>

<?php require_once '..\rodape_geral.php'; 
