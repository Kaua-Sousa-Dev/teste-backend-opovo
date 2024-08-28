<?php
session_start();
require 'connect.php';

if (isset($_POST["create_usuario"])) {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $data_nascimento = trim($_POST["data_nascimento"]);
    $senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : '';

    if (empty($nome) || empty($email) || empty($data_nascimento) || empty($senha)) {
        $_SESSION['mensagem'] = "Erro ao criar usuário!";
        header('Location: index.php');
        exit;
    }

    $nome = mysqli_real_escape_string($connect, $nome);
    $email = mysqli_real_escape_string($connect, $email);
    $data_nascimento = mysqli_real_escape_string($connect, $data_nascimento);
    $senha_hash = mysqli_real_escape_string($connect, password_hash($senha, PASSWORD_DEFAULT));

    $sql = "INSERT INTO usuarios (nome, email, data_nascimento, senha) VALUES ('$nome', '$email', '$data_nascimento', '$senha_hash')";
    mysqli_query($connect, $sql);

    if (mysqli_affected_rows($connect) > 0) {
        $_SESSION['mensagem'] = "Usuário criado com sucesso!";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao criar usuário!";
        header('Location: index.php');
        exit;
    }
}

if (isset($_POST['update_usuario'])) {
	$usuario_id = mysqli_real_escape_string($connect, $_POST['usuario_id']);
	$nome = mysqli_real_escape_string($connect, trim($_POST['nome']));
	$email = mysqli_real_escape_string($connect, trim($_POST['email']));
	$data_nascimento = mysqli_real_escape_string($connect, trim($_POST['data_nascimento']));
	$senha = mysqli_real_escape_string($connect, trim($_POST['senha']));
	$sql = "UPDATE usuarios SET nome = '$nome', email = '$email', data_nascimento = '$data_nascimento'";

    if (empty($nome) || empty($email) || empty($data_nascimento)) {
        $_SESSION['mensagem'] = "Erro ao criar usuário!";
        header('Location: index.php');
        exit;
    }
	if (!empty($senha)) {
		$sql .= ", senha='" . password_hash($senha, PASSWORD_DEFAULT) . "'";
	}
	$sql .= " WHERE id = '$usuario_id'";
	mysqli_query($connect, $sql);
	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['mensagem'] = 'Usuário atualizado com sucesso';
		header('Location: index.php');
		exit;
	} else {
		$_SESSION['mensagem'] = 'Usuário não foi atualizado';
		header('Location: index.php');
		exit;
	}
}

if (isset($_POST['delete_usuario'])) {
    $usuario_id = mysqli_real_escape_string($connect, $_POST['delete_usuario']);
    
    $sql = "DELETE FROM usuarios WHERE id='$usuario_id'";

    mysqli_query($connect, $sql);
    if (mysqli_affected_rows($connect) > 0) {
        $_SESSION['mensagem'] = "Usuário deletado com sucesso!";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao deletar usuário";
        header('Location: index.php');
        exit;
    }
}
?>
