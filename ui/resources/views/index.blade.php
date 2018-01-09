<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>TropicEnt Test</title>

    <!-- Styles -->
    <link href="css/bootstrap.min.css" media="all" rel="stylesheet" />
    <link href="css/app.css" media="all" rel="stylesheet" />
</head>
<body>
<div class="content">
    <div class="container">
        <h1>Теги и фото для статьи</h1>
        <form id="article-helper">
            <table class="table">
                <tr>
                    <td colspan="2">
                        <div class="form-group">
                            <lable for="article">Статья</lable>
                            <textarea title="Article" id="article" name="article" class="form-control"></textarea>
                            <p class="help-block">Вставье текст статьи, содержащей слово кошка или собака</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn btn-primary submit-button">Подобрать теги и фото</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <ul class="list-group" id="tags">

                            </ul>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <ul class="list-group" id="photo">
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
