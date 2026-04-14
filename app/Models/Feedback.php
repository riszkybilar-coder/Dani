<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Feedback extends Model

{

    protected $table = 'feedbacks'; // ← tambahkan baris ini


    protected $fillable = ['id_aspirasi', 'isi_feedback'];


    public function aspirasi()

    {

        return $this->belongsTo(Aspirasi::class, 'id_aspirasi', 'id_aspirasi');

    }

}