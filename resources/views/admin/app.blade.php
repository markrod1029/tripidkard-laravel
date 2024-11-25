<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TripidKard</title>

    <link rel="icon" href="{{ asset('/storage/img/logo.jpg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper" id="app">
        <router-view></router-view>
    </div>

</body>

</html>
