<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnggotaLalu extends Model
{
	protected $fillable = [
		'cabang_id',
		'resort_id',
		'pasaran',
		'tanggal',
		'anggota',
		'anggota_kini',
		'created_by',
		'updated_by'
	];

	public function getPasaran()
	{
		return $this->belongsTo(Pasaran::class,  'pasaran', 'id' );
	}
}
