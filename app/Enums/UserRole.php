<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN  = 'Admin';
    case EDITOR = 'Editor';
    case USER   = 'User';

}
