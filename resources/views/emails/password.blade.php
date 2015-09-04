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
            <a href="{{ url('password/reset/'.$token) }}" target="_blank">Link para Recuperar a Senha</a>
        </p>
        <p>
            Por favor, clique imediatamente no link acima, 
            pois o mesmo será válido até a data de {{ \Carbon\Carbon::now()->addMinutes(60) }}.
        </p>
        </div>
    </body>
</html>