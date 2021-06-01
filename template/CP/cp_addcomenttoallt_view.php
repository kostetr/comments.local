<div class="card text-center">
    <?php include_once 'cp_menu_view.php'; ?>
    <div class="card-body">
        <?php include_once 'cp_message_view.php'; ?>
        <div class="list-group"> 
            <table class="table table-bordered table-sm ">
                <tr>                    
                    <th>Название корпуса</th>
                    <th>Коментарии</th>
                    <th>Готово</th>
                    <th>Проверено</th>                    
                </tr>
                <?php foreach ($this->patterns as $item_pattern): ?>
                    <tr>                    
                        <td><?= $item_pattern['pattern_name'] ?></td>
                        <td><?= $item_pattern['comments'] ?></td>
                        <?php if ($item_pattern['completed'] == 0): ?>
                            <td class="cell-length, list-group-item-danger"></td>
                        <?php else: ?>
                            <td class="cell-length, list-group-item-success"></td>
                        <?php endif ?>

                        <?php if ($item_pattern['checked'] == 0): ?>
                            <td class="cell-length, list-group-item-danger"></td>
                        <?php else: ?>
                            <td class="cell-length, list-group-item-success"></td>
                        <?php endif ?>                     
                    </tr>
                <?php endforeach; ?>  
            </table>
            <div>                  
                <div class="d-flex justify-content-center">
                    <form method="POST" action="/CP/savecoment">
                        <input type="hidden" name="file_id" value="<?= $this->file_id ?>"> 
                        <input type="hidden" name="menu" value="<?= $this->menu ?>">                        						
                        <input type="hidden" name="many" value="true">                        						
                        <p><b>Введите комментарий:</b></p>
                        <p><textarea rows="5" cols="130" name="coments" required></textarea></p>
                        <input type="checkbox" name="comment_for_adm" value="1"> Комментарий для Администратора</p>
                        <p><input type="submit" class="list-group-item list-group-item-action list-group-item-secondary" value="Добавить комментарий"></p>
                        <a href="<?= \core\Router::root() ?>/CP/library/?menu=<?= $this->menu ?>&id=<?= $this->file_id ?>" class="list-group-item list-group-item-action list-group-item-secondary">Отмена</a>


                    </form>
                </div>
            </div>
        </div>

    </div>
</div>



