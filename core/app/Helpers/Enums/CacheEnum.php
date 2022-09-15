<?php

    namespace App\Helpers\Enums;

    use App\Helpers\Traits\EnumHelper;

    enum CacheEnum: string {
        use EnumHelper;

        case PREFIX = 'STARTER_PREFIX_';
    }
