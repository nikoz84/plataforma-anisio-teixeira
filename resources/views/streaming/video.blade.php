<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Streaming de video</title>
    <link href="//vjs.zencdn.net/7.8.2/video-js.min.css" rel="stylesheet">
</head>
<body>
    <video
        id="my-player"
        class="video-js"
        controls
        preload="auto"
        poster="//vjs.zencdn.net/v/oceans.png"
        
        >
            <source
            src="{{ $file }}"
            type="application/x-mpegURL">
    </video>




    <script src="//vjs.zencdn.net/7.8.2/video.min.js"></script>
    
    <script>
        

        const options = {
            playbackRates: [0.5, 1, 1.5, 2],
            responsive: true,
            smoothQualityChange: true,
            allowSeeksWithinUnsafeLiveWindow: true
        };
        
        var player = videojs('my-player', options, function onPlayerReady() {
            videojs.log('Your player is ready!');
            
            // In this context, `this` is the player that was created by Video.js.
            //this.play();
            
            // How about an event listener?
            this.on('ended', function() {
              videojs.log('Awww...over so soon?!');
            });
          });
          
          
          
          
    </script>
</body>
</html>