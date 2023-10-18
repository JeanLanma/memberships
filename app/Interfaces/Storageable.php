<?php

namespace App\Interfaces;

interface Storageable extends Descriptable {

    public function GetStoreObject(): object|array;
    public function HasStoreUpdate(): bool;
    public function UpdateStore(): void;

}