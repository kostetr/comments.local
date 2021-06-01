<script>
    var passError = "<?php echo $_SESSION['Errors']['registr']['pass'] ?>";
    var loginError = "<?php echo $_SESSION['Errors']['registr']['login'] ?>";
</script>
<form method="post" action="adduser" id="registerForm">
    <div class="login">
        <div class="login-screen">
            <div class="app-title">
                <h1>Регистрация</h1>
            </div>
            <?php if ($_SESSION['Errors']['registr'] !== null): ?>
                <div class="alert alert-danger alert-registr" role="alert">Ошибки:
                    <?php foreach ($_SESSION['Errors']['registr'] as $error_item): ?>
                        <p><?= $error_item ?></p>
                    <?php endforeach ?>
                </div>

                <div class="login-form">
                    <div class="control-group input-wrapper">
                        <input type="text" class="login-field " placeholder="Логин" name="login" id="login" value="<?= $_SESSION['user']['login'] ?>" oninput="functionRegLoginChange()" autocomplete="off">
                        <label class="login-field-icon fui-user" for="login"></label>
                    </div>                
                    <div class="control-group">
                        <input type="password" class="login-field" placeholder="Пароль" name="password" id="pass" oninput="passwordСheck()" required>
                        <label class="login-field-icon fui-lock" for="pass"></label>
                    </div>
                    <div class="control-group">
                        <input type="password" class="login-field"  placeholder="Подтвердите пароль" name="password_confirm" id="pass-confirm" oninput="passwordСheck()" required>
                        <label class="login-field-icon fui-lock" for="pass-confirm"></label>
                    </div>
                    <div class="control-group">
                        <input type="text" class="login-field" placeholder="Фамилия" name="surname" id="surname" value="<?= $_SESSION['user']['surname'] ?>" autocomplete="off" oninput="functionRegSurnameChange()" required>
                        <label class="login-field-icon fui-user" for="surname"></label>
                    </div>
                    <div class="control-group">
                        <input type="text" class="login-field" placeholder="Имя" name="name" id="name" value="<?= $_SESSION['user']['name'] ?>" autocomplete="off" oninput="functionRegNameChange()"  required>
                        <label class="login-field-icon fui-user" for="name"></label>
                    </div>
                    <div class="control-group">
                        <input type="text" class="login-field" placeholder="Отчество" name="patronymic" id="patronymic" value="<?= $_SESSION['user']['patronymic'] ?>" autocomplete="off" oninput="functionRegPatronymicChange()" required>
                        <label class="login-field-icon fui-user" for="patronymic"></label>
                    </div>
                    <div class="select-width">                    
                        <select name="gender_id" class="form-control" id="gender_id" required>
                            <option disabled selected>Пол</option>
                            <?php foreach ($this->gender as $gender_item): ?>  
                                <?php if ($gender_item['id'] == $_SESSION['user']['gender_id']): ?>
                                    <option selected  value="<?= $gender_item['id'] ?>"><?= $gender_item['name'] ?></option>
                                <?php else: ?>
                                    <option value="<?= $gender_item['id'] ?>"><?= $gender_item['name'] ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <input type="submit" id="submit" class="btn btn-primary btn-large btn-block" value="Зарегистрироваться" disabled />
                    <a class="login-link" href="/auth">Уже зарегистрированы? Войти.</a>
                </div>
            <?php else: ?>
                <div class="login-form">
                    <div class="control-group input-wrapper">
                        <input type="text" class="login-field " placeholder="Логин" name="login" id="login" autocomplete="off" oninput="functionRegLoginChange()" required>
                        <label class="login-field-icon fui-user" for="login"></label>
                    </div>                
                    <div class="control-group">
                        <input type="password" class="login-field" placeholder="Пароль" name="password" id="pass" oninput="passwordСheck()" required>
                        <label class="login-field-icon fui-lock" for="pass"></label>
                    </div>
                    <div class="control-group">
                        <input type="password" class="login-field"  placeholder="Подтвердите пароль" name="password_confirm" id="pass-confirm" oninput="passwordСheck()" required>
                        <label class="login-field-icon fui-lock" for="pass-confirm"></label>
                    </div>
                    <div class="control-group">
                        <input type="text" class="login-field" placeholder="Фамилия" name="surname" id="surname" autocomplete="off" oninput="functionRegSurnameChange()" required>
                        <label class="login-field-icon fui-user" for="surname"></label>
                    </div>
                    <div class="control-group">
                        <input type="text" class="login-field" placeholder="Имя" name="name" id="name" autocomplete="off" oninput="functionRegNameChange()" required>
                        <label class="login-field-icon fui-user" for="name"></label>
                    </div>
                    <div class="control-group">
                        <input type="text" class="login-field" placeholder="Отчество" name="patronymic" id="patronymic" autocomplete="off" oninput="functionRegPatronymicChange()" required>
                        <label class="login-field-icon fui-user" for="patronymic"></label>
                    </div>
                    <div class="select-width">                    
                        <select name="gender_id" class="form-control" id="gender_id" required>
                            <option disabled selected>Пол</option>
                            <?php foreach ($this->gender as $gender_item): ?>  
                                <option value="<?= $gender_item['id'] ?>"><?= $gender_item['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <input type="submit" id="submit" class="btn btn-primary btn-large btn-block" value="Зарегистрироваться" disabled />
                    <a class="login-link" href="/auth">Уже зарегистрированы? Войти.</a>
                </div>
            <?php endif ?>
        </div>
    </div>
</form>
