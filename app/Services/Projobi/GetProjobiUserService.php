<?php

namespace App\Services\Projobi;

use App\Models\Projobi\ProjobiUser;

class GetProjobiUserService {
    
    /**
     * Get all users from the projobi database
     * 
     * @return array
     */
    
    public static function get()
    {
        $projobiUsers = ProjobiUser::all();

        return $projobiUsers;
    }

    public static function getUserById($id)
    {
        $projobiUser = ProjobiUser::where('id', $id)->first();

        return $projobiUser;
    }
}