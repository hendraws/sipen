<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
	protected $fillable = ['cabang_id', 'resort_id', 'pasaran', 'tanggal','anggota_lalu', 'anggota_lama', 'anggota_baru', 'anggota_out', 'anggota_kini', 'target_lalu', 'target_20_drop', 'target_20_plnsn', 'target_kini', 'target_drops', 'target_plnsn', 'drop_lalu', 'drop_kini', 'drop_berjalan', 'drop_total', 'storting_lalu', 'storting_kini', 'storting_berjalan', 'storting_total', 'created_by', 'updated_by',];

	public function getResort()
	{
		return $this->belongsTo(Resort::class,  'resort_id', 'id' );
	}

	public function getPrevious(){
        // get previous  preregister
		// return PreRegister::with('uktCriteria', 'hasilUkt', 'dokumenPendukung')
		// ->where('no_pendaftaran', '<',$this->no_pendaftaran)
		// ->whereHas('hasilUkt')
		// ->whereHas('dokumenPendukung')
		// ->whereYear('created_at',date('Y'))
		// ->orderBy('no_pendaftaran','desc')
		// ->first();
		$tanggal = explode('-', $this->tanggal);
		return Target::select("*")
    			->whereMonth('tanggal',$tanggal[1])
    			->where('cabang_id', auth()->user()->cabang_id)
    			->where('pasaran', $this->pasaran)
    			->where('resort_id', $this->resort_id)
    			->where('id', '<',$this->id)
    			->orderBy('created_at', 'desc')
    			->first();

	}
}
