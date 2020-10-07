<?php

return [
    'ffmpeg.binaries'  => env('FFMPEG_BINARIES', 'C:\ffmpeg\ffmpeg.exe'),
    'ffprobe.binaries' => env('FFPROBE_BINARIES', 'C:\ffmpeg\ffprobe.exe'),
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFmpeg should use
];
