<?php
namespace Test;

require_once 'vendor/autoload.php';

use App\Models\Cliente;
use App\Repositorios\ClienteRepository;

use PHPUnit\Framework\TestCase;

class ClientesTest extends TestCase
{
	public static $repository; 
	
	private static function setRepository()
	{
		$clienteRepository = new ClienteRepository();
		self::$repository = $clienteRepository;
	}

	public function testClientesGetAll()
	{
		$clientes = self::$repository->getAll();
   		$this->assertTrue(!empty(json_decode($clientes, true)));
  }
