<?php

namespace App\Services\Projobi;

use App\Models\Projobi\ProjobiUser;

class UpdateProjobiUserService {
    
    /**
     * Update a user in the projobi database
     * 
     * @return array
     */
    
    public static function update($id, $data)
    {
        $projobiUser = ProjobiUser::where('id', $id)
            ->update($data);

        return $projobiUser;
    }
}