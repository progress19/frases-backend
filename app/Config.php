<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = "config";

    public static function getLogo() {
		$config = Config::where(['id'=>1])->first();
		return url('/').'/pics/config/large/'.$config->logo;
	}

	public static function getLogoNameFile() {
		$config = Config::where(['id'=>1])->first();
		return $config->logo;
	}

	public static function getNosotros($locale) {
        $config = Config::find(1);
        $nosotros = $config->{'nosotros_' . $locale}; 
        return $nosotros;
    }

	public static function getImagenNosotros() {
		$config = Config::where(['id'=>1])->first();
		return url('/').'/pics/config/large/'.$config->nosotros_imagen;
	}

	public static function getNuestros($locale) {
        $config = Config::find(1);
        $nuestros = $config->{'nuestros_' . $locale}; 
        return $nuestros;
    }

	public static function getTelefono() {
        $config = Config::where(['id'=>1])->first();
        return $config->telefono;
    }

	public static function getWhatsapp() {
        $config = Config::where(['id'=>1])->first();
        return $config->whatsapp;
    }

    public static function getDireccion() {
        $config = Config::where(['id'=>1])->first();
        return $config->direccion;
    }

}
