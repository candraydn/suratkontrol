<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class suratkontrol extends Model
{
    protected $fillable = ['no_rujukan','tanggal','kunjungan','no_rm','no_surat','no_kartu'];
    protected $table = 'surat_kontrol';
}
