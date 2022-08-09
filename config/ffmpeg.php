<?php

return [
    'ffmpeg.binaries' => env('FFMPEG_PATH', '\bin\ffmpeg.exe'),
    'ffprobe.binaries' => env('FFPROBE_PATH', '\bin\ffprobe.exe'),
    'timeout' => 3600, // The timeout for the underlying process
    'ffmpeg.threads' => 12,   // The number of threads that FFmpeg should use
];
