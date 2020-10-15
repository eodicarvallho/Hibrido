<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Services\Request;
use App\Repositories\ClienteRepository;

class ClienteController
{
	public static $repository; 

	private static function setRepository()
	{
		$clienteRepository = new ClienteRepository();
		self::$repository = $clienteRepository;
	}

	public static function getClientes($vars = [])
	{
		self::setRepository();
		return $clientes = self::$repository->getAll();
	}

	public static function getCliente($vars = [])
	{
		self::setRepository();
		$id = $vars['id'] ?? '';
		$cliente = self::$repository->getOne($id);
		return $cliente;
	}

	public static function addCliente($vars = [])
	{
		$id   	   =  $_POST['id'] ?? '';
		$nome 	   =  $_POST['nome'] ?? '';
		$cpf  	   =  $_POST['cpf'] ?? '';
		$email     =  $_POST['email'] ?? '';
		$telefone  =  $_POST['telefone'] ?? '';
		if (empty($id) || empty($cpf) || empty($telefone) || empty($nome) || empty($email)) {
			return ['error' => 'Forneça id, nome, cpf, email e telefone para fazer a requisicao'];
		}
		self::setRepository();
		$cliente = self::$repository->add([
			'id' 	    =>  $id,
			'nome' 	    =>  $nome, 
			'cpf'	    =>  $cpf,
			'email'	    =>  $email,
			'telefone'  =>  $telefone]);
		return $cliente;
	}

	public static function editCliente($vars = [])
	{
	}

}
