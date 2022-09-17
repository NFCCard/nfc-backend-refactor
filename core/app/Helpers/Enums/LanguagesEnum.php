<?php

    namespace App\Helpers\Enums;

    use App\Helpers\Traits\EnumHelper;

    enum LanguagesEnum: string {
        use EnumHelper;

        case ENGLISH = 'en';
        case FARSI = 'fa';
    }
