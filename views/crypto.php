<?php

use app\core\Application;

?>
<h1 class="text-center">Welcome, <?php
    echo Application::$app->user->firstname . " " . Application::$app->user->lastname; ?></h1>


    <?php
    /** @var array $valutes */
    if(!isset($valutes['error'])){ ?>
<div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
        <?php
    foreach ($valutes as $valute) { ?>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h3 class="my-0 fw-normal"><?php
                        echo $valute['symbol'] ?></h3>
                </div>
                <div class="card-body">
                    <h3 class="card-title pricing-card-title">$<?php
                        echo substr($valute['price'], 0, -6) ?>
                    </h3>
                </div>
            </div>
        </div>
    <?php
    }} else { ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php echo $valutes['error'] ?>
        </div>
   <?php } ?>
</div>