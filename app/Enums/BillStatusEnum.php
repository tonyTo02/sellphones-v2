<?php declare(strict_types=1);

namespace App\Enums;

use App\Models\Bill;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BillStatusEnum extends Enum
{
    public const CHO_XAC_NHAN = 1;
    public const DANG_GIAO_HANG = 2;
    public const GIAO_THANH_CONG = 3;


    public static function getArrayView()
    {
        return [
            'Đang chờ xác nhận' => self::CHO_XAC_NHAN,
            'Đang giao hàng' => self::DANG_GIAO_HANG,
            'Đã giao hàng' => self::GIAO_THANH_CONG,
        ];
    }
}
