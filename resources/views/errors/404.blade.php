<!DOCTYPE html>
<html>
    <head>
        <title>系統訊息</title>
        <link rel="stylesheet" href="/css/app.css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title" style="font-size: 30px;">您輸入了錯誤的網址! </div>
                <div>&nbsp;</div>
                <div>
                    <a class="btn btn-warning" href="#" onclick="history.back(1);return false;">返回上一頁</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn btn-info" href="/">回首頁</a>
                </div>
            </div>
        </div>
    </body>
</html>
