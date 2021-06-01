<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a class="nav-link" href="<?= \core\Router::root() ?>">На главную</a>
        </li>
        <li class="nav-item">
            <?php if ($this->menu == 0): ?>                                
                <a class="nav-link active" href="<?= \core\Router::root() ?>/admin">Коментарии для Администратора</a>                              
            <?php else: ?>                                
                <a class="nav-link" href="<?= \core\Router::root() ?>/admin">Коментарии для Администратора</a>
            <?php endif ?> 
        </li>
        <li class="nav-item">
            <?php if ($this->menu == 1): ?>                                
                <a class="nav-link active" href="<?= \core\Router::root() ?>/admin/files">Работа с файлами и корпусами</a>                            
            <?php else: ?>                                
                <a class="nav-link" href="<?= \core\Router::root() ?>/admin/files">Работа с файлами и корпусами</a>
            <?php endif ?> 
        </li>
        <li class="nav-item">
            <?php if ($this->menu == 2): ?>                                
                <a class="nav-link active" href="<?= \core\Router::root() ?>/admin/alltasks">Журнал зананий</a>                            
            <?php else: ?>                                
                <a class="nav-link" href="<?= \core\Router::root() ?>/admin/alltasks">Журнал зананий</a>
            <?php endif ?> 
        </li>
        <li class="nav-item">
            <?php if ($this->menu == 3): ?>                                
                <a class="nav-link active" href="<?= \core\Router::root() ?>/admin/search">Поиск корпусов</a>                            
            <?php else: ?>                                
                <a class="nav-link" href="<?= \core\Router::root() ?>/admin/search">Поиск корпусов</a>
            <?php endif ?> 
        </li>		
        <li class="nav-item">
            <?php if ($this->menu == 4): ?>                                
                <a class="nav-link active" href="<?= \core\Router::root() ?>/admin/db">Работа с БД</a>                            
            <?php else: ?>                                
                <a class="nav-link" href="<?= \core\Router::root() ?>/admin/db">Работа с БД</a>
            <?php endif ?> 
        </li>
        <li class="rightbutton">
            <a href="<?= \core\Router::root() ?>/auth/exit" class="btn btn-secondary">Выход</a>
        </li>        
    </ul>
</div>

