<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoleEnum extends Enum
{
    const ADMINISTRATOR = 'ADMINISTRATOR';
    const CUSTOMER = 'CUSTOMER';

    public static function roles(){
        $roles = [
            'ADMINISTRATOR',
            'CUSTOMER',
        ];
        return $roles;
    }
}

