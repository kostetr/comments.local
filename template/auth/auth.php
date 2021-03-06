<form method="post" action="/auth/signin">
    <div class="login">
        <div class="login-screen">
            <div class="app-title">
                <h1>Авторизация</h1>
            </div>
            <?php if ($_SESSION['Errors']['auth'] !== null): ?>
                <div class="alert alert-danger alert-registr" role="alert">Ошибка:                    
                        <p><?= $_SESSION['Errors']['auth'] ?></p>                    
                </div>
            <?php endif ?>
            <?php if ( $_SESSION['message']['succesRegistr'] !== null && $_SESSION['Errors']['auth'] == null): ?>
                <div class="alert alert-success alert-registr" role="alert">
                    <p><?= $_SESSION['message']['succesRegistr']?></p>
                </div>
            <?php endif ?>
                        <div class="login-form">
                <div class="control-group">
                    <input type="text" class="login-field" value="" placeholder="Логин" name="login" id="login-name" autofocus/>
                    <label class="login-field-icon fui-user" for="login-name"></label>
                </div>
                <div class="control-group">
                    <input type="password" class="login-field" value="" placeholder="Пароль" name="password" id="login-pass"/>
                    <label class="login-field-icon fui-lock" for="login-pass"></label>
                </div>
                <input type="submit" class="btn btn-primary btn-large btn-block" value="Войти"/>
                <a class="login-link" href="/auth/register">Регистрация</a>
            </div>
        </div>
    </div>
</form>  