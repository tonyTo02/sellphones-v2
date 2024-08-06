<?php

namespace App\Models;

use App\Enums\BillStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_time',
        'note',
        'status',
        'total',
        'customer_id',
    ];
    public function getBillStatus()
    {
        $arrBillStatus = BillStatusEnum::getArrayView();
        foreach ($arrBillStatus as $option => $value) {
            if ($this->status === $value) {
                return $option;
            }
        }
    }

    public function getKeyValueToStatusOption()
    {
        return BillStatusEnum::getArrayView();
    }
}
