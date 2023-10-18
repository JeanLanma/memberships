<?php

namespace App\Services\Projobi;

use App\Models\Projobi\ProjobiUser;

class PostProjobiUserService
{
    public static function postProjobiUser(ProjobiUser $projobiUser)
    {
        return \App\Models\User::create([
            'name' => $projobiUser->name,
            'email' => $projobiUser->email,
            'projobi_user_id' => $projobiUser->id,
            'password' => $projobiUser->password,
        ]);
    }
}