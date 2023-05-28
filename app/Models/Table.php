<?php

namespace App\Models;

use App\Enums\TableLocation;
use App\Enums\TableStatus;
use App\Models\Reservations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
     protected $fillable = ['name','guest_number','status','location'];
     protected $case = [
        'status' => TableStatus::class,
        'location' => TableLocation::class,
     ];

     public function reservations(){
      return $this->hasMany(Reservations::class);
     }
}
