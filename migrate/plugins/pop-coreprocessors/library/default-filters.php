<?php
use PoP\Hooks\Facades\HooksAPIFacade;

// Remove the canonical, since we are already printing this info in the header (and we do it ourselves, as to remove the language information)
// Originally added in wp-includes/default-filters.php
HooksAPIFacade::getInstance()->removeAction('wp_head', 'rel_canonical');

// We don't need the shortlink or the generator
HooksAPIFacade::getInstance()->removeAction('wp_head', 'wp_shortlink_wp_head', 10, 0);
HooksAPIFacade::getInstance()->removeAction('wp_head', 'wp_generator');

// This outputs site_url( 'xmlrpc.php' ), and because the xmlrpc.php is blocked, no need to add it
HooksAPIFacade::getInstance()->removeAction('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
