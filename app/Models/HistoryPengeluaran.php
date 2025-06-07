<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_obat_id',
        'dari',
        'kepada',
        'tanggal_pengeluaran',
        'penerima',
        'pengeluaran',
        'sisa_stock',
        'tanggal'
    ];

    public function dataObat()
    {
        return $this->belongsTo(DataObat::class, 'id_obat');
    }
}
