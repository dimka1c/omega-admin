<div class="container">
    <div class="col-lg-6 col-md-6 col-sm-10 col-xs-10">
        <div class="row">
            <?php if ($this->issetFlash('registration')):  ?>
                <div class="alert alert-success" role="alert">
                    <?= $this->getFlash('registration') ?>
                </div>
            <?php endif ?>
            <?php if ($this->issetFlash('error-login')):  ?>
                <div class="alert alert-danger" role="alert">
                    <?= $this->getFlash('error-login') ?>
                </div>
            <?php endif ?>
        </div>
        <form action="/main/login" method="post" id="id-login-form">
            <div class="form-group">
                <label for="name-user">Имя пользователя</label>
                <input type="text" class="form-control" name="login-name" id="name-user" aria-describedby="name-user" placeholder="Введите имя">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="login-password" id="password" placeholder="Пароль">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember-me" name="login-remember">
                <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
                <div>
                    <a href="/main/register">Зарегистрироваться</a>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>
</div>

