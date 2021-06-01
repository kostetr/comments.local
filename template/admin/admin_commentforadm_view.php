<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
	<?php include_once 'admin_message_view.php'; ?>
        <table class="table table-bordered table-sm ">
            <tr>
                <th rowspan="3">№</th>
                <th>Файл</th>
                <th>Название</th>
                <th rowspan="3">Ответственный</th>
                <th rowspan="3">Проверяющий</th>
                <th rowspan="3">Действие</th>
            </tr>
            <tr>			
                <th colspan="2">Имя корпуса</th>
            </tr>
            <tr>
                <th colspan="2">Коментарий</th>
            </tr>  
			

            <?php
            $i = 1;
            foreach ($this->libsWithComment as $library_item):
                ?>  



                <tr>
                    <td rowspan="3"><a name="<?= $i ?>"></a><?= $i ?></td>
                    <td><b><?= $library_item['file_name'] ?></b></td>
                    <td><b><?= $library_item['library_name'] ?></b></td>
                    <?php if ($library_item['pattern_completed'] == 0): ?>
                        <td rowspan="3" class="cell-length, list-group-item-danger" nowrap><?= $library_item['user_snp'] ?></td>
                    <?php else: ?>
                        <td rowspan="3" class="cell-length, list-group-item-success" nowrap><?= $library_item['user_snp'] ?></td>
                    <?php endif ?>

                    <?php if ($library_item['pattern_checked'] == 0): ?>
                        <td rowspan="3" class="cell-length, list-group-item-danger" nowrap><?= $library_item['user_check_snp'] ?></td>
                    <?php else: ?>
                        <td rowspan="3" class="cell-length, list-group-item-success" nowrap><?= $library_item['user_check_snp'] ?></td>
                    <?php endif ?> 


                    <td rowspan="3">
                        <a href="<?= \core\Router::root() ?>/admin/edit/?menu=<?= $this->menu ?>&anchor=<?= $i ?>&file_id=<?= $library_item['file_id'] ?>&id=<?= $library_item['pattern_id'] ?>" class="btn btn-secondary btn-sm btn-block align-bottom mt-1">Редактировать</a>
                        <form method="POST" action="/admin/updatecommentforadm">
                            <input type="hidden" name="anchor_i" value="<?= $i ?>">
                            <input type="hidden" name="pattern_id" value="<?= $library_item['pattern_id'] ?>">
							<input type="hidden" name="menu" value="<?= $this->menu ?>">
							<input type="hidden" name="file_id" value="<?= $library_item['file_id'] ?>">
							<input type="hidden" name="val" value="2">
                            <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom mt-1" onclick="if(confirm('Вы уверены, что завершили работу с комментарием?')) return true; else return false;" value="Комментарий обработан">   
                        </form>
						<form method="POST" action="/admin/updatecommentforadm">
                            <input type="hidden" name="anchor_i" value="<?= $i ?>">
                            <input type="hidden" name="pattern_id" value="<?= $library_item['pattern_id'] ?>">
							<input type="hidden" name="menu" value="<?= $this->menu ?>">
							<input type="hidden" name="file_id" value="<?= $library_item['file_id'] ?>">
							<input type="hidden" name="val" value="0">
                            <input type="submit" class="btn btn-secondary btn-sm btn-block align-bottom mt-1" onclick="if(confirm('Вы уверены?')) return true; else return false;" value="Отмена">   
                        </form>
                    </td>
                </tr>
                <tr>			
                    <td colspan="2"><?= $library_item['pattern_name'] ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?= $library_item['pattern_comments'] ?></td>
                </tr>  





                <?php
                $i++;
            endforeach
            ?>
        </table>
		<a href="<?= \core\Router::root() ?>/admin/" class="list-group-item list-group-item-action list-group-item-secondary">Отмена</a>
    </div>
</div>