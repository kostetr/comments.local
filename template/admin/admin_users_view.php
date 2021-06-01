<div class="card text-center">
    <?php include_once 'admin_menu_view.php'; ?>
    <div class="card-body">
        <div class="list-group"> 
            <p>Выберете пользователя::</p>
            <?php
            $i = 1;
            foreach ($this->users as $user):
                ?>  
                <form method="POST" action="/admin/alltasks">   
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">					
                    <?php if ($this->type_user == 'user'): ?>
                        <input type="hidden" name="type_user" value="user">
                        <input type="hidden" name="snp" value="<?= $user['snp'] ?>">
                    <?php else: ?>
                        <input type="hidden" name="type_user" value="checker">
                        <input type="hidden" name="snp" value="<?= $user['snp'] ?>">
                    <?php endif; ?>
                    <input type="submit" class="list-group-item list-group-item-action list-group-item-secondary" value="<?= $i . ' - ' . $user['surname'] . ' ' . $user['name'] . ' ' . $user['patronymic'] ?>">   
                </form>             
                <?php $i++;
            endforeach; ?>  
            <a href="<?= \core\Router::root() ?>/admin/alltasks/" class="list-group-item list-group-item-action list-group-item-secondary">Отмена</a>
        </div>
    </div>
</div>

