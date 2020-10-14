<?php

namespace App\Repositorios;

use App\Models\Cliente;

class ClienteRepository implements RepositoryInterface
{
	public function getAll()
	{
		$clientes = Cliente::all();
		return $clientes;
	}

	public function update($id, $updateData) : int
	{
		$updated = Cliente::where('id', $id)->update($updateData);
		return $updated;
	}

	public function add($data)
	{
		$cliente = Cliente::create($data);
		return $cliente;
	}

	public function delete($id)
	{
		$cliente = Cliente::where('id', $id)->first();
		$cliente->delete(); 
	}

	public function getOne($id)
	{
	    $cliente = Cliente::where('id', $id)->first();
		return $cliente;
	}


}
