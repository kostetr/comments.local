<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
        <?php include_once 'admin_message_view.php'; ?>
        <div>
            <b>Выдача задания:</b>
            <table class="table table-bordered table-sm ">
                <tr>
                    <th width="200">Исполнитель:</th>
                    <td colspan="2"><?= $this->user1 ?></td>
                    <td width="200">              
                        <form method="POST" action="/admin/selectuser">
                            <input type="hidden" name="type_user" value="user">
							<input type="hidden" name="menu" value="<?= $this->menu ?>">
                            <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Выбрать">   
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Проверяющий:</th>
                    <td colspan="2"><?= $this->user2 ?></td>
                    <td>
                        <form method="POST" action="/admin/selectuser">
                            <input type="hidden" name="type_user" value="checker">
							<input type="hidden" name="menu" value="<?= $this->menu ?>">
                            <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Выбрать">   
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Файл:</th>
                    <td colspan="2"><?= $this->file ?></td>
                    <td>
                        <form method="POST" action="/admin/allfiles3">
							<input type="hidden" name="menu" value="<?= $this->menu ?>">
                            <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Выбрать">   
                        </form>
                    </td>
                </tr>
                <tr>
				    <td>
                    </td>
                    <td>
					    <form method="POST" action="/admin/cleartask">
                            <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Очистить">   
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="/admin/savetask">
                            <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom" value="Добавить">   
                        </form>
                    </td>
				    <td>
                    </td>
                </tr>
            </table>




        </div>
        <hr>
        <table class="table table-bordered table-sm ">
            <tr>
                <th colspan="7" class="text-center">Перечень выданных заданий:</th>
            </tr>
            <tr>
                <th>#</th>
                <th>Название файла:</th>
                <th>Название Библиотеки:</th>
                <th>Готовность файла:</th>
                <th>Ответственный:</th>
                <th>Проверил:</th>
                <th>Действие:</th>
            </tr>
            <?php
            $i = 1;
            foreach ($this->tasks as $task_item):
                ?>
                <tr>
                    <td><a name="<?= $task_item['id'] ?>"></a><?= $i ?></td>
                    <td><?= $task_item['file_name'] ?></td>
                    <td><?= $task_item['name'] ?></td>
                    <?php if ($task_item['completed'] == NULL): ?>
                        <td class="cell-length, list-group-item-danger" nowrap></td>
                    <?php else: ?>
                        <td class="cell-length, list-group-item-success" nowrap><?= $task_item['completed_date'] ?></td>
                    <?php endif ?>
                    <td><?= $task_item['user_snp'] ?></td>
                    <td><?= $task_item['user_check_snp'] ?></td>
                    <td>
						<form method="POST" action="/admin/edittask">
                            <input type="hidden" name="file_id" value="<?= $task_item['id'] ?>">    
							<input type="hidden" name="file_name" value="<?= $task_item['file_name'] ?>">   
							<input type="hidden" name="user_id" value="<?= $task_item['user_id'] ?>">   
							<input type="hidden" name="user_snp" value="<?= $task_item['user_snp'] ?>">   
							<input type="hidden" name="user_check_id" value="<?= $task_item['user_check_id'] ?>">   
							<input type="hidden" name="user_check_snp" value="<?= $task_item['user_check_snp'] ?>">
							<input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom mt-1" value="Редактировать">   
                        </form>						 
						<form method="POST" action="/admin/canceltask">                            
                            <input type="hidden" name="file_id" value="<?= $task_item['id'] ?>">                            
                            <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom mt-1" onclick="if(confirm('Вы уверены?')) return true; else return false;" value="Отмена">   
                        </form>
						<a href="<?= \core\Router::root() ?>/admin/editfile/?menu=<?= $this->menu ?>&id=<?= $task_item['id'] ?>" class="btn btn-secondary btn-sm btn-block align-bottom mt-1">Открыть файл</a>
                        <form method="POST" action="/admin/jobdelivery">
                            <input type="hidden" name="anchor" value="<?= $i ?>">
                            <input type="hidden" name="file_id" value="<?= $task_item['id'] ?>">
                            <input type="hidden" name="completed" value="<?= $task_item['completed'] ?>">
                            <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom mt-1" onclick="if(confirm('Вы уверены?')) return true; else return false;" value="Файл сдал">   
                        </form>

                    </td>
                </tr>
                <?php
                $i++;
            endforeach;
            ?>
        </table>
    </div>    
</div>