<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KantorCabang extends Model
{
	use SoftDeletes;

	protected $fillable = ['slug','cabang','created_by','updated_by'];

	public function dibuatOleh()
	{
		return $this->belongsTo(User::class,  'created_by', 'id' );
	}

	public function dieditOleh()
	{
		return $this->belongsTo(User::class, 'updated_by', 'id');
	}

	public function User()
	{
		return $this->hasOne(User::class, 'cabang_id', 'id');
	}
}
