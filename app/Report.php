<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
	use SoftDeletes;

	protected $fillable = ['cabang','tanggal','drop','storting','psp','drop_tunda','storting_tunda','tkp','sisa_kas','created_by','updated_by'];

	public function cabang()
	{
		return $this->belongsTo(KantorCabang::class,  'cabang', 'id' );
	}

	public function dibuatOleh()
	{
		return $this->belongsTo(User::class,  'created_by', 'id' );
	}

	public function dieditOleh()
	{
		return $this->belongsTo(User::class, 'updated_by', 'id');
	}
}
