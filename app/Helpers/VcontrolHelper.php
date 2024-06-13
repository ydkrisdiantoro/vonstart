<?php

namespace App\Helpers;

class VcontrolHelper
{
    protected const TRUE_COLOR = 'success';
    protected const FALSE_COLOR = 'danger';

    protected const TRUE_MESSAGE = 'Berhasil!';
    protected const FALSE_MESSAGE = 'Gagal!';

    public static function returnAlert($success = true, $customMessage = null)
    {
        $datas = [self::TRUE_COLOR, $customMessage ?? self::TRUE_MESSAGE];
        if(!$success){
            $datas = [self::FALSE_COLOR, $customMessage ?? self::FALSE_MESSAGE];
        }

        return ['alert', $datas];
    }
}
