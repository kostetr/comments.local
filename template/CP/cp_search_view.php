<div class="card text-center">
    <?php include_once 'cp_menu_view.php'; ?>
    <div class="card-body">
        <?php include_once 'cp_message_view.php'; ?>
        <div class="list-group"> 
            <div class="input-group mb-3">
                <input id="search" name="search" form="form-search" type="text" class="form-control" placeholder="Введите имя корпуса" aria-label="Recipient's username">
                <div class="input-group-append">
                    <form id="form-search" method="POST" action="/CP/search">
                        <input type="hidden" name="pattern_id" value="<?= $library_item['pattern_id'] ?>">
                        <input type="submit" class="input-group-text" value="Найти">
                    </form>                    
                </div>
            </div>
            </hr>
            <div>
                <?php if (isset($this->patterns)): ?>
                <p>Найдено:</p></br>
                    <?php $i=1;
                    foreach ($this->patterns as $pattern_item): ?>  
							<a name="<?= $i ?>"></a>
                            <form method="POST" action="/CP/addcoment">
                                <input type="hidden" name="pattern_id" value="<?= $pattern_item['pattern_id'] ?>">
                                <input type="hidden" name="file_id" value="<?= $pattern_item['file_id'] ?>">
                                <input type="hidden" name="pattern_name" value="<?= $pattern_item['pattern_name'] ?>">
                                <input type="hidden" name="completed" value="<?= $pattern_item['completed'] ?>">
                                <input type="hidden" name="checked" value="<?= $pattern_item['checked'] ?>">                                
                                <input type="hidden" name="comments" value="<?= $pattern_item['comments'] ?>">	
                                <input type="hidden" name="anchor" value="<?= $i ?>">
								<input type="hidden" name="menu" value="<?= $this->menu ?>">
                                <input type="hidden" name="search" value="<?= $this->patternSearch ?>">
                                <input type="submit" class="list-group-item list-group-item-action list-group-item-secondary" value="<?= $pattern_item['file_name'].' | '. $pattern_item['pattern_name']?>">
                            </form>
                    <?php $i++;
                    endforeach; ?>       
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>



