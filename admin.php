<?php

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');

require_once DOKU_PLUGIN . 'admin.php';

class admin_plugin_stale extends DokuWiki_Admin_Plugin
{

    /**
     * @var string
     */
    private $msg;

    public function getMenuSort()
    {
        return 13;
    }

    public function forAdminOnly()
    {
        return $this->getConf(helper_plugin_stale::CONF_ADMIN_ONLY);
    }

    public function getMenuIcon()
    {
        /** @var helper_plugin_stale $stale */
        $stale = plugin_load('helper', 'stale');
        return $stale->getIcon();
    }


    public function handle()
    {

        /** @var helper_plugin_stale $stale */
        $stale = plugin_load('helper', 'stale');


        $reason = $stale->canTouch();
        if ($reason !== true) {
            msg('Plugin stale: You can\'t touch the file for the following reason: ' . $reason, -1);
            return false;
        }

        $this->msg = $stale->stale();

        return true;
    }

    public function html()
    {
        ptln('<h1>' . $this->getLang('h1') . '</h1>');
        ptln("<p>$this->msg</p>");
    }
}

