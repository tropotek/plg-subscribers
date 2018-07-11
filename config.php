<?php

$config = \App\Config::getInstance();
$routes = $config->getRouteCollection();
if (!$routes) return;

/** @var \Composer\Autoload\ClassLoader $composer */
$composer = $config->getComposer();
if ($composer)
    $composer->add('Tk\\Sub\\', dirname(__FILE__));



// Default Home catchall
$params = array();
$routes->add('subscribers-form', new \Tk\Routing\Route('/subscribe', 'Tk\Sub\Controller\Subscriber::doDefault', $params));

$params = array('role' => 'admin');
$routes->add('subscribers-settings', new \Tk\Routing\Route('/subscribersSettings.html', 'Tk\Sub\Controller\Settings::doDefault', $params));

$routes->add('subscribers-admin-manager', new \Tk\Routing\Route('/admin/subscriberManager.html', 'Tk\Sub\Controller\Subscriber\Manager::doDefault', $params));
$routes->add('subscribers-admin-edit', new \Tk\Routing\Route('/admin/subscriberEdit.html', 'Tk\Sub\Controller\Subscriber\Edit::doDefault', $params));






