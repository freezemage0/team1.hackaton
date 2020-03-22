<?php
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="<?=$this::DEFAULT_TEMPLATES_FOLDER .'css/core/bootstrap.min.css';?>">
    <link rel="stylesheet" href="<?=$this::DEFAULT_TEMPLATES_FOLDER .'css/user/style.css';?>">
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
                                    <input type="text" id="log-login" name="LOGIN" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="log-pass">Пароль</label>
                                    <input type="password" class="form-control" id="log-pass" name="PASSWORD" required>
                                </div>

                                <button class="btn btn-outline-primary">Войти</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <form action="user/authorize" method="post">

                                <div class="form-group">
                                    <label for="reg-log">Логин</label>
                                    <input type="text" id="reg-log" name="LOGIN" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="reg-pass">Пароль</label>
                                    <input type="password" class="form-control" id="reg-pass" name="PASSWORD" required>
                                </div>

                                <div class="form-group">
                                    <label for="reg-pass-conf">Повторите пароль</label>
                                    <input type="password" class="form-control" id="reg-pass-conf" name="CONFIRM" required>
                                    <div class="invalid-feedback">
                                        Введи это кал правильно, плиз :)
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="reg-name">Имя</label>
                                    <input type="text" class="form-control" id="reg-name" name="NAME" required>
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

<script src="<?=$this::DEFAULT_TEMPLATES_FOLDER .'js/core/jquery-3.4.1.min.js';?>"></script>
<script src="<?=$this::DEFAULT_TEMPLATES_FOLDER .'js/core/bootstrap.min.js';?>"></script>
<script src="<?=$this::DEFAULT_TEMPLATES_FOLDER .'js/user/script.js';?>"></script>
</body>
</html>
