<form method="post" action="/verification/add" id="registerForm">
    <div class="login">
        <div class="login-screen">
            <div class="app-title">
                <h1>Регистрация</h1>
            </div>
            <div class="control-group">

<?php if (isset($_GET['token'])): ?>

                <input type="text" class="login-field" placeholder="" name="token" id="name" autocomplete="off" value="<?= $_GET['token']  ?>" required>
<?php else: ?>

                <input type="text" class="login-field" placeholder="" name="token" id="name" autocomplete="off" required>

<?php endif ?>


                <label class="login-field-icon fui-user" for="token"></label>
            </div>
            <input type="submit" id="submit" class="btn btn-primary btn-large btn-block" value="Подтвердить пользователя"/>                    
        </div>            
    </div>    
</form>
