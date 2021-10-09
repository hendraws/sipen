<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AngsuranKemacetan extends Model
{
	protected $fillable = [ 'cabang_id','kemacetan_id','resort_id','pasaran','tanggal','angsuran','anggota_keluar','created_by','updated_by' ];

	public function getPasaran()
	{
		return $this->belongsTo(Pasaran::class,  'pasaran', 'id' );
	}

	public function getResort()
	{
		return $this->belongsTo(Resort::class,  'resort_id', 'id' );
	}

}
