<?php

/*
Plugin Name: Asta HTML Minifier
Plugin URI: https://www.astavelopment.ca?utm_medium=plugin&utm_source=wordpress&utm_campaign=asta-html-minifier&utm_term=plugin
Description: Improve your website's overall performance by stripping away all extra white space and HTML comments in your HTML output across your entire website.
Version: 1.0.11
Author: Astavelopment
Author URI: http://www.astavelopment.ca?utm_medium=plugin&utm_source=wordpress&utm_campaign=asta-html-minifier&utm_term=author
License: GPL3
*/

// Main plugin class
class AstaHtmlMinifier {

    // constructor function
    function __construct(){
        // check if admin is not displayed
        if(!is_admin()){
            // adding hooks to connect with HTML output
            add_action('wp_loaded', array('AstaHtmlMinifier', 'buffer_start'));
            add_action('shutdown', array('AstaHtmlMinifier', 'buffer_end'));
        }

    }

    // regex to remove all html white space
    private static $STRIPHTMLREGEX = '%(?>[^\S ]\s*|\s{2,})(?=(?:(?:[^<]++|<(?!/?(?:textarea|pre)\b))*+)(?:<(?>textarea|pre)\b|\z))%ix';
    // regex to remove HTML comments
    private static $STRIPCOMMENTREGEX = '~<!-- ([a-zA-Z0-9\s\.\/\\\\:\-\#\{\\$}]+) -->~';

    // minifier callback
    private static function callback($buffer) {
        // remove all unneeded spaces in HTML and replace with space to prevent removing wanted spaces
        $buffer = preg_replace(AstaHtmlMinifier::$STRIPHTMLREGEX, ' ', $buffer);
        // Remove HTML comments and it's content
        $buffer = preg_replace(AstaHtmlMinifier::$STRIPCOMMENTREGEX, '', $buffer);
        return $buffer;
    }

    // buffer start filter function
    public static function buffer_start() {
        // call minifier callback
        ob_start(array('AstaHtmlMinifier', 'callback'));
    }

    // buffer end filter function
    public static function buffer_end() {
        // check if buffer exists
        if(ob_get_length()){
            // flush buffer
            ob_end_flush();
        }
    }

}

//  init plugin - run constructor
new AstaHtmlMinifier();
