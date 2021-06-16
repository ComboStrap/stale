# Stale Plugin - Making your Dokuwiki Cache Stale

## About

Stale is a [DokuWiki Plugin](https://www.dokuwiki.org/plugin:stale) that touches configuration files (ie change only the modified date, not the content)
in order to make the cache stale.

Why ? Because these files are cache dependencies and if touched will then prohibit the use of the cache by the next request.


## Configuration file touched

The following configuration files are touched:

  * the main configuration file: [local.php](https://www.dokuwiki.org/config)
  * all plugin info file [plugin.info.txt](https://www.dokuwiki.org/devel:plugin_info)

> Note that the plugins that are using the cache system, must make the cache dependent of their info file to get the cache stale

## How to touch ?

You can touch them:

  * in the [sitemenu tool](https://www.dokuwiki.org/devel:menus) via the hand icon ![Hand index icon](images/hand-index-fill.svg)
  * in the [admin page](https://www.dokuwiki.org/admin_window)


## Reference

Based on the [dead plugin toucher](https://github.com/anandr/dokuwiki-plugin-toucher/pull/2#issuecomment-809981442) idea.

## Note

By adding `?do=check` to a page, you can also do a configuration check.

