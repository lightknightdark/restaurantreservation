<?php

namespace App\Models;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    use HasFactory;

    protected $fillable = [
            "first_name",
            "last_name",
            "email",
            "res_date",
            "guest_number",
            "tel_number",
            "table_id",
    ];

    protected $dates = [
        'res_date'
     ];

    public function table(){
        return $this->belongsTo(Table::class);
    }
}
