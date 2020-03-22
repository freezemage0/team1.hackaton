<?php
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="<?=$this::DEFAULT_TEMPLATES_FOLDER .'/css/core/bootstrap.min.css';?>">
    <link rel="stylesheet" href="<?=$this::DEFAULT_TEMPLATES_FOLDER .'/assets/css/user/style.css';?>">
</head>
<body>

<section class="user">
    <div class="container">
        <div class="row">
            <div class="col-4 mx-auto">
                <div class="user-container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Авторизация</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Регистрация</a>
                        </li>
                    </ul>

                    <div class="tab-content p-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form action="/user/login" method="post">

                                <div class="form-group">
                                    <label for="log-login">Логин</label>
                                    <input type="text" id="log-login" name="login" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="log-pass">Пароль</label>
                                    <input type="password" class="form-control" id="log-pass" name="password" required>
                                </div>

                                <button class="btn btn-outline-primary">Войти</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <form action="user/register" method="post">

                                <div class="form-group">
                                    <label for="reg-log">Логин</label>
                                    <input type="text" id="reg-log" name="login" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="reg-pass">Пароль</label>
                                    <input type="password" class="form-control" id="reg-pass" name="password" required>
                                </div>

                                <div class="form-group">
                                    <label for="reg-pass-conf">Повторите пароль</label>
                                    <input type="password" class="form-control" id="reg-pass-conf" name="password_confirm" required>
                                    <div class="invalid-feedback">
                                        Введи это кал правильно, плиз :)
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="reg-name">Имя</label>
                                    <input type="text" class="form-control" id="reg-name" name="name" required>
                                </div>

                                <button class="btn btn-outline-primary">Зарегистрироваться</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>

<script src="<?=$this::DEFAULT_TEMPLATES_FOLDER .'/assets/js/core/jquery-3.4.1.min.js';?>"></script>
<script src="<?=$this::DEFAULT_TEMPLATES_FOLDER .'/assets/js/core/bootstrap.min.js';?>"></script>
<script src="<?=$this::DEFAULT_TEMPLATES_FOLDER .'/assets/js/user/script.js';?>"></script>
</body>
</html>
