<?php

use dokuwiki\plugin\config\core\ConfigParser;
use dokuwiki\plugin\config\core\Loader;


/**
 * Test the settings.php file
 *
 * @group plugin_stale
 * @group plugins
 */
class baseTest extends DokuWikiTest
{


    public function setUp()
    {
        $this->pluginsEnabled[] = helper_plugin_stale::PLUGIN_NAME;
        parent::setUp();
    }


    /**
     *
     * Test if we don't have any problem
     * in the file settings.php
     *
     * If there is, we got an error in the admin config page
     */
    public function test_base()
    {

        $request = new TestRequest();
        TestUtility::runAsAdmin($request);

        $response = $request->get(array('do' => 'admin', 'page' => "config"), '/doku.php');

        // Simple
        $countListContainer = $response->queryHTML("#plugin____" . helper_plugin_stale::PLUGIN_NAME . "____plugin_settings_name")->count();
        $this->assertEquals(1, $countListContainer, "There should an element");

    }

    public function test_delete_sitemap()
    {

        global $conf;
        $cacheDirectory = $conf['cachedir'];
        $file = $cacheDirectory . "/sitemap.xml.gz";
        touch($file);

        /** @var helper_plugin_stale $stale */
        $stale = plugin_load('helper', 'stale');

        $result = $stale->deleteSitemap();
        $this->assertEquals(true, $result);

    }

    /**
     * Test to ensure that every conf['...'] entry
     * in conf/default.php has a corresponding meta['...'] entry in conf/metadata.php.
     */
    public function test_plugin_default()
    {
        $conf = array();
        $conf_file = __DIR__ . '/../conf/default.php';
        if (file_exists($conf_file)) {
            include($conf_file);
        }

        $meta = array();
        $meta_file = __DIR__ . '/../conf/metadata.php';
        if (file_exists($meta_file)) {
            include($meta_file);
        }


        $this->assertEquals(
            gettype($conf),
            gettype($meta),
            'Both ' . DOKU_PLUGIN . 'syntax/conf/default.php and ' . DOKU_PLUGIN . 'syntax/conf/metadata.php have to exist and contain the same keys.'
        );

        if (gettype($conf) != 'NULL' && gettype($meta) != 'NULL') {
            foreach ($conf as $key => $value) {
                $this->assertArrayHasKey(
                    $key,
                    $meta,
                    'Key $meta[\'' . $key . '\'] missing in ' . DOKU_PLUGIN . 'syntax/conf/metadata.php'
                );
            }

            foreach ($meta as $key => $value) {
                $this->assertArrayHasKey(
                    $key,
                    $conf,
                    'Key $conf[\'' . $key . '\'] missing in ' . DOKU_PLUGIN . 'syntax/conf/default.php'
                );
            }
        }

        /**
         * English language
         */
        $lang = array();
        $settings_file = __DIR__ . '/../lang/en/settings.php';
        if (file_exists($settings_file)) {
            include($settings_file);
        }


        $this->assertEquals(
            gettype($conf),
            gettype($lang),
            'Both ' . DOKU_PLUGIN . 'syntax/conf/metadata.php and ' . DOKU_PLUGIN . 'syntax/lang/en/settings.php have to exist and contain the same keys.'
        );

        if (gettype($conf) != 'NULL' && gettype($lang) != 'NULL') {
            foreach ($lang as $key => $value) {
                $this->assertArrayHasKey(
                    $key,
                    $conf,
                    'Key $meta[\'' . $key . '\'] missing in ' . DOKU_PLUGIN . 'syntax/conf/metadata.php'
                );
            }

            foreach ($conf as $key => $value) {
                $this->assertArrayHasKey(
                    $key,
                    $lang,
                    'Key $lang[\'' . $key . '\'] missing in ' . DOKU_PLUGIN . 'syntax/lang/en/settings.php'
                );
            }
        }

        /**
         * The default are read through parsing
         * by the config plugin
         * Yes that's fuck up but yeah
         * This test check that we can read them
         */
        $parser = new ConfigParser();
        $loader = new Loader($parser);
        $defaultConf = $loader->loadDefaults();
        $keyPrefix = "plugin____" . helper_plugin_stale::PLUGIN_NAME . "____";
        $this->assertTrue(is_array($defaultConf));

        // plugin defaults
        foreach ($meta as $key => $value) {
            $this->assertArrayHasKey(
                $keyPrefix . $key,
                $defaultConf,
                'Key $conf[\'' . $key . '\'] could not be parsed in ' . DOKU_PLUGIN . 'syntax/conf/default.php. Be sure to give only values and not variable.'
            );
        }


    }






}
