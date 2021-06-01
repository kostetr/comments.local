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
                <tr>                    
                    <td><?= $this->pattern['pattern_name'] ?></td>
                    <td><?= $this->pattern['comments'] ?></td>
                    <?php if ($this->pattern['completed'] == 0): ?>
                        <td class="cell-length, list-group-item-danger"></td>
                    <?php else: ?>
                        <td class="cell-length, list-group-item-success"></td>
                    <?php endif ?>

                    <?php if ($this->pattern['checked'] == 0): ?>
                        <td class="cell-length, list-group-item-danger"></td>
                    <?php else: ?>
                        <td class="cell-length, list-group-item-success"></td>
                    <?php endif ?>                     
                </tr>
            </table>
            <div>                  
                <div class="d-flex justify-content-center">
                    <form method="POST" action="/CP/savecoment">
                        <input type="hidden" name="pattern_id" value="<?= $this->pattern['pattern_id'] ?>">
                        <input type="hidden" name="file_id" value="<?= $this->pattern['file_id'] ?>"> 
                        <input type="hidden" name="anchor" value="<?= $this->pattern['anchor'] ?>"> 
			<input type="hidden" name="menu" value="<?= $this->pattern['menu'] ?>">
                        <input type="hidden" name="search" value="<?= $this->pattern['search'] ?>">
                        <input type="hidden" name="many" value="false">   
                        <p><b>Введите комментарий:</b></p>
                        <p><textarea rows="5" cols="130" name="coments" required></textarea></p>
                        <input type="checkbox" name="comment_for_adm" value="1"> Комментарий для Администратора</p>
                        <p><input type="submit" class="list-group-item list-group-item-action list-group-item-secondary" value="Добавить комментарий"></p>
                        <?php if ($this->pattern['menu'] == 2): ?>
                            <a href="<?= \core\Router::root() ?>/CP/search/?search=<?= $this->pattern['search'] ?>#<?= $this->pattern['anchor'] ?>" class="list-group-item list-group-item-action list-group-item-secondary">Отмена</a>
                        <?php else: ?>
                            <a href="<?= \core\Router::root() ?>/CP/library/?menu=<?= $this->pattern['menu'] ?>&id=<?= $this->pattern['file_id'] ?>#<?= $this->pattern['anchor'] ?>" class="list-group-item list-group-item-action list-group-item-secondary">Отмена</a>
                        <?php endif; ?>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>



