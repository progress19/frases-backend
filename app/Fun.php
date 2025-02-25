<?php

namespace App;
use Image;
use App\Config;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Session;

class Fun extends Model
{

	public static function generateStars($rating)
	{
		$output = '<div class="rating-stars">';
		$fullStars = floor($rating);
		$hasHalfStar = ($rating - $fullStars) >= 0.5;
		for ($i = 0; $i < $fullStars; $i++) {
			$output .= '<i class="flaticon-star"></i>';
		}
		if ($hasHalfStar) {
			$output .= '<i class="flaticon-star-sharp-half-stroke"></i>';
		}
		/*
		$remainingStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
		for ($i = 0; $i < $remainingStars; $i++) {
			$output .= '<i class="fa fa-star-o"></i>';
		}
		*/

		$output .= '</div>';
		return $output;
	}

	public static function getCurrency()
	{
		switch (Session::get('currency')) {
			case 'AR':
				echo 'AR$';
				break;
			case 'US':
				echo 'USD';
				break;
			default:
				echo 'USD';
				break;
		}
	}

	public static function getPriceDecimal($price)
	{

		$config = Config::where(['id' => 1])->first();
		if (Session::get('currency') == 'AR') {
			$price = $price * $config->usd;
			echo number_format($price, 2, ',', '.');
		} else {
			echo number_format($price, 2, '.', ',');
		}
	}

	public static function getPrice($price)
	{

		$config = Config::where(['id' => 1])->first();
		if (Session::get('currency') == 'AR') {
			$price = $price * $config->usd;
			echo number_format($price, 0, ',', '.');
		} else {
			echo number_format($price, 0, ',', '.');
			;
		}
	}

	public static function getPriceSinFormato($price)
	{

		$config = Config::where(['id' => 1])->first();
		if (Session::get('currency') == 'AR') {
			$price = $price * $config->usd;
			echo number_format($price, 0, '', '');
		} else {
			echo number_format($price, 0, '', '');
			;
		}
	}


	public static function getCurrencyOption($currency)
	{
		if ($currency == Session::get('currency')) {
			echo 'selected="selected"';
		}
	}

	public static function getFlagByIdioma($lang)
	{
		switch ($lang) {
			case 'es':
				return '<img src="' . asset('images/argentina.png') . '" style="height:20px;margin-bottom: 2px;" >';
				break;
			case 'en':
				return '<img src="' . asset('images/united-kingdom.png') . '" style="height:20px;margin-bottom: 2px;" >';
				break;
			case 'pr':
				return '<img src="' . asset('images/brazil.png') . '" style="height:20px;margin-bottom: 2px;" >';
				break;
			case 'zh':
				return '<img src="' . asset('images/china.png') . '" style="height:20px;margin-bottom: 2px;" >';
				break;
		}
	}

	public static function getFlagLanguage($height)
	{
		switch (app()->getLocale()) {
			case 'es':
				echo '<img src="' . asset('images/argentina.png') . '" style="height:' . $height . 'px;margin-bottom: 2px;" >';
				break;
			case 'en':
				echo '<img src="' . asset('images/united-kingdom.png') . '" style="height:' . $height . 'px;margin-bottom: 2px;" >';
				break;
			case 'pr':
				echo '<img src="' . asset('images/brazil.png') . '" style="height:' . $height . 'px;margin-bottom: 2px;" >';
				break;
			case 'zh':
				echo '<img src="' . asset('images/china.png') . '" style="height:' . $height . 'px;margin-bottom: 2px;" >';
				break;
		}

	}
	public static function getValueCheck($status)
	{
		if ($status == 1)
			return true;
	}

	public static function getPathImage($size, $model, $filename)
	{
		$pics_path = config('constants.options.pics-path');
		$image_path = $pics_path . $model . '/' . $size . '/' . $filename;
		return $image_path;
	}

	public static function getFormatDateInv($date)
	{ //recupero desde la bd
		if ($date) {
			$date = explode("-", $date);
			$date = "$date[2]-$date[1]-$date[0]";
			return $date;
		}
	}

	public static function getIconStatus($status)
	{

		if ($status == 1) {
			return '<i style="font-size:18px;" class="fa fa-check"></i>';
		} else {
			return '<i style="font-size:18px;" class="fa fa-times"></i>';
		}
	}

	public static function getFormatDate($date)
	{
		$date = explode("-", $date);
		$date = "$date[2]-$date[1]-$date[0]";
		return $date;
	}

	public static function getCookiesText()
	{
		$config = Config::where(['id' => 1])->first();
		switch (app()->getLocale()) {
			case 'es':
				echo $config->cookies_es;
				break;
			case 'en':
				echo $config->cookies_en;
				break;
			case 'pr':
				echo $config->cookies_pr;
				break;
			case 'zh':
				echo $config->cookies_zh;
				break;
		}
	}

}
