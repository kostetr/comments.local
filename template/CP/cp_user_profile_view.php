<div class="card text-center">
    <?php include_once 'cp_menu_view.php'; ?>
    <div class="card-body">
        <?php include_once 'cp_message_view.php'; ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="/CP/saveprofile">
                            <table class="profile-center">                            
                                <tr>
                                    <td class="profile-width-table">Фамилия:</td>
                                    <td>                        
                                        <input type="text" class="login-field" name="surname" id="surname" autocomplete="off" value="<?= $this->user['surname'] ?>" required>
                                        <label class="login-field-icon fui-user" for="surname"></label>
                                    </td>                                
                                </tr>
                                <tr>
                                    <td>Имя:</td>
                                    <td>
                                        <input type="text" class="login-field" name="name" id="name" autocomplete="off" value="<?= $this->user['name'] ?>" required>
                                        <label class="login-field-icon fui-user" for="name"></label>
                                    </td>                                
                                </tr>
                                <tr>
                                    <td>Отчество:</td>
                                    <td>
                                        <input type="text" class="login-field" name="patronymic" id="patronymic" autocomplete="off" value="<?= $this->user['patronymic'] ?>" required>
                                        <label class="login-field-icon fui-user" for="patronymic"></label>
                                    </td>                                
                                </tr>
                                <tr>
                                    <td>Дата рождения:</td>
                                    <td>
                                        <input type="text" class="login-field" name="birthday" id="birthday" autocomplete="off" value="<?= $this->user['birthday'] ?>">
                                        <label class="login-field-icon fui-user" for="birthday"></label>
                                    </td>                                
                                </tr>
                                <tr>
                                    <td>Моб. телефон:</td>
                                    <td>
                                        <input type="text" class="login-field" name="phone" id="phone" autocomplete="off" value="<?= $this->user['phone'] ?>">
                                        <label class="login-field-icon fui-user" for="phone"></label>
                                    </td>                                
                                </tr>
                                <tr>                                
                                    <td colspan="2">
                                        <select name="gender_id" class="form-control" id="gender_id" required>
                                            <option disabled selected>Пол</option>
                                            <?php foreach ($this->gender as $gender_item): ?> 
                                                <?php if ($this->user['gender_id'] == $gender_item['id']): ?> 
                                                    <option value="<?= $gender_item['id'] ?>" selected><?= $gender_item['name'] ?></option>
                                                <?php else: ?>
                                                    <option value="<?= $gender_item['id'] ?>"><?= $gender_item['name'] ?></option>
                                                <?php endif; ?>

                                            <?php endforeach ?>
                                        </select>
                                    </td>                                
                                </tr>
                                <tr>
                                    <td colspan="2"> <input type="submit" id="submit" class="btn btn-primary btn-large btn-block" value="Сохранить" /></td>                              
                                </tr>                            
                            </table>   
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body"> 
                        <form method="POST" action="/CP/savenewpassword">
                            <table class="profile-center">
                                <tr>
                                    <td class="profile-50proc">Новый пароль:</td>
                                    <td>
                                        <input type="password" class="profile-width-input login-field" name="password" id="pass" oninput="FunctionPassCheck()" required>
                                        <label class="login-field-icon fui-lock" for="pass"></label>
                                    </td>                                
                                </tr>
                                <tr>
                                    <td>Подтвердите пароль:</td>
                                    <td>
                                        <input type="password" class="profile-width-input login-field" name="password_confirm" id="pass-confirm" oninput="FunctionPassCheck()" required>
                                        <label class="login-field-icon fui-lock" for="pass-confirm"></label>
                                    </td>                                
                                </tr>
                                <tr>
                                    <td colspan="2"><input type="submit" id="submitnewpass" class="btn btn-primary btn-large btn-block" value="Сохранить" disabled />  </td>
                                </tr>
                            </table>   
                        </form>
                    </div>                    
                </div>
            </div>
        </div>



    </div>
</div>
<script>
    function fieldColor(erorColor, id) {
        if (erorColor == 1) {
            $('#' + id).css('background-color', '#90EE90');
        } else {
            $('#' + id).css('background-color', '#FFB6C1');
        }
    }

    function FunctionPassCheck() {
        if ($("#pass").val() != $("#pass-confirm").val() || $("#pass").val().length == 0 || $("#pass-confirm").val().length == 0 || $("#pass").val().length < 6 || $("#pass-confirm").val().length < 6) {
            fieldColor(0, 'pass');
            fieldColor(0, 'pass-confirm');
            $('#submitnewpass').attr('disabled', 'disabled');
        } else {
            fieldColor(1, 'pass');
            fieldColor(1, 'pass-confirm');
            $('#submitnewpass').removeAttr('disabled');
        }
        
    }
    ;
</script>

