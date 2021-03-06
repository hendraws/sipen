<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramKerja extends Model
{
   // use SoftDeletes;

	protected $fillable = ['cabang','tanggal','drops','storting','psp','drop_tunda','storting_tunda','tkp','sisa_kas','created_by','updated_by'];

	public function Cabang()
	{
		return $this->belongsTo(KantorCabang::class,  'cabang', 'id' );
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
