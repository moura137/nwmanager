<!DOCTYPE html>
<html lang="pt-br" ng-app="App">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NwManager</title>

    <!-- CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" />

    @if(config('app.debug'))
        <link href="{{ asset('build/vendor/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('build/css/animate.css') }}" rel="stylesheet" />
        <link href="{{ asset('build/css/styles.css') }}" rel="stylesheet" />
    @else
        <link href="{{ elixir('css/all.css') }}" rel="stylesheet" />
    @endif
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    
    <div ng-view></div>

    <!-- Scripts -->
    @if(config('app.debug'))
        <script src="{{ asset('build/vendor/js/jquery.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-route.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-resource.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-animate.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-messages.js') }}"></script>
        <script src="{{ asset('build/vendor/js/ui-bootstrap.js') }}"></script>
        <script src="{{ asset('build/vendor/js/navbar.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-cookies.js') }}"></script>
        <script src="{{ asset('build/vendor/js/query-string.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-oauth2.js') }}"></script>

        <script src="{{ asset('build/js/app/app.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/LoginCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/HomeCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/ErrorCtrl.js') }}"></script>
    @else
        <script src="{{ elixir('js/all.js') }}"></script>
    @endif
</body>
</html>