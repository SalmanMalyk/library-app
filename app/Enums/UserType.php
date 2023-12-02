<?php
namespace App\Enums;

enum UserType: int {
    case Author     = 0;
    case Publisher  = 1;
}