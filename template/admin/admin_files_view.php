<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">        
        <div class="list-group"> 
            <?php include_once 'admin_message_view.php'; ?>
            <div>

                <table class="table table-bordered table-sm ">
                    <tr>
                        <td><input size="60" type="text" name="file_name" form="new_file" autocomplete="off" placeholder="Имя файла без расширения" required></td>
                        <td><input size="60"  type="text" name="name" form="new_file" autocomplete="off" placeholder="Название библиотеки" required></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <form method="POST" id="new_file" action="/admin/addnewfile">                                                        
                                <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Добавить файл">   
                            </form>
                        </td>
                    </tr>
                </table>
                <hr>
            </div>
            <div>
                <p><b>Выберите файл для редактирования:</b></p>
                <form id="deletefiles" method="POST" action="/admin/deletefiles">                                       
                    <input type="submit" class="btn btn-secondary btn-sm" onclick="if (confirm('Вы уверены? Файлы будут удалены вместе с корпусами безвозвратно!'))
                                return true;
                            else
                                return false;" value="Удалить выбранные корпуса">      
                </form></br>
                <table class="table table-bordered table-sm ">
                    <tr>
                        <th rowspan="2">№</th>
                        <th>Имя файла</th>                                          
                        <th rowspan="2" width="95">Готово</th> 
                        <th rowspan="2">Сдали</th>
                        <th rowspan="2" width="35" class="allpatterns-align-center-container"><div class="allpatterns-align-center"><input type="checkbox"  class="allpatterns-checkbox"  id="all" name="all_chack" value="all_chack"></div></th>
                        <th rowspan="2">Действие</th>
                    </tr>
                    <tr>
                        <th>Название библиотеки</th>    
                    </tr>
                    <?php
                    $i = 1;
                    foreach ($this->files as $file_item):
                        ?>  
                        <tr>
                            <td rowspan="2" width="1"><a name="<?= $file_item['id'] ?>"><?= $i ?><a/></td>
                            <td><b><?= $file_item['file_name'] ?></b></td>

                            <?php if ($file_item['completed'] == 1): ?>
                                <td  rowspan="2" class="list-group-item-success" ><?= $file_item['completed_date'] ?></td>
                            <?php else: ?>
                                <td  rowspan="2" class="list-group-item-danger" ></td>
                            <?php endif ?>

                            <?php if ($file_item['job_delivery'] == 1): ?>
                                <td  rowspan="2" class="list-group-item-success" width="1"></td>
                            <?php else: ?>
                                <td   rowspan="2" class="list-group-item-danger" width="1"></td>
                            <?php endif ?>      
                            <td rowspan="2" width="1" class="allpatterns-align-center-container"><div class="allpatterns-align-center"><input type="checkbox" form="deletefiles" class="allpatterns-checkbox not-all-pattern-selected"  name="check_<?= $file_item['id'] ?>" value="<?= $file_item['id'] ?>"></div></td>

                            <td  rowspan="2" width="170">
                                <a href="<?= \core\Router::root() ?>/admin/editfile/?menu=<?= $this->menu ?>&id=<?= $file_item['id'] ?>" class="list-group-item list-group-item-action list-group-item-secondary">Редактировать</a>
                            </td>
                        </tr>
                        <tr>
                            <td><?= $file_item['name'] ?></td>
                        </tr>
                        <?php
                        $i++;
                    endforeach
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>