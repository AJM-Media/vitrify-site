<?php
/**
 * The front page template (used when a static front page is set)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

use Timber\Timber;

$context = Timber::context();
Timber::render('home.twig', $context);
