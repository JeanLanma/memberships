<?php

namespace App\Interfaces;

interface Storageable extends Descriptable {

    public function GetStoreObject(): object|array;

}