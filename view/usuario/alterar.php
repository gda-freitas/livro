<?php
require_once '..\cabecalho_geral.php';
require_once 'cabecalho.php';
$mensagem= "";

if (isset($_POST['Salvar'])) {
    $usu_login = isset($_POST['usu_login']) ? $_POST['usu_login'] : null;
    $usu_nome = isset($_POST['usu_nome']) ? $_POST['usu_nome'] : null;
    $usu_email = isset($_POST['usu_email']) ? $_POST['usu_email'] : null;
    $usu_senha = isset($_POST['usu_senha']) ? $_POST['usu_senha'] : null;
    $usu_senha_conf = isset($_POST['usu_senha_conf']) ? $_POST['usu_senha_conf'] : null;
    $usu_administrador = isset($_POST['usu_administrador']) ? $_POST['usu_administrador'] : null;
    $usu_ativo = isset($_POST['usu_ativo']) ? $_POST['usu_ativo'] : null;
    
    if ($usu_senha != $usu_senha_conf) {
        $mensagem= "Erro: a senha não está igual a confirmação da senha.";
    } else {
        $usuario = new Usuario();
        $usuario->setUsu_login($usu_login);
        $usuario->setUsu_nome($usu_nome);
        $usuario->setUsu_email($usu_email);
        $usuario->setUsu_senha(password_hash($usu_senha, PASSWORD_BCRYPT));
        $usuario->setUsu_administrador($usu_administrador);
        $usuario->setUsu_ativo($usu_ativo);
        
        $resultado = $usuario->alterar();
        
        if (is_array($resultado))
            $mensagem= "Erro: ".$resultado[0].$resultado[2];
            else
                header('location: listar.php');
    }
}

$login= isset($_GET['login'])?$_GET['login']:null;
$resultado= Usuario::listar($login);

$usu_login= isset($resultado[0]['usu_login'])?$resultado[0]['usu_login']:null;
$usu_nome= isset($resultado[0]['usu_nome'])?$resultado[0]['usu_nome']:null;
$usu_email= isset($resultado[0]['usu_email'])?$resultado[0]['usu_email']:null;
$usu_administrador= isset($resultado[0]['usu_administrador'])?$resultado[0]['usu_administrador']:null;
$usu_ativo= isset($resultado[0]['usu_ativo'])?$resultado[0]['usu_ativo']:null;
$usu_senha= "";
$usu_senha_conf= "";

?>

<div>
	<div>
		<div><h3 class="font-weight-bold">Alterar Usuário</h3><hr /></div>
		<form method='POST'>
		
   		<div class="form-group row">
       		<div class="col-sm-1" align="right">
            	<label class="col-form-label" for="usu_login">Login:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input type='text' name='usu_login' id='usu_login' disabled class="form-control" value='<?= $usu_login ?>'>
	        </div>            
        </div>

   		<div class="form-group row">
       		<div class="col-sm-1" align="right">
	            <label class="col-form-label" for="usu_nome">Nome:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input type='text' name='usu_nome' id='usu_nome' class="form-control" value='<?= $usu_nome ?>'>
	        </div>    
        </div>

   		<div class="form-group row">
       		<div class="col-sm-1" align="right">
	            <label class="col-form-label" for="usu_email">E-mail:</label>
            </div>
  	    	<div class="col-sm-2">
	            <input type='email' name='usu_email' id='usu_email' class="form-control" value='<?= $usu_email ?>'>
	        </div>    
        </div>

   		<div class="form-group row">
       		<div class="col-sm-1" align="right">
				<label class="col-form-label" for="usu_senha">Senha:</label>
            </div>
  	    	<div class="col-sm-2">
				<input type='password' name='usu_senha' class="form-control" value='<?= $usu_senha ?>'>
			</div>
		</div>

   		<div class="form-group row">
       		<div class="col-sm-1" align="right">
				<label class="col-form-label" for="usu_senha_conf">Confirme a senha:</label>
            </div>
  	    	<div class="col-sm-2">
				<input type='password' name='usu_senha_conf' class="form-control" value='<?= $usu_senha ?>'>
			</div>
			<div class="text-warning">
				<?= $mensagem ?>
			</div>
		</div>
		
		<?php if($_SESSION['administrador'] == 'A'){?>		
		<div class="form-group row">
              <div class="col-sm-1" align="right">
              	<label class="col-form-label" for="usu_administrador" >Tipo Usuario:</label>
               </div>
              <div class="col-sm-2">
                <select name='usu_administrador' id='usu_administrador' class="form-control" <?php if ($usu_login==$_SESSION['login']){ ?> disabled <?php } ?>>
                  <option value='U' <?php if ($usu_administrador=='U') echo 'SELECTED'; ?>>Usuario</option>
                  <option value='A' <?php if ($usu_administrador=='A') echo 'SELECTED'; ?>>Administrador</option>
                </select>
          </div>
        </div> 
        
        <div class="form-group row">
          <div class="col-sm-1" align="right">
          	<label class="col-form-label" for="usu_ativo">Ativo:</label>
          </div>
          <div class="col-sm-2">
            <select name='usu_ativo' id='usu_ativo' class="form-control" <?php if ($usu_login==$_SESSION['login']){ ?> disabled <?php } ?>>
              <option value='S' <?php if ($usu_ativo=='S') echo 'SELECTED'; ?>>Sim</option>
              <option value='N' <?php if ($usu_ativo=='N') echo 'SELECTED'; ?>>Não</option>
            </select>
          </div>
        </div>  
		<?php }?>
		<hr>
		<div class="form-group row">
    		<div class="col-sm-1" align="right">
    			<button class="btn btn-primary mb-2" type='submit' name='Salvar' value='Salvar'>Salvar</button>
    		</div>
    		<div>
				<button class="btn btn-primary mb-2" type="button" onclick='javascript:location.href="listar.php";'>Cancelar</button>
			</div>
		</div>
		
		</form>

	</div>
</div>

<?php require_once '..\rodape_geral.php'; 
