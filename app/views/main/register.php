<link href="/js/jquery-entropizer-master/dist/css/jquery-entropizer.css" rel="stylesheet">
<div class="container">
    <div class="col-lg-6 col-md-6 col-sm-10 col-xs-10">
        <form action="/main/register" method="post" id="form-register">
            <div class="form-group">
                <label for="id-name">Введите имя</label>
                <input type="text" class="form-control" name="name" id="id-name" aria-describedby="name" placeholder="Логин">
            </div>
            <div class="form-group">
                <label for="id-login">Логин</label>
                <input type="text" class="form-control" name="login" id="id-login" placeholder="Введите логин">
            </div>
            <div class="form-group">
                <label for="id-psw">Введите пароль</label>
                <input type="password" class="form-control" name="psw" id="id-psw" placeholder="Введите пароль">
                <div id="meter"></div>
            </div>
            <div class="form-group">
                <label for="id-confirm-password">Повторите пароль</label>
                <input type="password" class="form-control" name="confirm-psw" id="id-confirm-password" placeholder="Повторите пароль">
            </div>
            <button type="button" id="reg-button" class="btn btn-primary">Зарегистрироваться</button>
        </form>
    </div>
</div>
<script src="/js/register.js"></script>
<script src="/js/jquery-entropizer-master/lib/entropizer.js"></script>
<script src="/js/jquery-entropizer-master/dist/js/jquery-entropizer.min.js"></script>