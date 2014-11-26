<?php if (!defined('FW')) die('Forbidden'); ?>

# Feedback

The extension adds the possibility for users to leave feedback impressions about a post (product, article, etc). This system can be activated for some post types, and replaces the default comments system.

----

## STEP 1

###Copy the feedback code snippet
This code snippet is what displays the feedback on your website.
Copy the following to your clipboard:

``` if( function_exists('fw_ext_feedback') ) { fw_ext_feedback(); } ```

## STEP 2

###Paste the feedback code snippet in your theme

In the template, paste the code snippet where you want your feedback to appear (usually in single.php) and then save your theme.

## STEP 3

###Verify the code snippet is working

Now that you have the snippet inserted into your theme we can check and make sure everything is working properly.