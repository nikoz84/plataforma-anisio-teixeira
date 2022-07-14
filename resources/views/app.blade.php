<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/css/app.css')
    {{-- @routes --}}
  </head>
  <body>
    @inertia
    
    @vite('resources/js/manifest.js')
    @vite('resources/js/vendor.js')
    @vite('resources/js/app.js')
    
    
  </body>
</html>
