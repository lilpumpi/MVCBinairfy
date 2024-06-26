<?php
//file: view/switchs/dashboard.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switchs = $view->getVariable("switchs");
$suscriptions = $view->getVariable("suscriptions");
$errors = $view->getVariable("errors");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("title", "Dashboard");
?>

<!-- Seccion donde se mostraran los switches encendidos del usuario, y se permitira apagarlos -->
<div class="switches">
    <h2>Switches</h2>

    <!-- Aqui se mostraran los switches de forma dinamica -->
    <div id="switches">

        <?php 
            if (!empty($switchs)) {
                foreach ($switchs as $switch): 
            ?>
                                
                <div class="switch-container">

                    <h3><?= $switch->getName(); ?></h3>
                    <p><?= $switch->getDescription(); ?></p>

                    <div class="icon-info" id="info-<?= $switch->getId(); ?>">
                        <a href="index.php?controller=switchs&amp;action=view&amp;private_id=<?= $switch->getPrivateId(); ?>"><i class="fa-solid fa-circle-info"></i></a>
                    </div>

                    <div class="cambiarEstado" style="display: <?= $switch->getStatus() ? 'block' : 'none'; ?>">
                        <form action="index.php?controller=switchs&amp;action=changeStatus&amp;status=false&amp;redirect=dashboard" method="post">
                            <input type="hidden" name="id" value="<?= $switch->getPrivateId(); ?>">
                            <button type="submit" class="btn-cambiarEstado" id="btn-apagar"><?= i18n("Turn off") ?></button>
                        </form>
                    </div>

                    <div class="cambiarEstado" style="display: <?= $switch->getStatus() ? 'none' : 'block'; ?>">
                        <button type="button" class="btn-cambiarEstado" id="btn-encender" onclick="openModal('<?= $switch->getPrivateId(); ?>', 'dashboard');"><?= i18n("Turn on") ?></button>
                    </div>

                </div>

            <?php 
                endforeach; 
            } else {
            ?>
                <div id="mensaje"><?= i18n("No switches") ?></div>
            <?php
            }
            ?>

    </div> 

</div>

<!-- Seccion donde se mostraran de forma muy generica los switches suscritos -->
<div class="suscripciones">
    <h2><?= i18n("Subscriptions") ?></h2>

    <!-- Aqui se mostraran las suscripciones de forma dinamica -->
    <div id="suscripciones">

        <?php 
        if (!empty($suscriptions)) {
            foreach ($suscriptions as $suscription): 
        ?>
                            
            <div class="suscripcion-container">
                <h3><?= $suscription->getSwitch()->getName(); ?></h3>
                <p id="propietario"><?= $suscription->getSwitch()->getOwner()->getUsername(); ?></p>
                
                <?php
                    if($suscription->getSwitch()->getStatus()){ ?>

                        <p id="encendido" class="estado"><?= i18n("Power on") ?></p>

                    <?php } else { ?>

                        <p id="apagado" class="estado"><?= i18n("Power off") ?></p>

                    <?php } ?>
                
            </div>

        <?php 
            endforeach; 
        } else {
        ?>
            <div id="mensaje"><?= i18n("No subscriptions") ?></div>
        <?php
        }
        ?>  

    </div> 

    <div id="modal-container" class="modal-container"></div>

    
</div>

<?php $view->moveToFragment("css");?>
    <link rel="stylesheet" href="css/dashboard.css" type="text/css">
<?php $view->moveToDefaultFragment(); ?>
