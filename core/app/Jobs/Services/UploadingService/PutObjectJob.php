<?php

    namespace App\Jobs\Services\UploadingService;

    use App\Helpers\Enums\BucketEnum;
    use App\Services\Uploading\UploadingService;
    use Hans\Alicia\Models\Resource;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;

    class PutObjectJob implements ShouldQueue {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        private Resource $resource;
        private BucketEnum $bucket;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct( Resource $resource, BucketEnum $bucket ) {
            $this->resource = $resource;
            $this->bucket   = $bucket;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle() {
            app( UploadingService::class )->setBucket( $this->bucket )->getHandler()->putObject( $this->resource );
        }
    }
