<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
        <div class="list-group"> 
            <p>Выберете файл в который будет перемещен корпус:</p>
            <?php foreach ($this->files as $file_item): ?>  
                <form method="POST" action="/admin/savepatterninfile2">   
                    <input type="hidden" name="id" value="<?= $file_item['id'] ?>  ">
                    <input type="hidden" name="pattern_id" value="<?= $this->pattern['pattern_id'] ?>  ">
                    <input type="hidden" name="old_file_id" value="<?= $this->pattern['old_file_id'] ?>  ">
					<input type="hidden" name="menu" value="<?= $this->menu ?>  ">
                    <input type="hidden" name="anchor" value="<?= $this->pattern['anchor'] ?>  ">
					<?php if ($this->menu == 3): ?>
					<input type="hidden" name="search" value="<?= $this->pattern['search'] ?>">                    
                    <?php endif; ?>

                    <input type="submit" class="list-group-item list-group-item-action list-group-item-secondary" value="<?= 'Название файла - ' . $file_item['file_name'] . ' | Название библиотеки - ' . $file_item['name'] ?>">   
                </form>             
            <?php endforeach ?>    
            <?php if ($this->menu == 3): ?>
                <a href="<?= \core\Router::root() ?>/admin/search/?anchor=<?= $this->pattern['anchor'] ?>&search=<?= $this->pattern['search'] ?>" class="list-group-item list-group-item-action list-group-item-secondary">Отмена</a>
            <?php else: ?>
                <a href="<?= \core\Router::root() ?>/admin/editpattern/?menu=<?= $this->menu ?>&id=<?= $this->pattern['pattern_id'] ?>" class="list-group-item list-group-item-action list-group-item-secondary">Отмена</a>
            <?php endif; ?>

        </div>
    </div>
</div>