<?php if ($_SESSION['Errors'] !== NULL): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($_SESSION['Errors'] as $value): ?>
            <?= $value ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if ($_SESSION['message'] !== NULL): ?>            
    <div class="alert alert-success" role="alert">
        <?php foreach ($_SESSION['message'] as $value): ?>
            <?= $value ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

