<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <?php if ($this->menu == 0): ?>                                
                <a class="nav-link active" href="<?= \core\Router::root() ?>">Мои библиотеки</a>                              
            <?php else: ?>                                
                <a class="nav-link" href="<?= \core\Router::root() ?>">Мои библиотеки</a>
            <?php endif ?> 
        </li>
        <li class="nav-item">
            <?php if ($this->menu == 1): ?>                                
                <a class="nav-link active" href="<?= \core\Router::root() ?>/CP/check">Материал на проверку</a>                            
            <?php else: ?>                                
                <a class="nav-link" href="<?= \core\Router::root() ?>/CP/check">Материал на проверку</a>
            <?php endif ?> 
        </li>
        <li class="nav-item">
            <?php if ($this->menu == 2): ?>                                
                <a class="nav-link active" href="<?= \core\Router::root() ?>/CP/search">Поиск корпусов</a>                            
            <?php else: ?>                                
                <a class="nav-link" href="<?= \core\Router::root() ?>/CP/search">Поиск корпусов</a>
            <?php endif ?> 
        </li>
		<li class="nav-item">
            <?php if ($this->menu == 3): ?>                                
                <a class="nav-link active" href="<?= \core\Router::root() ?>/CP/notes">Заметки</a>                            
            <?php else: ?>                                
                <a class="nav-link" href="<?= \core\Router::root() ?>/CP/notes">Заметки</a>
            <?php endif ?> 
        </li>
		<li class="nav-item">
            <?php if ($this->menu == 4): ?>                                
                <a class="nav-link active" href="<?= \core\Router::root() ?>/CP/profile">Профиль пользователя</a>                            
            <?php else: ?>                                
                <a class="nav-link" href="<?= \core\Router::root() ?>/CP/profile">Профиль пользователя</a>
            <?php endif ?> 
        </li>
        <?php if ($_SESSION['access_level'] == 100 || $_SESSION['access_level'] == 50): ?>                                
            <li class="nav-item">
                <a href="<?= \core\Router::root() ?>/admin" class="nav-link">Админ панель</a>          
            </li> 
        <?php endif ?> 
        <li class="rightbutton">
            <a href="<?= \core\Router::root() ?>/auth/exit" class="btn btn-secondary">Выход</a>
        </li>        
    </ul>
</div>

