<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">        
        <div class="list-group"> 
            <?php include_once 'admin_message_view.php'; ?>
            <div>
                <b>Добавить корпус:</b>
                <table class="table table-bordered table-sm ">
                    <tr>
                        <th>Имя корпуса</th>
                        <td><input type="text" name="pattern_name" form="save-new-pattern" autocomplete="off" required></td>
                    </tr>
                    <tr>
                        <th>Комментарий</th>
                        <td colspan="2">
                            <p><textarea rows="10" cols="120" form="save-new-pattern" name="pattern_comments" placeholder="Заполнять не обязательно"></textarea></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <form method="POST" id="save-new-pattern" action="/admin/savenewpattern">   
                                <input type="hidden" name="file_id" value="<?= $this->file_id ?>">
                                <input type="hidden" name="menu" value="<?= $this->menu ?>">
                                <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Добавить новый корпус">   
                            </form>
                        </td>
                    </tr>
                </table>
                <a href="<?= \core\Router::root() ?>/admin/editfile/?menu=<?= $this->menu ?>&id=<?= $this->file_id ?>" class="list-group-item list-group-item-action list-group-item-secondary">Вернуться назад</a>        
                <hr>
            </div>
            <div>
                <p><b>Выберите корпус для редактирования:</b></p>
                <form id="deletepatterns" method="POST" action="/admin/deleteormovepatterns">
                    <input type="hidden" name="menu" value="<?= $this->menu ?>">
                    <input type="hidden" name="file_id" value="<?= $this->file_id ?>">
                    <input type="submit" class="btn btn-secondary btn-sm" name="delete" onclick="if(confirm('Вы уверены? Корпуса будут удалены безвозвратно!')) return true; else return false;" value="Удалить выбранные корпуса">      
                    <input type="submit" class="btn btn-secondary btn-sm" name="move" value="Переместить выбранные корпуса">      
                </form></br>
                <table class="table table-bordered table-sm ">
                    <tr>
                        <th rowspan="2">№</th>
                        <th>Название корпуса</th>
                        <th rowspan="2">Админ</th>                    
                        <th rowspan="2">Готово</th>
                        <th rowspan="2">Пров.</th>
                        <th rowspan="2" width="35" class="allpatterns-align-center-container"><div class="allpatterns-align-center"><input type="checkbox"  class="allpatterns-checkbox"  id="all" name="all_chack" value="all_chack"></div></th>
                        <th rowspan="2">Действие</th>
                    </tr>
                    <tr>
                        <th>Комментарии</th>    
                    </tr>
                    <?php
                    $i = 1;
                    foreach ($this->patterns as $pattern):
                        ?>  
                        <tr>
                            <td rowspan="2" width="1"><a name="<?= $i ?>"><?= $i ?><a/></td>
                            <td><b><?= $pattern['pattern_name'] ?></b></td>
                            <?php if ($pattern['comment_for_adm'] == 0): ?>
                                <td  rowspan="2" width="1" ></td>
                            <?php elseif ($pattern['comment_for_adm'] == 1): ?>
                                <td  rowspan="2" class="list-group-item-danger" width="1"></td>
                            <?php elseif ($pattern['comment_for_adm'] == 2): ?>
                                <td  rowspan="2" class="list-group-item-success" width="1"></td>								
                            <?php endif ?>

                            <?php if ($pattern['completed'] == 0): ?>
                                <td  rowspan="2" class="list-group-item-danger" width="1"></td>
                            <?php else: ?>
                                <td  rowspan="2" class="list-group-item-success" width="1"></td>
                            <?php endif ?>

                            <?php if ($pattern['checked'] == 0): ?>
                                <td   rowspan="2" class="list-group-item-danger" width="1"></td>
                            <?php else: ?>
                                <td  rowspan="2" class="list-group-item-success" width="1"></td>
                            <?php endif ?>      
                            <td rowspan="2" width="1" class="allpatterns-align-center-container"><div class="allpatterns-align-center"><input type="checkbox" form="deletepatterns" class="allpatterns-checkbox not-all-pattern-selected"  name="check_<?= $pattern['id'] ?>" value="<?= $pattern['id'] ?>"></div></td>

                            <td  rowspan="2" width="170">
                                <a href="<?= \core\Router::root() ?>/admin/editpattern/?menu=<?= $this->menu ?>&anchor=<?= $i ?>&id=<?= $pattern['id'] ?>" class="list-group-item list-group-item-action list-group-item-secondary">Редактировать</a>
                            </td>
                        </tr>
                        <tr>
                            <?php if (!empty($pattern['comments'])): ?>
                                <td><?= $pattern['comments'] ?></td>
                            <?php else: ?>
                                <td> - </td>
                            <?php endif ?>   

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

<script>
    function functionAllPatterns() {
        $("input:checkbox.allpatterns-align-center").attr('checked', this.checked);

    }
    ;
</script>