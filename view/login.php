<?php
//require_once 'cabecalho_geral.php';
require_once '..\model\Usuario.php';
require_once '..\database\Database.php';

if(isset($_GET["logout"])){
    session_start();
    unset($_SESSION['login']);
    unset($_SESSION['nome']);
    unset($_SESSION['administrador']);
    unset($_SESSION['timeout']);
    session_destroy();
    header("Location: index.php");
}

session_start();
$usu_login= isset($_POST['usu_login'])?$_POST['usu_login']:null;
$usu_senha= isset($_POST['usu_senha'])?$_POST['usu_senha']:null;
$resultado= Usuario::login($usu_login, $usu_senha);

if(count($resultado) == 0 && !isset($_GET["logout"])){
    unset($_SESSION['login']);
    unset($_SESSION['nome']);
    unset($_SESSION['administrador']);
    unset($_SESSION['timeout']);
    session_destroy();
    header("Location: index.php?user=".$usu_login."&men=1");
}
else if($resultado["usu_ativo"]!='S'){
    unset($_SESSION['login']);
    unset($_SESSION['nome']);
    unset($_SESSION['administrador']);
    unset($_SESSION['timeout']);
    session_destroy();
    if($resultado["usu_ativo"]=='N')
        header("Location: index.php?user=".$usu_login."&men=3");
    else if($resultado["usu_ativo"]=='P')
        header("Location: index.php?user=".$usu_login."&men=4");
}
else if(!password_verify($usu_senha, $resultado["usu_senha"])){
    unset($_SESSION['login']);
    unset($_SESSION['nome']);
    unset($_SESSION['administrador']);
    unset($_SESSION['timeout']);
    session_destroy();
    header("Location: index.php?user=".$usu_login."&men=1");
}
else{    
    $_SESSION['login'] = $resultado["usu_login"];
    $_SESSION['nome'] = $resultado["usu_nome"];
    $_SESSION['administrador'] = $resultado["usu_administrador"];
    $_SESSION['timeout'] = time();
    header("Location: livro\listar.php");
}

?>