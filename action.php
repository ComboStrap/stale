<?php

// must be run within Dokuwiki
use dokuwiki\plugin\stale\StaleMenuItem;

if (!defined('DOKU_INC')) die();

require_once(__DIR__ . '/Menuitem.php');

/**
 * Class action_plugin_move_rewrite
 */
class action_plugin_stale extends DokuWiki_Action_Plugin
{

    /**
     * Register event handlers.
     *
     * @param Doku_Event_Handler $controller The plugin controller
     */
    public function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, 'handle_ajax_call');

        /**
         * Add a icon in the page tools menu
         * https://www.dokuwiki.org/devel:event:menu_items_assembly
         */
        $controller->register_hook('MENU_ITEMS_ASSEMBLY', 'AFTER', $this, 'add_menu_item');
    }

    /**
     * Render a subtree
     *
     * @param Doku_Event $event
     * @param            $params
     */
    public function handle_ajax_call(Doku_Event $event, $params)
    {
        if ($event->data != 'plugin_stale') return;
        $event->preventDefault();
        $event->stopPropagation();

        /** @var helper_plugin_stale $stale */
        $stale = plugin_load('helper', 'stale');

        if ($stale->canTouch() !== true) {
            http_status(403);
            $message = "You don't have the right to touch";
        } else {

            $message = $stale->stale();
            http_status(200);

        }
        $jsonArray = array("message" => $message);
        header('Content-Type: application/json');
        echo json_encode($jsonArray);


    }

    public function add_menu_item(Doku_Event $event, $param)
    {

        /**
         * The `view` property defines the menu that is currently built
         * https://www.dokuwiki.org/devel:menus
         * If this is not the page menu, return
         */
        if ($event->data['view'] != 'site') return;

        /** @var helper_plugin_stale $stale */
        $stale = plugin_load('helper', 'stale');
        if ($stale->canTouch()===true){

            array_splice($event->data['items'], -1, 0, array(new StaleMenuItem()));

        }



    }


}
