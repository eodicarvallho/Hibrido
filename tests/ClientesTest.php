<?php
namespace Test;

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ClientesTest extends TestCase
{

	private $http;

	public function setUp(): void
	{
		$this->http = new Client(['base_uri' => 'http://clientes.localhost']);
		//$response = $client->request('GET', '/api/users?page=1');
	}

    	public function tearDown(): void{
        	$this->http = null;
    	}

	public function testClientesGetAll()
	{
		$response = $this->http->request('GET', '/clientes');
		
		$data = $response->getBody();
		$this->assertEquals($data, '[{"id":2,"nome":"dieg","email":"dieo","telefone":"89788765544","cpf":"765434589"}]');
 	}
 	
	public function testClientesGetOne()
	{
		$response = $this->http->request('GET', '/cliente/1');
		
		$data = $response->getBody();
		$this->assertEquals($data, '{"id":1,"nome":"dieg","email":"dieo","telefone":"89788765544","cpf":"765434589"}');
 	}
 	
	public function testClientesCreate()
	{
		$response = $this->http->request('POST', '/api/users', ['form_params' => [
		    'name' => 'Dan',
		    'job' => 'Full Stack Dev'
		]]);
		
		$data = $response->getBody();
		$this->assertEquals($data, '{"id":1,"nome":"dieg","email":"dieo","telefone":"89788765544","cpf":"765434589"}');
 	}
 	
	public function testClientesDelete()
	{
		$response = $this->http->request('GET', '/cliente/1');
		$data = $response->getBody();
		$this->assertEquals($data, '{"id":1,"nome":"dieg","email":"dieo","telefone":"89788765544","cpf":"765434589"}');
 	}
 	
	public function testClientesUpdate()
	{
		$response = $this->http->request('GET', '/cliente/1');
		$data = $response->getBody();
		$this->assertEquals($data, '{"id":1,"nome":"dieg","email":"dieo","telefone":"89788765544","cpf":"765434589"}');
 	}
}
