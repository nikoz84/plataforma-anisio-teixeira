<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    {{-- @routes --}}
  </head>
  <body>
    @inertia
    
    <script defer src="{{ mix('/js/manifest.js') }}"></script>
    <script defer src="{{ mix('/js/vendor.js') }}" defer></script>
    <script defer src="{{ mix('/js/app.js') }}" defer></script>
    
    
  </body>
</html>
