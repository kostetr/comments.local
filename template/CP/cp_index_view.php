<div class="card text-center">
<?php include_once 'cp_menu_view.php'; ?>
    <div class="card-body">
        <?php include_once 'cp_message_view.php'; ?>
        <div class="list-group">
<div class="list-group-item list-group-item-action list-group-item-secondary">Название файла | Название библиотеки</div>		
            <?php foreach ($this->files as $file_item): ?>  
                <a href="<?= \core\Router::root() ?>/CP/library/?menu=<?= $this->menu ?>&id=<?= $file_item['id'] ?>" class="list-group-item list-group-item-action list-group-item-secondary"><?= $file_item['file_name'] . ' | ' . $file_item['name'] ?></a>
            <?php endforeach ?>    
        </div>
		</div>
</div>



