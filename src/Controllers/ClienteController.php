<?php
namespace App\Controllers;

use App\Models\Cliente;
use App\Services\Request;
use App\Services\Validate;
use App\Repositorios\ClienteRepository;

class ClienteController {

    public static $repository;
    
    public static function echo () {
         return [
         	  ["nome" => "Exemplo1", "cpf" => "12312312345", "email" => "exemplo1@hibrido.com.br", "telefone" => "07855689885"],
         	  ["nome" => "Exemplo2", "cpf" => "16546444345", "email" => "exemplo2@hibrido.com.br", "telefone" => "68965454564"]
         	];
    }
    
    private static function setRepository() {
        $clienteRepository = new ClienteRepository();
        self::$repository = $clienteRepository;
    }
    
    public static function getClientes($vars = []) {
        self::setRepository();
        $clientes = self::$repository->getAll();
        if (empty(json_decode($clientes, true))) {
            return ["status" => "Erro", "mensagem" =>  "Nao ha cliente cadastrado"];
        }
        return ["status" => "Sucesso", "mensagem" => $clientes];
    }
    
    public static function getCliente($vars = []) {
        self::setRepository();
        $id = $vars['id']??'';
        $cliente = self::$repository->getOne($id);
        if (!$cliente) {
            return ["status" => "Erro", "mensagem" => "Nao foi possivel obter. Cliente nao encontrado"];
        }
        return $cliente;
    }
    
    public static function addCliente($vars = []) {
        $nome = $_POST['nome'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        
        $validate = new Validate;
        
        if ($validate->validaCPF($cpf)) {
            if (empty($cpf) || empty($telefone) || empty($nome) || empty($email)) {
                return ["status" => "Erro", "mensagem" => "Forneça id, nome, cpf, email e telefone para fazer a requisicao"];
            } else {
                self::setRepository();
                $verifica = self::$repository->getCpf($cpf);
                if (!$verifica) {
                    $cliente = self::$repository->add(['nome' => $nome, 'cpf' => $cpf, 'email' => $email, 'telefone' => $telefone]);
                    return $cliente;
                } else {
                    return ["status" => "Erro", "mensagem" => "Cliente ja cadastrado"];
                } // FIM if (!$verifica)
                
            } //FIM IF EMPTY
            
        } else {
            return ["status" => "Erro", "mensagem" => "Verifique CPF"];
        }
    }
    
    public static function editCliente($vars = []) {
           
        self::setRepository();
        
        $id = $vars['id'] ?? '';
        
        $cliente = self::$repository->getOne($id);
        
        if (strlen($_POST['cpf']) > 1) {$cpf = $_POST['cpf'];} else  { $cpf = $cliente->cpf;}  
        if (strlen($_POST['telefone']) > 1) { $telefone = $_POST['telefone'];} else  { $telefone = $cliente->telefone;}  
        if (strlen($_POST['email']) > 1) { $email = $_POST['email'];} else  { $email = $cliente->email;}  
        if (strlen($_POST['nome']) > 1) { $nome = $_POST['nome'];} else  { $nome = $cliente->nome;}        
        
        
        if (!$cliente) {
            return ["status" => "Erro", "mensagem" =>  'Não existe um cliente com esse ID'];
        }
        
        $validate = new Validate;
        
        if ($validate->validaCPF($cpf)) {
		$updated = self::$repository->update($id, 
		[
			'telefone' => $telefone, 
			'nome' => $nome, 
			'cpf' => $cpf, 
			'email' => $email
		]);
		
		return self::$repository->getOne($id);
	} else {
		return ["status" => "Erro", "mensagem" => "Verifique CPF"];
	}
    }
    
    public static function removeCliente($vars = []) {
    
        self::setRepository();
        
        $id = $vars['id']??'';
        $cliente = self::$repository->getOne($id);
        
        if (!$cliente) {
            return ["status" => "Erro", "mensagem" =>  'Não foi possivel remover. Cliente não encontrado'];
        }
        self::$repository->delete($id);
        return ["status" => "Sucesso", "mensagem" =>  'Cliente removido'];
    }
    
    public static function getMock() {
   
        return ["nome" => "exemplo", "telefone" => "73555", "cpf" => "05621444251", "email" => "exemplo@hibrido.com.br"];
    }
}

