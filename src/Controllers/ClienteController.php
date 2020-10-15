<?php
namespace App\Controllers;

use App\Models\Cliente;
use App\Services\Request;
use App\Services\Validate;
use App\Repositorios\ClienteRepository;

class ClienteController {

    public static $repository;
    
    public static function echo () {
        return "Opa, chegamos na home";
    }
    
    private static function setRepository() {
        $clienteRepository = new ClienteRepository();
        self::$repository = $clienteRepository;
    }
    
    public static function getClientes($vars = []) {
        self::setRepository();
        $clientes = self::$repository->getAll();
        if (empty(json_decode($clientes, true))) {
            return ["Erro" => "Nao ha cliente cadastrado"];
        }
        return $clientes;
    }
    
    public static function getCliente($vars = []) {
        self::setRepository();
        $id = $vars['id']??'';
        $cliente = self::$repository->getOne($id);
        if (!$cliente) {
            return ["Erro" => "Nao foi possivel obter. Cliente nao encontrado"];
        }
        return $cliente;
    }
    
    public static function addCliente($vars = []) {
        $nome = $_POST['nome']??'';
        $cpf = $_POST['cpf']??'';
        $email = $_POST['email']??'';
        $telefone = $_POST['telefone']??'';
        
        $validate = new Validate;
        
        if ($validate->validaCPF($cpf)) {
            if (empty($cpf) || empty($telefone) || empty($nome) || empty($email)) {
                return ['error' => 'Forneça id, nome, cpf, email e telefone para fazer a requisicao'];
            } else {
                self::setRepository();
                $verifica = self::$repository->getCpf($cpf);
                if (!$verifica) {
                    $cliente = self::$repository->add(['nome' => $nome, 'cpf' => $cpf, 'email' => $email, 'telefone' => $telefone]);
                    return $cliente;
                } else {
                    return ['error' => 'Cliente ja cadastrado'];
                } // FIM if (!$verifica)
                
            } //FIM IF EMPTY
            
        } else {
            return ['error' => 'Verifique CPF'];
        }
    }
    
    public static function editCliente($vars = []) {
           
        self::setRepository();
        
        $id = $vars['id'] ?? '';
        
        $cliente = self::$repository->getOne($id);
        
        if (strlen($_POST['cpf']) > 1) { $cpf = $_POST['cpf'];} else  { $cpf = $cliente->cpf;}  
        if (strlen($_POST['telefone']) > 1) { $telefone = $_POST['telefone'];} else  { $telefone = $cliente->telefone;}  
        if (strlen($_POST['email']) > 1) { $email = $_POST['email'];} else  { $email = $cliente->email;}  
        if (strlen($_POST['nome']) > 1) { $nome = $_POST['nome'];} else  { $nome = $cliente->nome;}        
        
        
        if (!$cliente) {
            return ['error' => 'Não existe um cliente com esse ID'];
        }
        $updated = self::$repository->update($id, 
        [
		'telefone' => $telefone, 
		'nome' => $nome, 
		'cpf' => $cpf, 
		'email' => $email
        ]);
        
        return self::$repository->getOne($id);
    }
    
    public static function removeCliente($vars = []) {
    
        self::setRepository();
        
        $id = $vars['id']??'';
        $cliente = self::$repository->getOne($id);
        
        if (!$cliente) {
            return ['error' => 'Não foi possivel remover. Cliente não encontrado'];
        }
        self::$repository->delete($id);
        return ['data' => 'Cliente removido'];
    }
    
    public static function getClienteFromApi($vars = []) {
   
        $id = $vars['id']??'';
        $request = new Request(API);
        $response = $request->get('id', ['id' => $id]);
        return $response;
    }
}

