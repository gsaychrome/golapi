<?php
require_once 'vendor/autoload.php';

$wizard = new \Clab2\ClientGenerator\ApiWizard('Golapi', __DIR__);
$wizard->setDependency(['Application']);
$wizard->run($argv);