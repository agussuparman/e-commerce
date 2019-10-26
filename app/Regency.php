<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RajaOngkir;

class Regency extends Model
{
    protected $fillable = ['id', 'province_id', 'name'];

    public static function populate()
    {
    	foreach (RajaOngkir::Kota()->all() as $regency) {
    		$model = static::firstOrNew(['id' => $regency['city_id']]);
    		$model->province_id = $regency['province_id'];
    		$model->name = $regency['type'] . ' ' . $regency['city_name'];
    		$model->save();
    	}
    }

    public function province()
    {
    	return $this->belongsTo('App\Province');
    }
}
