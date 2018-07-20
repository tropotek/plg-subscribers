<?php

$config = \App\Config::getInstance();
$routes = $config->getRouteCollection();
if (!$routes) return;

/** @var \Composer\Autoload\ClassLoader $composer */
$composer = $config->getComposer();
if ($composer)
    $composer->add('Tk\\Sub\\', dirname(__FILE__));



$routes->add('subscribers-form', new \Tk\Routing\Route('/subscribe', 'Tk\Sub\Controller\Subscriber::doDefault'));

$routes->add('subscribers-admin-settings', new \Tk\Routing\Route('/admin/subscribersSettings.html', 'Tk\Sub\Controller\Settings::doDefault'));
$routes->add('subscribers-admin-manager', new \Tk\Routing\Route('/admin/subscriberManager.html', 'Tk\Sub\Controller\Subscriber\Manager::doDefault'));
$routes->add('subscribers-admin-edit', new \Tk\Routing\Route('/admin/subscriberEdit.html', 'Tk\Sub\Controller\Subscriber\Edit::doDefault'));






