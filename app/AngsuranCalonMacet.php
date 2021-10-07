<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AngsuranCalonMacet extends Model
{
    protected $fillable = [ 'cabang_id','calon_macet_id','resort_id','pasaran','tanggal','angsuran','anggota_keluar','created_by','updated_by' ];

    public function getPasaran()
	{
		return $this->belongsTo(Pasaran::class,  'pasaran', 'id' );
	}
}
