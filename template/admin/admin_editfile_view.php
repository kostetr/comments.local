<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
        <?php include_once 'admin_message_view.php'; ?>
        <b>Редактировать файл:</b>
        <table class="table table-bordered table-sm ">
            <tr>
                <th>Имя файла без расширения:</th>
                <th>Имя библиотеки:</th>
            </tr>
            <tr>
                <td><input type="text" name="file_name" form="update_file" value="<?= $this->files[0]['file_name'] ?>" autocomplete="off"></td>
                <td><input type="text" name="name" form="update_file" value="<?= $this->files[0]['name'] ?>" autocomplete="off"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <form method="POST" id="update_file" action="/admin/updatefile">   
                        <input type="hidden" name="id" value="<?= $this->files[0]['id'] ?>">           
						<input type="hidden" name="menu" value="<?= $this->menu ?>">      
                        <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Сохранить">   
                    </form>
                </td>
            </tr>
        </table>
        <a href="<?= \core\Router::root() ?>/admin/allpatterns/?menu=<?= $this->menu ?>&id=<?= $this->files[0]['id'] ?>" class="list-group-item list-group-item-action list-group-item-secondary">Показать все корпуса данной библиотеки:</a>
        <?php if($this->menu==1): ?>
		<a href="<?= \core\Router::root() ?>/admin/files/#<?= $this->files[0]['id'] ?>" class="list-group-item list-group-item-action list-group-item-secondary">Вернуться назад</a>
		<?php elseif($this->menu==2): ?>
		<a href="<?= \core\Router::root() ?>/admin/alltasks/#<?= $this->files[0]['id'] ?>" class="list-group-item list-group-item-action list-group-item-secondary">Вернуться назад</a>
		<?php endif; ?>





    </div>
</div>