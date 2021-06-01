<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
        <?php include_once 'admin_message_view.php'; ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Сохранить резервную копию</h5>
                        <p class="card-text">Перечень стольбцов:</br>
                            Название файла;Название библиотеки;Название Корпуса;Комментарий</br>                    
                        </p>     
                        <a href="<?= \core\Router::root() ?>/admin/savecsvfrombd" class="btn btn-primary">Сохранить</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Email администратора</h5>
                        <p class="card-text">Адрес почтового ящика используется для подтверждения новых пользователей.</br>
                            <input type="text" form="adm-email" name="new-adm-email" size="50" value="<?= $this->emailAdm['email'] ?>"/>
                        </p>     
                        <form id="adm-email" action="/admin/updateemail" method="POST">
                            <input type="submit" class="btn btn-primary" value="Изменить">   
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Загрузить CSV в БД</h5>
                        <p class="card-text">Перечень стольбцов:</br>
                            Название файла;Название библиотеки;Название Корпуса;Комментарии</br>
                            _sop,soic_p0.65;SOP SOIC Pitch 0.65mm;LINEAR_05-08-1660</br>
                            На сервере ограничение по работе скрипта. Поэтому если файл очень большой поделите его на несколько частей.
                        </p>                
                        <form enctype="multipart/form-data" action="/admin/fileinbd" method="POST">
                            <input name="CSV" type="file" accept=".csv" />
                            <input type="submit" class="btn btn-primary" value="Выбрать">   
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">


                        <h5 class="card-title">Пользователи с правами Администратора:</h5>
                        <table class="table table-bordered table-sm ">
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">Login</th>
                                <th scope="col">ФИО</th>
                                <th scope="col">Access Level</th>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($this->adminList as $admin):
                                ?>                            
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $admin['login'] ?></td>
                                    <td><?= $admin['snp'] ?></td>
                                    <?php if ($admin['access_level'] == 50): ?>
                                        <td>Root</td>                                    
                                    <?php else: ?>
                                        <td>Admin</td> 
                                    <?php endif; ?>
                                </tr>
                                <?php
                                $i++;
                            endforeach;
                            ?>   
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Все пользователи:</h5>
                        <table class="table table-bordered table-sm ">
                            <tr>
                                <th>№</th>
                                <th>Login:</th>
                                <th>ФИО:</th>
                                <th>Моб. телефон:</th>
                                <th>Дата рождения:</th>
                                <th>Зарегестрирован:</th>
                                <th>Действия:</th>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($this->userList as $user):
                                ?>                            
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $user['login'] ?></td>
                                    <td><?= $user['snp'] ?></td>
                                    <td><?= $user['phone'] ?></td>
                                    <td><?= $user['birthday'] ?></td>
                                    <td><?= $user['registered'] ?></td>
                                    <td>

                                        <form class="submit-left" method="POST" action="/admin/resetpassword">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>" />                                            
                                            <input type="hidden" name="snp" value="<?= $user['snp'] ?>" />                                            
                                            <input type="submit" class="btn btn-primary btn-sm" value="Reset Pass (499949)"> 
                                        </form>
                                        <?php if ($user['access_level'] == 200): ?>
                                            <form class="submit-left" method="POST" action="/admin/changeaccesslevel">
                                                <input type="hidden" name="id" value="<?= $user['id'] ?>" />    
                                                <input type="hidden" name="snp" value="<?= $user['snp'] ?>" />   
                                                <input type="hidden" name="access_level" value="<?= $user['access_level'] ?>" />                                            
                                                <input type="submit" class="btn btn-primary btn-sm" value="Make Admin">  
                                            </form>                                    
                                        <?php elseif ($user['access_level'] == 100): ?>
                                            <form class="submit-left" method="POST" action="/admin/changeaccesslevel">
                                                <input type="hidden" name="id" value="<?= $user['id'] ?>" /> 
                                                <input type="hidden" name="snp" value="<?= $user['snp'] ?>" />   
                                                <input type="hidden" name="access_level" value="<?= $user['access_level'] ?>" />                                            
                                                <input type="submit" class="btn btn-primary btn-sm" value="Make User">  
                                            </form>   
                                        <?php endif; ?>
                                        <?php if ($user['access_level'] >= 100): ?>
                                            <?php if ($user['verified'] == 1): ?>
                                                <form class="submit-left" method="POST" action="/admin/blockuser">
                                                    <input type="hidden" name="id" value="<?= $user['id'] ?>" />  
                                                    <input type="hidden" name="verified" value="<?= $user['verified'] ?>" />   
                                                    <input type="hidden" name="snp" value="<?= $user['snp'] ?>" />     
                                                    <input type="submit" class="btn btn-primary btn-sm" value="unBlock"> 
                                                </form>   
                                            <?php elseif ($user['verified'] == 2): ?>
                                                <form class="submit-left" method="POST" action="/admin/blockuser">
                                                    <input type="hidden" name="id" value="<?= $user['id'] ?>" />   
                                                    <input type="hidden" name="verified" value="<?= $user['verified'] ?>" />   
                                                    <input type="hidden" name="snp" value="<?= $user['snp'] ?>" />     
                                                    <input type="submit" class="btn btn-primary btn-sm" value="Block"> 
                                                </form>   
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                                <?php
                                $i++;
                            endforeach;
                            ?>   
                        </table>
                    </div>
                </div>
            </div>




        </div>

    </div>
</div>