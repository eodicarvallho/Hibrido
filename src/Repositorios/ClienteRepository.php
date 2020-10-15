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
		$cliente = Cliente::where('id', $id)->delete();
	}

	public function getOne($id)
	{
	     	$cliente = Cliente::where('id', $id)->first();
		return $cliente;
	}

	public function getCpf($cpf)
	{
	     	$cliente = Cliente::where('cpf', $cpf)->first();
		return $cliente;
	}

}
