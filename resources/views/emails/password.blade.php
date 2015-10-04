<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Recuperação de Senha</h2>

        <p>
            Conforme sua solicitação de recuperação de senha de acesso, 
            esta sendo enviado link para finalizar o processo de geraçãp da nova senha.
        </p>
        <p>
            <a href="{{ route('home') }}/#/reset?{{ http_build_query(['token' => $token, 'email' => $user->email]) }}" target="_blank">Clique aqui para Recuperar a Senha</a>
        </p>
        <p>
            Por favor, clique imediatamente no link acima, pois o mesmo será expirar.
        </p>
        </div>
    </body>
</html>