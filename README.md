# Stale Plugin - Making your Dokuwiki Cache Stale

## About

Stale is a [DokuWiki Plugin](https://www.dokuwiki.org/plugin:stale) that touch configuration files (ie change only the modified date)
in order to make the cache stale.

Why ? Because this files are cache dependencies and if touched will then prohibit the use of the cache for the nextb request.


## Configuration file touched

The following configuration files are touched:

  * the main configuration file: [local.php](https://www.dokuwiki.org/config)
  * all plugin configuration file [plugin.info.txt](https://www.dokuwiki.org/devel:plugin_info)

## How to touch ?

You can touch them:

  * in the [admin page](https://www.dokuwiki.org/admin_window)
  * in the [sitemenu tool](https://www.dokuwiki.org/devel:menus) via the hand icon

![Hand index icon](images/hand-index-fill.svg)

## Reference

Based on the [dead plugin toucher](https://github.com/anandr/dokuwiki-plugin-toucher/pull/2#issuecomment-809981442) idea.



