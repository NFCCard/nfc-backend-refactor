<?php

    namespace App\Jobs\Services\UploadingService;

    use App\Services\Uploading\UploadingService;
    use Hans\Alicia\Contracts\AliciaContract;
    use Hans\Alicia\Models\Resource;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;

    class DeleteObjectJob implements ShouldQueue {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        private Resource $resource;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct( Resource $resource ) {
            $this->resource = $resource;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle() {
            app( UploadingService::class )->getHandler()->deleteObject( $this->resource );
            app( AliciaContract::class )->delete( $this->resource );
        }
    }
