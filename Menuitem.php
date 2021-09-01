<?php

namespace dokuwiki\plugin\stale;

use dokuwiki\Menu\Item\AbstractItem;
use helper_plugin_stale;

/**
 * Class MenuItem
 *
 * Implements the stale button
 * https://www.dokuwiki.org/devel:menus:example
 */
class StaleMenuItem extends AbstractItem
{


    /**
     * The first compile time, the javascript may not
     * work, we send the user to the admin page
     *
     * Abstract item does not use the getter method
     * we override then the variable
     *
     * @return array
     */
    protected $params =  array(
            "do" => "admin",
            "page" => helper_plugin_stale::PLUGIN_NAME
        );


    const MENU_HTML_ELEMENT_ID = 'plugin_' . helper_plugin_stale::PLUGIN_NAME;


    public function getLinkAttributes($classprefix = 'menuitem ')
    {
        $linkAttributes = parent::getLinkAttributes($classprefix);

        /**
         * A class and not an id
         * because a menu item can be found twice on
         * a page (For instance if you want to display it in a layout at a
         * breakpoint and at another in another breakpoint
         */
        $linkAttributes['class'] = self::MENU_HTML_ELEMENT_ID;

        return $linkAttributes;
    }

    public function getType()
    {
        return "admin";
    }




    public function getTitle()
    {
        $stale = plugin_load('helper', helper_plugin_stale::PLUGIN_NAME);
        return $stale->getLang('menu');
    }

    public function getLabel()
    {
        $stale = plugin_load('helper', helper_plugin_stale::PLUGIN_NAME);
        return $stale->getLang("menuItemLabel");
    }


    public function getSvg()
    {
        /** @var helper_plugin_stale $stale */
        $stale = plugin_load('helper', helper_plugin_stale::PLUGIN_NAME);
        return $stale->getIcon();
    }
}
