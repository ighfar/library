<?php

namespace App\Codes\Logic;

use App\Codes\Models\Admin;

class AccessLogin
{
    public function __construct()
    {
    }

    public function cekLogin($email, $password, $key = 'email')
    {
        $user = Admin::where($key, $email)->where('status', 1)->first();

        if($user) {
            $check_password = app('hash')->check($password, $user->password);
            if($check_password) {
                return $user;
            }
        }

        return false;
    }
}