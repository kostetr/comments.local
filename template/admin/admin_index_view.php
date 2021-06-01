<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
        <p><b>Перечень библиотек с комментарием к Администратору:</b></p>
		<div class="list-group-item list-group-item-action list-group-item-secondary"> Название файла | Название библиотеки</div>
          <?php if ($this->listEmpty): ?>
		  <p>Комментарии отсутствуют</p>
		  <?php else: ?>
		  		  <?php $i=1; foreach ($this->list as $list_item): ?>
					<a name="<?= $i ?>"></a>				  
                <form method="POST" action="/admin/commentforadm">   
                    <input type="hidden" name="file_id" value="<?= $list_item['file_id'] ?>">                   
					<input type="hidden" name="menu" value="<?= $this->menu ?>">					
                    <input type="submit" class="list-group-item list-group-item-action list-group-item-secondary" value="<?= $list_item['file_name'] . ' | ' . $list_item['library_name'] ?>">   
                </form>             
            <?php endforeach ?>  
		  <?php endif; ?>
		  

    </div>
</div>