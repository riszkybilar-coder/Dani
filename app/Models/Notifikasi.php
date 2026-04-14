<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Notifikasi extends Model

{


    protected $table = 'notifikases';


    protected $fillable = ['nis', 'id_aspirasi', 'pesan', 'sudah_dibaca'];


    public function siswa()

    {

        return $this->belongsTo(Siswa::class, 'nis', 'nis');

    }


    public function aspirasi()

    {

        return $this->belongsTo(Aspirasi::class, 'id_aspirasi', 'id_aspirasi');

    }

}