<?php

    namespace App\Helpers\Enums;

    use App\Helpers\Traits\EnumHelper;

    enum SocialsEnum: string {
        use EnumHelper;

        case GITHUB = 'github';
        case INSTAGRAM = 'instagram';
        case TELEGRAM = 'telegram';
        case WHATSAPP = 'whatsapp';
        case Dribble = 'dribble';
        case LINKEDIN = 'linkedin';
        case PINTEREST = 'pinterest';
        case TWITTER = 'twitter';
        case YOUTUBE = 'youtube';
        case APARAT = 'apart';
        case TIKTAK = 'tiktak';
        case SPOTIFY = 'spotify';
        case SOUNDCLOUD = 'soundcloud';
        case TWITCH = 'twitch';
    }
