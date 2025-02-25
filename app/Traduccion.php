<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Traduccion extends Model {
	protected $table = "traducciones";
	public static function getTrad($lang)	{

		$tra = Traduccion::all();

		$arr = array();
 		
 		foreach ($tra as $key) {

 			switch ($lang) {
 				case 'es': $arr[$key->es] = $key->es; break;
 				case 'en': $arr[$key->es] = $key->en; break;
 				case 'pr': $arr[$key->es] = $key->pr; break;
				case 'zh': $arr[$key->es] = $key->zh; break;
 			}
 		} 	
		return $arr;
	}

}