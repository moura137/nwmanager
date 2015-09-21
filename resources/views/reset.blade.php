@extends('app')

@section('title')
| Recuperação de Senha
@endsection

@section('content')
    
<div ng-controller="ResetCtrl">
    
    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Recuperação de Senha</h2>

                    <div ng-include src="'build/views/_errors.html'"></div>

                    <div class="alert alert-success" ng-show="success">
                        <strong>SENHA ALTERADA COM SUCESSO!</strong>
                        <div>Faça o login com sua nova senha.</div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12" ng-show="user">
                            <p>
                                Digite sua nova senha.
                            </p>
                            <form class="m-t" role="form" name="formReset" ng-submit="send()">
                                <input type="hidden" id="token" name="token" value="{{ $token }}" />
                                <input type="hidden" id="email" name="email" value="{{ $email }}" />

                                <div class="form-group">
                                    <label>E-mail: </label> {{ $email }}
                                </div>

                                <div class="form-group" ng-class="{'has-error': !formReset.password.$valid && formReset.password.$touched}">
                                    <label for="password">Senha</label>
                                    <input type="password" required name="password" class="form-control" placeholder="Senha" ng-model="data.password" />
                                    <div ng-messages="formReset.password.$error" class="help-block" ng-show="formReset.password.$touched">
                                        <span ng-message="required">Campo obrigatório</span>
                                    </div>
                                </div>

                                <div class="form-group" ng-class="{'has-error': !formReset.password_confirmation.$valid && formReset.password_confirmation.$touched}">
                                    <label for="password">Confirmação Senha</label>
                                    <input type="password" required name="password_confirmation" class="form-control" placeholder="Confirmação Senha" ng-model="data.password_confirmation" />
                                    <div ng-messages="formReset.password_confirmation.$error" class="help-block" ng-show="formReset.password_confirmation.$touched">
                                        <span ng-message="required">Campo obrigatório</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Enviar</button>
                            </form>
                        </div>

                        <div class="col-lg-12" ng-hide="user">
                            <a href="/login" class="btn btn-white block">Login</a>
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