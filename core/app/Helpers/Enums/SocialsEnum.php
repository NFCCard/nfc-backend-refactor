<?php

    namespace App\Helpers\Enums;

    use App\Helpers\Traits\EnumHelper;

    enum SocialsEnum: string {
        use EnumHelper;

        case TELEGRAM = 'telegram';
        case WHATSAPP = 'whatsapp';
        case INSTAGRAM = 'instagram';
        case LINKEDIN = 'linkedin';
        case GITHUB = 'github';
    }
