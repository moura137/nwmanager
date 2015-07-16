<!DOCTYPE html>
<html>
    <head>
        <title>Page Not Found</title>

        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style type="text/css">
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                font-weight: 100;
                font-family: 'Lato';
                margin: 10px;
            }

            .container {
                max-width: 550px;
                margin: 0 auto;
            }

            .content {
                color: #B0BEC5;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Page Not Found.</div>
            </div>
        </div>
        @include('errors.exception')
    </body>
</html>
