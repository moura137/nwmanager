@extends('app')

@section('title')
| Esquecia a Senha
@endsection

@section('content')
    
<div ng-controller="ForgotCtrl">
    
    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Esqueci a Senha</h2>

                    <div ng-include src="'build/views/_errors.html'"></div>

                    <div class="alert alert-success" ng-show="success">
                        <strong>EMAIL ENVIADO COM SUCESSO!</strong>
                        <div>Acesse seu email e veja como recuperar sua senha</div>
                    </div>

                    <div class="row">

                        <div class="col-lg-12" ng-hide="success">
                            <p>
                                Digite seu endereço de e-mail e uma form de recuperação da sua senha será enviada para você.
                            </p>

                            <form class="m-t" role="form" name="formForgot" ng-submit="send()">
                                <div class="form-group" ng-class="{'has-error': !formForgot.email.$valid && formForgot.email.$touched}">
                                    <input type="email" required name="email" class="form-control" placeholder="E-mail" ng-model="user.email" />
                                    <div ng-messages="formForgot.email.$error" class="help-block" ng-show="formForgot.email.$touched">
                                        <span ng-message="required">Campo obrigatório</span>
                                        <span ng-message="email">E-mail inválido</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Enviar</button>
                            </form>
                        </div>

                        <div class="col-lg-12">
                            <a href="/login" class="btn btn-white block full-width m-b">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-t" align="center"> <small>copyright &copy; 2015</small> </div>
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