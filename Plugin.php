<?php
namespace Tk\Sub;

use Tk\Event\Dispatcher;


/**
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2016 Michael Mifsud
 */
class Plugin extends \Tk\Plugin\Iface
{

    /**
     * A helper method to get the Plugin instance globally
     *
     * @return \Tk\Plugin\Iface|Plugin
     * @throws \Tk\Exception
     */
    static function getInstance()
    {
        return \App\Config::getInstance()->getPluginFactory()->getPlugin('subscribers');
    }


    // ---- \Tk\Plugin\Iface Interface Methods ----


    /**
     * Init the plugin
     *
     * This is called when the session first registers the plugin to the queue
     * So it is the first called method after the constructor.....
     */
    function doInit()
    {
        include dirname(__FILE__) . '/config.php';

        /** @var Dispatcher $dispatcher */
        $dispatcher = \App\Config::getInstance()->getEventDispatcher();


        $dispatcher->addSubscriber(new \Tk\Sub\Listener\MenuHandler());

    }

    /**
     * Activate the plugin, essentially
     * installing any DB and settings required to run
     * Will only be called when activating the plugin in the
     * plugin control panel
     *
     * @throws \Tk\Db\Exception
     */
    function doActivate()
    {
        // TODO: Implement doActivate() method.

        $db = $this->getConfig()->getDb();
        $migrate = new \Tk\Util\SqlMigrate($db);
        $migrate->setTempPath($this->getConfig()->getTempPath());
        $migrate->migrate(dirname(__FILE__) . '/sql');

        // Init Settings
        $data = $this->getData();
        $data->set('plugin.menu.admin.renderer', '\Bs\Page');
        $data->set('plugin.menu.admin.var', 'app-menu');
        $data->set('plugin.menu.admin.content', '<li><a href="/admin/subscriberManager.html"><i class="fa fa-newspaper-o fa-fw"></i> Subscribers</a></li>');
        $data->save();
    }

    /**
     * Example upgrade code
     * This will be called when you update the plugin version in the composer.json file
     *
     * Upgrade the plugin
     * Called when the file version is larger than the version in the DB table
     *
     * @param string $oldVersion
     * @param string $newVersion
     */
    function doUpgrade($oldVersion, $newVersion)
    {
        // Init Plugin Settings
//        $config = \Tk\Config::getInstance();
//        $db = \App\Factory::getDb();

//        $migrate = new \Tk\Util\SqlMigrate($db);
//        $migrate->setTempPath($config->getTempPath());
//        $migrate->migrate(dirname(__FILE__) . '/sql');

//        if (version_compare($oldVersion, '1.0.1', '<')) { ; }
//        if (version_compare($oldVersion, '1.0.2', '<')) { ; }
    }

    /**
     * Deactivate the plugin removing any DB data and settings
     * Will only be called when deactivating the plugin in the
     * plugin control panel
     *
     * @throws \Tk\Db\Exception
     */
    function doDeactivate()
    {
        $db = $this->getConfig()->getDb();

        // Remove migration track
        $sql = sprintf('DELETE FROM %s WHERE %s LIKE %s', $db->quoteParameter(\Tk\Util\SqlMigrate::$DB_TABLE), $db->quoteParameter('path'),
            $db->quote('/plugin/' . $this->getName().'/%'));
        $db->query($sql);

        // Clear the data table of all plugin data
        $sql = sprintf('DELETE FROM %s WHERE %s LIKE %s', $db->quoteParameter(\Tk\Db\Data::$DB_TABLE), $db->quoteParameter('fkey'),
            $db->quote($this->getName().'%'));
        $db->query($sql);
        // OR
//        $data = \Tk\Db\Data::create($this->getName());
//        $data->clear();
//        $data->save();

        if ($db->hasTable('subscriber'))
            $this->getConfig()->getDb()->query('DROP TABLE subscriber');

    }


    /**
     * @return \Tk\Uri
     */
    public function getSettingsUrl()
    {
        return \Bs\Uri::createHomeUrl('/subscribersSettings.html');
    }

}