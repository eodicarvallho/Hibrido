<?php
 
namespace App\Services; 
use Illuminate\Database\Capsule\Manager as Capsule;
 
class Database 
{
    public function __construct() 
    {
    
    	$driver = "sqlite"
    	
        $capsule = new Capsule;
	if ($driver == "sqlite") {
	        $capsule->addConnection([
		            'driver'       => 'sqlite',
		            'database'     => 'database.sqlite',
        	]);
        } else {
                $capsule->addConnection([
            		'driver'       => 'mysql',
	            	'host'         => DB_HOST,
	            	'database'     => DB_NAME,
	            	'username'     => DB_USER,
	            	'password'     => DB_PASS,
	         	'charset'      => 'utf8',
        		'collation'    => 'utf8_unicode_ci',
	        	'prefix'       => '',
        	]);
        }
        $capsule->setAsGlobal();
        // inicia o Eloquent
        $capsule->bootEloquent();
    }
}
