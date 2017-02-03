<?php
require_once 'vendor/autoload.php';

if(!defined('REST_API_HOST')) define('REST_API_HOST','gol.tis.hu');

$wizard = new \Clab2\ClientGenerator\ApiWizard('Golapi', __DIR__);
$wizard->setDependency(['Application']);
$wizard->run($argv);