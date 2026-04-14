<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Saran extends Model

{

    protected $fillable = ['nis', 'judul', 'isi_saran'];


    public function siswa()

    {

        return $this->belongsTo(Siswa::class, 'nis', 'nis');

    }

}