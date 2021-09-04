# Stale Plugin - Making your Dokuwiki Cache Stale

## About

Stale is a [DokuWiki Plugin](https://www.dokuwiki.org/plugin:stale) that aims to delete or make all DokuWiki Cache stale.

For this purpose, it will :
  * touches all configuration files (ie change only the modified date, not the content) in order to make the rendering cache stale (ie HTML,...)
  * delete the [sitemap file](https://www.dokuwiki.org/sitemap) if present.


## Configuration file touched

The following configuration files are touched:

  * the main configuration file: [local.php](https://www.dokuwiki.org/config)
  * all plugin info file [plugin.info.txt](https://www.dokuwiki.org/devel:plugin_info)

> Note that the plugins that are using the cache system, must make the cache dependent of their info file to get the cache stale

Why ? Because these files are cache dependencies and if touched will then prohibit the use of the cache by the next request.

## How to stale ?

You can stale the cache:

  * in the [sitemenu tool](https://www.dokuwiki.org/devel:menus) via the hand icon ![Hand index icon](images/hand-index-fill.svg)
  * in the [admin page](https://www.dokuwiki.org/admin_window)


## Release

  * 2021-09-04:
     * As [per request 2](https://github.com/ComboStrap/stale/issues/2), Make the cache stale, reload the page and shows the feedback
  * 2021-09-01:
     * Delete the [sitemap](https://www.dokuwiki.org/sitemap)
  * 2021-08-30:
     * The stale menu item is now a website item
     * The action label is more clear and was added as language reference
  * 2021-08-04:
     * First release

## Reference

Based on the [dead plugin toucher](https://github.com/anandr/dokuwiki-plugin-toucher/pull/2#issuecomment-809981442) idea.
