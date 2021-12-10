<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    protected $fillable = ['cabang_id', 'nama'];

    public function getKemacetan()
    {
    	return $this->hasMany(Kemacetan::class, 'resort_id', 'id');
    }

    public function getAngsuranKemacetan()
    {
    	return $this->hasMany(AngsuranKemacetan::class, 'resort_id', 'id');
    }
    public function getCalonMacet()
    {
    	return $this->hasMany(CalonMacet::class, 'resort_id', 'id');
    }


}
