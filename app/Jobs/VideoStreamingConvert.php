<?php

namespace App\Jobs;

use App\Helpers\ContentVideoConvert;
use Streaming\FFMpeg;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VideoStreamingConvert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private ContentVideoConvert $converter;
    private string $pathDestiny;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ContentVideoConvert $converter, string $path)
    {
        //
        $this->converter = $converter;
        $this->pathDestiny = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $ffmpeg = FFMpeg::create(config('ffmpeg'));
        $this->converter->convertToStreaming($this->pathDestiny, $ffmpeg);
    }
}
