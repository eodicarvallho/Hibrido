<?php
 
namespace App\Models;
 
use \Illuminate\Database\Eloquent\Model;
 
class Color extends Model 
{
    protected $primaryKey = 'id';
    protected $table = 'clientes';
    protected $fillable = ['nome', 'email', 'cpf', 'telefone'];
    public $timestamps = false;
     
}
 
?>
