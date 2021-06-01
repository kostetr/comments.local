<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
        <?php include_once 'admin_message_view.php'; ?>
        <b>Редактировать корпус:</b>
        <table class="table table-bordered table-sm ">            
            <tr>
                <th>Файл:</th>
                <td><?= $this->file[0]['file_name'] ?></td>
                <td>
                    <form method="POST" action="/admin/allfiles2">   
                        <input type="hidden" name="pattern_id" value="<?= $this->pattern[0]['id'] ?>"> 
                        <input type="hidden" name="old_file_id" value="<?= $this->file[0]['id'] ?>">
						<input type="hidden" name="menu" value="<?= $this->menu ?>">  
                        <input type="hidden" name="anchor" value="<?= $this->anchor ?>">  
						<?php if ($this->menu == 3): ?>
                            <input type="hidden" name="search" value="<?= $this->search ?>">
                        <?php endif; ?>
                        <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Выбрать файл">   
                    </form>
                </td>
            </tr>
            <tr>
                <th>Имя библиотеки:</th>                
                <td colspan="2"><input type="text" name="pattern_name" form="update_pattern"  value="<?= $this->pattern[0]['pattern_name'] ?>" autocomplete="off"></td>
            </tr>
            <tr>
                <th rowspan="3">Комментарий:</th>
                <td colspan="2">
                    <p><textarea rows="5" cols="100" name="pattern_comments"form="update_pattern" ><?= $this->pattern[0]['comments'] ?></textarea></p>
                </td>
            </tr>
            <tr> 
                <?php if ($this->pattern[0]['completed'] == 1): ?>                
                    <td colspan="2"><input type="checkbox" name="completed" value="1" form="update_pattern" checked>Корпус готов.</td>
                <?php else: ?>              
                    <td colspan="2"><input type="checkbox" name="completed" value="1" form="update_pattern" >Корпус готов.</td>
                <?php endif; ?>
            </tr>
            <tr>                   
                <?php if ($this->pattern[0]['checked'] == 1): ?>                
                    <td colspan="2"><input type="checkbox" name="checked" value="1" form="update_pattern" checked>Корпус проверен.</td>
                <?php else: ?>              
                    <td colspan="2"><input type="checkbox" name="checked" value="1" form="update_pattern" >Корпус проверен.</td>
                <?php endif; ?>
            </tr>
            <tr>
                <td colspan="3">
                    <form method="POST" id="update_pattern" action="/admin/updatepattern">   
                        <input type="hidden" name="id" value="<?= $this->pattern[0]['id'] ?>">
                        <input type="hidden" name="file_id" value="<?= $this->pattern[0]['file_id'] ?>">
						<input type="hidden" name="menu" value="<?= $this->menu ?>"> 
                        <input type="hidden" name="anchor" value="<?= $this->anchor ?>"> 
                        <?php if ($_SESSION['old_file_id'] != NULL): ?>
                            <input type="hidden" name="old_file_id" value="<?= $_SESSION['old_file_id'] ?>">
                        <?php endif; ?>
                        <?php if ($this->menu == 3): ?>
                            <input type="hidden" name="search" value="<?= $this->search ?>">
                        <?php endif; ?>
                        <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Сохранить">   
                    </form>
                </td>
            </tr>
        </table> 
        <?php if ($this->menu == 3): ?>
            <a href="<?= \core\Router::root() ?>/admin/search/?menu=<?= $this->menu ?>&search=<?= $this->search ?>#<?= $this->anchor ?>" class="list-group-item list-group-item-action list-group-item-secondary">Вернуться назад</a>
        <?php else: ?>
            <?php if ($_SESSION['old_file_id'] != NULL): ?>
                <a href="<?= \core\Router::root() ?>/admin/allpatterns/?menu=<?= $this->menu ?>&id=<?= $_SESSION['old_file_id'] ?>#<?= $this->anchor ?>" class="list-group-item list-group-item-action list-group-item-secondary">Вернуться назад</a>
            <?php else: ?>
                <a href="<?= \core\Router::root() ?>/admin/allpatterns/?menu=<?= $this->menu ?>&id=<?= $this->file[0]['id'] ?>#<?= $this->anchor ?>" class="list-group-item list-group-item-action list-group-item-secondary">Вернуться назад</a>
            <?php endif; ?>


        <?php endif; ?>

    </div>
</div>