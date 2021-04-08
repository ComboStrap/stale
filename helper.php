<?php


class helper_plugin_stale extends DokuWiki_Plugin
{


    const CONF_ADMIN_ONLY = 'admin_only';
    const PLUGIN_NAME = 'stale';

    /**
     * Touching the configuration file will reset the cache
     */
    function touchConfFiles()
    {

        touch(DOKU_CONF . "local.php");

        $dir = new DirectoryIterator(DOKU_PLUGIN);
        foreach ($dir as $file) {
            if ($file->isDir() && !$file->isDot()) {
                $infoPlugin =  $file->getPathname()."/plugin.info.txt";
                if (file_exists($infoPlugin)){
                    touch($infoPlugin);
                }
            }
        }

    }

    /**
     * @return bool true if the user can touch the file or the reason why it can't
     *
     * Because a non-empty string is also true
     * Use it like this:
     * $stale->canTouch()!==true
     *
     */
    public function canTouch()
    {
        $canTouch = true;
        if ($this->getConf(self::CONF_ADMIN_ONLY)) {
            global $USERINFO;
            if (!auth_isadmin($_SERVER['REMOTE_USER'], $USERINFO['grps'])) {
                return "Only admin can touch";
            }
        }
        return $canTouch;
    }

    public function getIcon()
    {
        return __DIR__ . '/images/hand-index-fill.svg';
    }

}
