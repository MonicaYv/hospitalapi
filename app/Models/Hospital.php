<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Location;


class Hospital extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'hospitals';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'location_id'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
