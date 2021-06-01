<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
        <?php include_once 'admin_message_view.php'; ?>
        <div class="list-group"> 
            <div class="input-group mb-3">
                <input id="search" name="search" form="form-search" type="text" class="form-control" placeholder="Введите имя корпуса" aria-label="Recipient's username">
                <div class="input-group-append">
                    <form id="form-search" method="POST" action="/admin/search">
                        <input type="hidden" name="pattern_id" value="<?= $library_item['pattern_id'] ?>">						
                        <input type="submit" class="input-group-text" value="Найти">
                    </form>                    
                </div>
            </div>
            </hr>
            <div>
                <?php $i=1;
                if (isset($this->patterns)): ?>
                    <p>Найдено:</p></br>
                    <?php foreach ($this->patterns as $pattern_item): ?>                        
                        <a name="<?= $i ?>"></a> 
                        <a href="<?= \core\Router::root() ?>/admin/editpattern/?menu=<?= $this->menu ?>&anchor=<?= $i ?>&id=<?= $pattern_item['pattern_id'] ?>&search=<?= $this->patternSearch ?>" class="list-group-item list-group-item-action list-group-item-secondary"><?= $pattern_item['file_name'] . ' | ' . $pattern_item['pattern_name'] ?></a>
                    <?php $i++; endforeach; ?>       
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>



