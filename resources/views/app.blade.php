<!DOCTYPE html>
<html lang="pt-br" ng-app="App">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NwManager @yield('title')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    @if(config('app.debug'))
        <link href="{{ asset('build/vendor/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('build/vendor/css/jasny-bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('build/vendor/css/sweetalert.css') }}" rel="stylesheet" />
        <link href="{{ asset('build/vendor/css/bootstrap-datepicker3.css') }}" rel="stylesheet" />
        <link href="{{ asset('build/vendor/css/nouislider.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('build/css/animate.css') }}" rel="stylesheet" />
        <link href="{{ asset('build/css/inspinia.css') }}" rel="stylesheet" />
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
    
    @yield('content')

    <!-- Scripts -->
    @if(config('app.debug'))
        <script src="{{ asset('build/vendor/js/jquery.js') }}"></script>
        <script src="{{ asset('build/vendor/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('build/vendor/js/jasny-bootstrap.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-route.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-sanitize.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-resource.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-animate.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-messages.js') }}"></script>
        <script src="{{ asset('build/vendor/js/ui-bootstrap.js') }}"></script>
        <script src="{{ asset('build/vendor/js/ui-bootstrap-tpls.js') }}"></script>
        <script src="{{ asset('build/vendor/js/navbar.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-cookies.js') }}"></script>
        <script src="{{ asset('build/vendor/js/query-string.js') }}"></script>
        <script src="{{ asset('build/vendor/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('build/vendor/js/bootstrap-datepicker.pt-BR.min.js') }}"></script>
        <script src="{{ asset('build/vendor/js/nouislider.js') }}"></script>
        <script src="{{ asset('build/js/app/libraries/angular-nouislider.js') }}"></script>
        <script src="{{ asset('build/vendor/js/angular-file-upload.min.js') }}"></script>
        <script src="{{ asset('build/js/app/libraries/angular-oauth2.js') }}"></script>
        <script src="{{ asset('build/vendor/js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('build/vendor/js/jquery.fileDownload.js') }}"></script>
        <script src="{{ asset('build/js/env-config.js') }}"></script>

        <script src="{{ asset('build/js/app/app.js') }}"></script>
        
        <!-- Controllers -->
        <script src="{{ asset('build/js/app/controllers/client/ClientListCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/client/ClientShowCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/client/ClientNewCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/client/ClientEditCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/client/ClientDeleteCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/user/UserListCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/user/UserNewCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/user/UserEditCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/user/UserDeleteCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project/ProjectListCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project/ProjectShowCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project/ProjectNewCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project/ProjectEditCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project/ProjectDeleteCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project-member/ProjectMemberListCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project-note/ProjectNoteListCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project-note/ProjectNoteNewCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project-note/ProjectNoteEditCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project-note/ProjectNoteDeleteCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project-file/ProjectFileImagesCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project-file/ProjectFileListCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project-file/ProjectFileNewCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/project-file/ProjectFileDeleteCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/LoginCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/ForgotCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/ResetCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/HomeCtrl.js') }}"></script>
        <script src="{{ asset('build/js/app/controllers/ErrorCtrl.js') }}"></script>
        
        <!-- Services -->
        <script src="{{ asset('build/js/app/services/auth-user.js') }}"></script>
        <script src="{{ asset('build/js/app/services/client.js') }}"></script>
        <script src="{{ asset('build/js/app/services/user.js') }}"></script>
        <script src="{{ asset('build/js/app/services/project.js') }}"></script>
        <script src="{{ asset('build/js/app/services/project-note.js') }}"></script>
        <script src="{{ asset('build/js/app/services/project-file.js') }}"></script>

        <!-- Factories -->
        <script src="{{ asset('build/js/app/factories/httpProviderInterceptor.js') }}"></script>
        <script src="{{ asset('build/js/app/factories/http-buffer.js') }}"></script>

        <!-- Providers -->
        <script src="{{ asset('build/js/app/providers/settings-provider.js') }}"></script>

        <!-- Directives -->
        <script src="{{ asset('build/js/app/directives/format-dates.js') }}"></script>
        <script src="{{ asset('build/js/app/directives/input-file.js') }}"></script>
        <script src="{{ asset('build/js/app/directives/upload-ng-thumb.js') }}"></script>
        <script src="{{ asset('build/js/app/directives/loading.js') }}"></script>
        <script src="{{ asset('build/js/app/directives/project-file-download.js') }}"></script>

        <!-- Filters -->
        <script src="{{ asset('build/js/app/filters/app-filters.js') }}"></script>
        <script src="{{ asset('build/js/app/filters/project-filters.js') }}"></script>

        <script src="{{ asset('build/js/admin.js') }}"></script>

    @else
        <script src="{{ elixir('js/all.js') }}"></script>
        <script src="{{ asset('build/js/env-config.js') }}"></script>
    @endif

    @yield('scripts')
    <div class="back-loading" class="ng-hide" loading>
        <div class="backdrop"></div>
        <div class="text-top"><i class="fa fa-spinner fa-pulse"></i>&nbsp;Carregando...</div>
    </div>
</body>
</html>