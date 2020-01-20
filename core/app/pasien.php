<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pasien extends Model
{
    protected $fillable = ['no_rm','nama_pasien'];
    protected $table = 'pasien';
    protected  $primaryKey = 'no_rm';
}
