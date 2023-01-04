Colophon
========

Having set up footer links in many partner sites, this aims to
simplify the deployment of each, by using a more consistent api.

WPCOM
=====

<em>Only on WPCOM sites</em><br>
Removes the WPCOM ```better_wpcom_link_init``` action that modifies the credit links, so we can use our own.

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

FSE Themes
==========

If your site using Full Site Editing, then insert a shortcode
block into the footer.html and use `[team51-credits /]` as an embed.

Something like this:

```html
<!-- wp:shortcode -->
[team51-credits /]
<!-- /wp:shortcode -->
```

or

```html
<!-- wp:shortcode -->
[team51-credits separator=" | " /]
<!-- /wp:shortcode -->
```

or the like.  It will also accept `wpcom` and `pressable` parameters
as well to specify their respective link texts.
