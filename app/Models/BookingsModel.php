<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingsModel extends Model
{
    protected $table = 'bookings', $guarded = [];

    public function lapangan()
    {
        return $this->hasOne(LapanganModel::class, 'id', 'lapangan_id');
    }
}
