<?php

    namespace App\Helpers\Enums;

    use App\Helpers\Traits\EnumHelper;

    enum BucketEnum: string {
        use EnumHelper;

        case DEFAULT = 'prefix-storage';
    }
