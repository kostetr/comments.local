<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
        <div class="list-group"> 
            <p>Выберете файл в который будет перемещен корпус:</p>
            <?php foreach ($this->files as $file_item): ?>  
                <form method="POST" action="/admin/alltasks">   
                    <input type="hidden" name="file_id" value="<?= $file_item['id'] ?>  ">
                    <input type="hidden" name="file" value="1">                    
                    <input type="hidden" name="file_name" value="<?= $file_item['file_name'] ?>  ">
                    <input type="submit" class="list-group-item list-group-item-action list-group-item-secondary" value="<?= 'Название файла - ' . $file_item['file_name'] . ' | Название библиотеки - ' . $file_item['name'] ?>">   
                </form>             
            <?php endforeach ?>              
               <a href="<?= \core\Router::root() ?>/admin/alltasks/" class="list-group-item list-group-item-action list-group-item-secondary">Отмена</a>
        </div>
    </div>
</div>