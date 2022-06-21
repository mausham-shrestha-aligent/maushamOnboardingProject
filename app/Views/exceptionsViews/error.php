<?php
require_once ROOT_PATH.'/../app/Views/template/header.php';;
?>
<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
        <h1><?=$this->params['code']?></h1>
        <p class="fs-3"> <span class="text-danger">Opps!</span>Error found during request</p>
        <p class="lead">
            <?php echo $this->params['error'] ?>
        </p>
        <a href="/<?=$this->params['route']?>" class="btn btn-primary">Go <?=$this->params['page']?></a>
    </div>
</div>