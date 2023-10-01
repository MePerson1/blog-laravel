<?php

namespace App\Enums;
//klasa określająca role użytkowników
class UserRole
{
    const ADMIN = 'admin';
    const USER = 'user';

    const TYPES = [
        self::ADMIN,
        self::USER
    ];
    
}