<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TargetLalu extends Model
{
    protected $fillable = [
		'cabang_id',
		'resort_id',
		'pasaran',
		'tanggal',
		'target_lalu',
		'created_by',
		'updated_by'
	];

	public function getPasaran()
	{
		return $this->belongsTo(Pasaran::class,  'pasaran', 'id' );
	}
	
	public function getResort()
	{
		return $this->belongsTo(Resort::class,  'resort_id', 'id' );
	}
}
