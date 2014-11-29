<?php if (!defined('FW')) die('Forbidden'); ?>

##STEP 1

###Copy the feedback code

This code is what displays the feedback on your website. Copy the following to your clipboard:

<code>&lt;?php if( function_exists('fw_ext_feedback') ) { fw_ext_feedback(); } ?&gt;</code>

---

##STEP 2

###Paste the feedback code in your theme

Open Appearance/Editor and select <strong>single.php</strong> file to edit.

In the theme, paste the code where you want your feedback to appear (usually beneath the the_title() tag) and then save your theme.

---

##STEP 3 (optional)

###Add the feedback to your archive listings

Copy the following code to your clipboard:

<code>&lt;?php if( function_exists('fw_ext_feedback') ) { fw_ext_feedback(); } ?&gt;</code>

Open Appearance/Editor and select <strong>archive.php</strong> file to edit.

In the theme, find the place where each item is rendered and paste the code inside that code block.

Then, save your theme.
