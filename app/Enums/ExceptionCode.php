<?php

namespace App\Enums;

enum ExceptionCode: int
{
    case Hourly_Rate_Amount_Missing = 1;
    case Hourly_Rate_Currency_Missing = 2;
}
