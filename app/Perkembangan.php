<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perkembangan extends Model
{
       // use SoftDeletes;

	protected $fillable = ['program_kerja_id','cabang','tanggal','drops','storting','psp','drop_tunda','drop_tunda_masuk','drop_tunda_keluar','storting_tunda','angsuran_tunda_masuk','angsuran_tunda_keluar','tkp','sisa_kas','hari_kerja','created_by','updated_by'];

	public function Cabang()
	{
		return $this->belongsTo(KantorCabang::class,  'cabang', 'id' );
	}

	public function ProgramKerja()
	{
		return $this->belongsTo(ProgramKerja::class,  'program_kerja_id', 'id' );
	}

	public function DibuatOleh()
	{
		return $this->belongsTo(User::class,  'created_by', 'id' );
	}

	public function DieditOleh()
	{
		return $this->belongsTo(User::class, 'updated_by', 'id');
	}
}
