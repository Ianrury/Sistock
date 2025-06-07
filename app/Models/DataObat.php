<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataObat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_obat',
        'jenis_obat',
        'tanggal_kadaluarsa',
        'bentuk',
        'isi_kemasan',
        'tanggal_masuk',
        'stock_obat',
        'satuan',
        'dosis',
        'admin_id',
        'superadmin_id'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function historyPengeluarans()
    {
        return $this->hasMany(HistoryPengeluaran::class, 'id_obat');
    }
    public function superadmin()
    {
        return $this->belongsTo(SuperAdmin::class);
    }

}
