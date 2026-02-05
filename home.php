<?php
/**
 * The template for displaying the blog posts index (when a static front page is set)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

use Timber\Timber;

$context = Timber::context();
$context['posts'] = Timber::get_posts();
Timber::render('templates/archive.twig', $context);
