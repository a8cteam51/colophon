Colophon
========

Having set up footer links in many partner sites, this aims to
simplify the deployment of each, by using a more consistent api.

Usage
=====

While `team51_credits()` can be invoked directly, it will allow
for more graceful degradation to implement via actions.

```php
<?php do_action( 'team51_credits', array() ); ?>
```

Parameters can be passed in --

* `separator` -- defaults to a single space.  
  Separator is passed through `esc_html()` on output, so don't include html tags.
* `wpcom` -- The text displayed for the backlink to WordPress.com  
  Defaults to `Proudly powered by WordPress.`  
  Link is skipped if not truthy.
* `pressable` -- The text displayed for the backlink to Pressable  
  Defaults to `Hosted by Pressable.`  
  Link is skipped if not truthy.

<!-- Coming soon!

FSE Themes
==========

If your site using Full Site Editing, then insert a shortcode
block into the footer and use `[team51_colophon /]` as an embed.

-->
