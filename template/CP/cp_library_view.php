<div class="card text-center">
    <?php include_once 'cp_menu_view.php'; ?>

    <div class="card-body">
        <?php include_once 'cp_message_view.php'; ?>
        <div class="list-group"> 
            <form id="action-form" method="POST" action="/CP/actionForm"> 
                <input type="hidden" name="menu" value="<?= $this->menu ?>">
                <input type="hidden" name="file_id" value="<?= $this->file_id ?>">
                <?php if ($this->menu == 0): ?>                                

                    <input type="submit" class="btn btn-secondary btn-sm" name="completed" value="Завершить выбранные корпуса">                                    

                    <input type="submit" class="btn btn-secondary btn-sm" name="notCompleted" value="Выбранные корпуса не готовы">   

                <?php elseif($this->menu == 1): ?>                             

                    <input type="submit" class="btn btn-secondary btn-sm" name="checked" value="Проверил выбранные корпуса">                                    

                    <input type="submit" class="btn btn-secondary btn-sm" name="notChecked" value="Выбранные корпуса не готовы">   

                <?php endif ?>                     
                    <input type="submit" class="btn btn-secondary btn-sm" name="addCommentToAll" value="Добавить комментарии">
                    <input type="submit" class="btn btn-secondary btn-sm" name="saveCsvFile" value="Сохранить .csv">

            </form></br>
            <table class="table table-bordered table-sm ">
                <tr>
                    <th rowspan="2">№</th>
                    <th>Название корпуса</th>
                    <th rowspan="2">Админ</th>                    
                    <th rowspan="2">Готово</th>
                    <th rowspan="2">Пров.</th>
                    <th rowspan="2" width="35" class="allpatterns-align-center-container"><div class="allpatterns-align-center"><input type="checkbox" class="allpatterns-checkbox"  id="all" name="all" value="all"></div></th>
                    <th rowspan="2">Действие</th>
                </tr>
                <tr>
                    <th>Комментарии</th>    
                </tr>
                <?php
                $i = 1;
                foreach ($this->library as $library_item):
                    ?>  
                    <tr>
                        <td rowspan="2" width="1"><a name="<?= $i ?>"><?= $i ?><a/></td>
                        <td><b><?= $library_item['pattern_name'] ?></b></td>
                        <?php if ($library_item['comment_for_adm'] == 0): ?>
                            <td  rowspan="2" width="1" ></td>
                        <?php elseif ($library_item['comment_for_adm'] == 1): ?>
                            <td  rowspan="2" class="list-group-item-danger" width="1"></td>
                        <?php elseif ($library_item['comment_for_adm'] == 2): ?>
                            <td  rowspan="2" class="list-group-item-success" width="1"></td>								
                        <?php endif ?>


                        <?php if ($library_item['completed'] == 0): ?>
                            <td  rowspan="2" class="list-group-item-danger" width="1"></td>
                        <?php else: ?>
                            <td  rowspan="2" class="list-group-item-success" width="1"></td>
                        <?php endif ?>

                        <?php if ($library_item['checked'] == 0): ?>
                            <td   rowspan="2" class="list-group-item-danger" width="1"></td>
                        <?php else: ?>
                            <td  rowspan="2" class="list-group-item-success" width="1"></td>
                        <?php endif ?>
                        <td rowspan="2" width="1" class="allpatterns-align-center-container"><div class="allpatterns-align-center"><input type="checkbox" form="action-form" class="allpatterns-checkbox not-all-pattern-selected"  name="selected_<?= $library_item['pattern_id'] ?>" value="<?= $library_item['pattern_id'] ?>"></div></td>

                        <td  rowspan="2" width="170">
                            <form method="POST" action="/CP/completed">
                                <input type="hidden" name="pattern_id" value="<?= $library_item['pattern_id'] ?>">
                                <input type="hidden" name="file_id" value="<?= $library_item['file_id'] ?>">
                                <input type="hidden" name="completed" value="<?= $library_item['completed'] ?>"> 
                                <input type="hidden" name="checked" value="<?= $library_item['checked'] ?>"> 
                                <input type="hidden" name="menu" value="<?= $this->menu ?>"> 
                                <input type="hidden" name="anchor" value="<?= $i ?>">   
                                <?php if ($this->menu == 0): ?>                                
                                    <?php if ($library_item['completed'] == 0): ?>                                
                                        <input type="submit" class="btn btn-secondary btn-sm btn-block" value="Завершить корпус">                                    
                                    <?php else: ?>                                
                                        <input type="submit" class="btn btn-secondary btn-sm btn-block" value="Корпус не готов">   
                                    <?php endif ?>
                                <?php endif ?> 
                                <?php if ($this->menu == 1): ?>                                
                                    <?php if ($library_item['checked'] == 0): ?>                                
                                        <input type="submit" class="btn btn-secondary btn-sm btn-block" value="Проверил">                                    
                                    <?php else: ?>                                
                                        <input type="submit" class="btn btn-secondary btn-sm btn-block" value="Корпус не готов">   
                                    <?php endif ?>
                                <?php endif ?> 
                            </form>
                        </td>
                    </tr>
                    <tr>					
                        <td><?= $library_item['comments'] ?>
                            <form method="POST" action="/CP/addcoment">
                                <input type="hidden" name="pattern_id" value="<?= $library_item['pattern_id'] ?>">
                                <input type="hidden" name="file_id" value="<?= $library_item['file_id'] ?>">
                                <input type="hidden" name="pattern_name" value="<?= $library_item['pattern_name'] ?>">
                                <input type="hidden" name="completed" value="<?= $library_item['completed'] ?>">
                                <input type="hidden" name="checked" value="<?= $library_item['checked'] ?>">                                
                                <input type="hidden" name="comments" value="<?= $library_item['comments'] ?>">
                                <input type="hidden" name="menu" value="<?= $this->menu ?>"> 
                                <input type="hidden" name="anchor" value="<?= $i ?>">   
                                <input type="submit" class="btn btn-secondary btn-sm btn-block" value="Добавить комментарий">
                            </form>
                        </td>
                    </tr>
                    <?php
                    $i++;
                endforeach
                ?>
            </table>
        </div>

    </div>
</div>



