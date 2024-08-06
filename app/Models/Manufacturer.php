<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'image'
    ];
    public function getSelectOptionManufacturer()
    {
        $manufacturers = new Manufacturer();
        $object = $manufacturers::select('id', 'name')->get();
        return $object;
    }
}
