<?php


    namespace App\Policies\Traits;


    use Horus;

    trait PolicyHelper {
        private function makeAbility(): string {
            return Horus::normalizeModelName( $this->getModel() ) . '-' . debug_backtrace()[ 1 ][ 'function' ];
        }

        /**
         * Set the related model class
         *
         * @return string
         */
        abstract private function getModel(): string;
    }
