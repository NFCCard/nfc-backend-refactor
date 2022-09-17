<?php

    namespace App\Helpers\Enums;

    use App\Helpers\Traits\EnumHelper;

    class StatusEnum {
        use EnumHelper;

        const ACCEPTED = 'accepted';
        const DENIED = 'denied';
        const PENDING = 'pending';
    }
