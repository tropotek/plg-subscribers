<?php

$config = \App\Config::getInstance();
$routes = $config->getRouteCollection();
if (!$routes) return;

/** @var \Composer\Autoload\ClassLoader $composer */
$composer = $config->getComposer();
if ($composer)
    $composer->add('\\Tk\\Sub\\', dirname(__FILE__));





// Default Home catchall
$params = array();
$routes->add('subscribers-form', new \Tk\Routing\Route('/subscribe', 'Tk\Sub\Controller\Subscriber::doDefault', $params));
//$routes->add('free-presentations', new \Tk\Routing\Route('/events', 'Tk\Ev\Controller\FreePresentations::doDefault', array()));

$params = array('role' => 'admin');
$routes->add('event-settings', new \Tk\Routing\Route('/eventSettings.html', 'Tk\Ev\Controller\SystemSettings::doDefault', $params));

$routes->add('admin-event-manager', new \Tk\Routing\Route('/admin/eventManager.html', 'Tk\Ev\Controller\MailLog\Manager::doDefault', $params));
$routes->add('admin-event-view', new \Tk\Routing\Route('/admin/eventView.html', 'Tk\Ev\Controller\MailLog\View::doDefault', $params));

$routes->add('admin-event-view', new \Tk\Routing\Route('/admin/eventView.html', 'Tk\Ev\Controller\MailLog\View::doDefault', $params));





