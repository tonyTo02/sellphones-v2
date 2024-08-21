<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    protected $fillable = [
        'name',
        'avatar',
        'gender',
        'dob',
        'email',
        'password',
        'address',
        'phone_number',
    ];

    public function getGender()
    {
        if ($this->gender === 0) {
            return 'Nam';
        } else {
            return 'Nữ';
        }
    }
}
