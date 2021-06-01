<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
        <?php include_once 'admin_message_view.php'; ?>
        <table class="table table-bordered table-sm ">
            <tr>
                <th>Файл</th>
                <td><?= $this->pattern['file_name'] ?></td>
                <td>
                    <form method="POST" action="/admin/allfiles">   
                        <input type="hidden" name="pattern_id" value="<?= $this->pattern['pattern_id'] ?>  "> 
						<input type="hidden" name="anchor" value="<?= $this->anchor ?>">	
						<input type="hidden" name="menu" value="<?= $this->menu ?>">
						<input type="hidden" name="file_id" value="<?= $this->file_id ?>">						
                        <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Выбрать файл">   
                    </form>
                </td>
            </tr>
            <tr>
                <th>Имя корпуса</th>
                <td><input type="text" name="new_pattern_name" form="new_pattern_name" value="<?= $this->pattern['pattern_name'] ?>" autocomplete="off"></td>
                <td>
                    <form method="POST" id="new_pattern_name" action="/admin/savenewpatternname">   
                        <input type="hidden" name="pattern_id" value="<?= $this->pattern['pattern_id'] ?>  ">
						<input type="hidden" name="anchor" value="<?= $this->anchor ?>">
						<input type="hidden" name="menu" value="<?= $this->menu ?>">
						<input type="hidden" name="file_id" value="<?= $this->file_id ?>">						
                        <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Сохранить новое имя">   
                    </form>
                </td>
            </tr>
            <tr>
                <th>Комментарий</th>
                <td colspan="2">
                    <form method="POST" action="/admin/savecomment">   
                        <input type="hidden" name="pattern_id" value="<?= $this->pattern['pattern_id'] ?>">
						<input type="hidden" name="anchor" value="<?= $this->anchor ?>">
						<input type="hidden" name="menu" value="<?= $this->menu ?>">
						<input type="hidden" name="file_id" value="<?= $this->file_id ?>">
                                                <p><textarea rows="10" cols="120" name="pattern_comments"><?= $this->pattern['pattern_comments'] ?></textarea></p>
                        <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Сохранить комментарий">   
                    </form>
                </td>
            </tr>

        </table>
<a href="<?= \core\Router::root() ?>/admin/commentforadm/?menu=<?= $this->menu ?>&file_id=<?= $this->file_id ?>#<?= $this->anchor ?>" class="list-group-item list-group-item-action list-group-item-secondary">Вернуться назад</a>
        
        
        
        
        
        
            </div>
        </div>