<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kemacetan extends Model
{
	protected $fillable = ['cabang_id','resort_id','pasaran','tanggal','ma_anggota','ma_pinjaman','ma_target','ma_saldo','mb_anggota','mb_pinjaman','mb_target','mb_saldo','created_by','updated_by' ];

	public function getPasaran()
	{
		return $this->belongsTo(Pasaran::class,  'pasaran', 'id' );
	}

	public function getResort()
	{
		return $this->belongsTo(Resort::class,  'resort_id', 'id' );
	}

}
