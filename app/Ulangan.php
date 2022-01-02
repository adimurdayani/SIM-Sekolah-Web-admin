<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ulangan extends Model
{
    protected $fillable = ['siswa_id', 'kelas_id', 'guru_id', 'mapel_id', 'ulha_1', 'ulha_2', 'uts', 'ulha_3', 'uas'];

    protected $table = 'ulangan';

    public function mapel()
    {
        return $this->belongsTo('App\Mapel')->withDefault();
    }

    public function guru()
    {
        return $this->belongsTo('App\Guru')->withDefault();
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas')->withDefault();
    }

    public function siswa()
    {
        return $this->belongsTo('App\Siswa')->withDefault();
    }
}
