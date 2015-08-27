@extends('app')

@section('title')
| Login
@endsection

@section('content')
    
<div ng-controller="LoginCtrl">
        
<div class="middle-box loginscreen animated fadeInDown">
    <div>
        <h2>Login</h2>
        
        <div ng-include src="'build/views/_errors.html'"></div>

        <form class="m-t" role="form" name="formLogin" ng-submit="login()">
            <div class="form-group" ng-class="{'has-error': !formLogin.username.$valid && formLogin.username.$touched}">
                <input type="text" required name="username" class="form-control" placeholder="Usuário" ng-model="user.username" />
                <div ng-messages="formLogin.username.$error" class="help-block" ng-show="formLogin.username.$touched">
                    <span ng-message="required">Campo obrigatório</span>
                </div>
            </div>
            <div class="form-group" ng-class="{'has-error': !formLogin.password.$valid && formLogin.password.$touched}">
                <input type="password" required name="password" class="form-control" placeholder="Senha" ng-model="user.password">
                <div ng-messages="formLogin.password.$error" class="help-block" ng-show="formLogin.password.$touched">
                    <span ng-message="required">Campo obrigatório</span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Entrar</button>

            <div align="center">
                <a href="#"><small>Esqueceu sua senha?</small></a>
            </div>
        </form>
        
        <p class="m-t" align="center"> <small>copyright &copy; 2015</small> </p>
    </div>
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