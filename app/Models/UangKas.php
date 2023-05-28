<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class UangKas extends Model
{
    use HasFactory;

    protected $table = 'uang_kas';

    protected $fillable = ['tanggal', 'keterangan', 'jenis', 'debit', 'kredit', 'saldo', 'previous_saldo'];

}
