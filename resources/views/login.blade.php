@extends('app')

@section('title')
| Login
@endsection

@section('content')

<div class="middle-box loginscreen animated fadeInDown">
    <div ng-controller="LoginCtrl">
        <h2>Login</h2>

        <div include-scope src="build/views/templates/form-login.html"></div>

        <div class="m-t" align="center">
            <a href="/forgot"><small>Esqueceu sua senha?</small></a>
        </div>
        <p class="m-t" align="center"> <small>copyright &copy; 2015</small> </p>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('body').addClass('gray-bg');
    });
</script>
@endsection