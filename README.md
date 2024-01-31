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
* `format` -- The date format to use with the `[team51-current-year]` shortcode.
  Defaults to `Y`.

Customization
=============

You can filter the output links if desired to modify the classes on them or add new attributes if desired.  It can be done like so:

```php
/**
 * Append `extra-class-name` to the colophon link classes.
 * 
 * @param $credit_links (array) An array of the backlinks.
 * @return (array) The backlinks, with the classes appended.
 */
function PREFIX_team51_credit_links( $credit_links ) {
  foreach ( $credit_links as &$link ) {
    $link = str_replace( 'class="imprint"', 'class="imprint extra-class-name" ', $link );
  }

  return $credit_links;
}
add_filter( 'team51_credit_links', 'PREFIX_team51_credit_links' );
```

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

For inserting the current year, use this:

```html
<!-- wp:shortcode -->
[team51-current-year]
<!-- /wp:shortcode -->
```

... will output "2024", or whatever the current year is.


### Examples

To remove Pressable link for WordPress.com sites, you can use

```html
<!-- wp:shortcode -->
[team51-credits pressable="" /]
<!-- /wp:shortcode -->
```

Change WordPress link text to be “Proudly designed with WordPress”:

```html
<!-- wp:shortcode -->
[team51-credits wpcom="Proudly designed with WordPress" /]
<!-- /wp:shortcode -->
```

Add the current year in the format “24”:

```html
<!-- wp:shortcode -->
[team51-current-year format="y"]
<!-- /wp:shortcode -->
```



Installation
============

Colophon should be installed as a submodule into `mu-plugins`, rather than committing its files directly.  This will enable updates from the source repository when needed more easily and provide greater consistency while lessening the support burden.

First, ensure the following two lines are included in your `.gitignore` so that the files are explicitly not ignored, and can be committed:

```
!mu-plugins/mu-loader.php
!mu-plugins/colophon
```

If `mu-loader.php` is not already in the `mu-plugins` directory, it can be copied from https://github.com/Automattic/team51-cli/blob/trunk/scaffold/templates/mu-loader.php

This can be done on cli from the repository root via:

```
mkdir mu-plugins
curl https://raw.githubusercontent.com/Automattic/team51-cli/trunk/scaffold/templates/mu-loader.php -o mu-plugins/mu-loader.php
```

From the project repository's root, we add the Colophon as a submodule via

```
git submodule add https://github.com/a8cteam51/colophon mu-plugins/colophon
```

Then we create a pull request as needed and integrate it as above.


### Updates

* v1.2.0 Add a new shortcode for showing the copyright year.
