<?php

return [
    'ffmpeg.binaries'  => env('FFMPEG_PATH', '/usr/bin/ffmpeg'),
    'ffprobe.binaries' => env('FFPROBE_PATH', '/usr/bin/ffprobe'),
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFmpeg should use
];
