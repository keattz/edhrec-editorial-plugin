<?php
/**
* Plugin Name: EDHREC Plugin Editorial
* Plugin URI: https://edhrec.com/
* Description: EDHREC wordpress helper plugin for formatting MTG words
* Version: 0.1
* Author: Ben Doolittle
**/

function write_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('" . $output . "' );</script>";
}

function ignore_formatting($atts, $content = null) {
    return $content;
}

add_shortcode('if', 'ignore_formatting');

function interpret_match($matches, $replacements, $index) {
    // replace unwanted characters from match
    $word = preg_replace('/[^A-Za-z0-9\-\s]/', '', $matches[$index]);
    // if match is at start of line, keep capitalization
    if (preg_match('/(\.\s|<p>)/', $matches[1])) {
        return $matches[1].$word;
    }
    // if match is within [if] tag, change nothing
    if (in_array('[if]', $matches)) {
        return $matches[0];
    }

    $lword = strtolower($word);
    if (!array_key_exists($lword, $replacements)) {
        return $lword;
    }
    return $replacements[$lword];
}

function rcallback($matches) {
    include 'patterns_and_replacements.php';
    $array_length = count($matches);

    if ($array_length == 2) {
        return interpret_match($matches, $replacements, 1);
    }
    elseif ($array_length == 3) {

        if (str_contains($matches[0], 'ly-')) {
            return $matches[1] . ' ' . $matches[2];
        }

        // catches colors/keywords in [deck] tag
        if (preg_match('/\d\s/i', $matches[1])) {
            return str_replace($matches[2], ucfirst($matches[2]), $matches[0]);
        }
        return interpret_match($matches, $replacements, 2);
    }
    elseif ($array_length == 4) {
        // catches colors/keywords in [el] tags
        if (str_contains($matches[1], '[el') || str_contains($matches[1], '<p>') || str_contains($matches[1], '" ') || preg_match('/\d\s/i', $matches[1])) {
            return str_replace($matches[2], ucfirst($matches[2]), $matches[0]);
        }
        if ($matches[1] == 'h1') {
            return '<h2>' . $matches[2] . '</h2>';
        }

        // remove special formatting
        if (in_array($matches[1], ['i', 'b', 'em', 'strong'])) {
            if ($matches[1]) {
                return $matches[2];
            }
            return strtolower($matches[2]);
        }
    }
    elseif ($array_length == 5) {
        return interpret_match($matches, $replacements, 4);
    }
    elseif ($array_length == 6) {
        return interpret_match($matches, $replacements, 4);
    }

    return $matches[0];
}

function filter_the_content($content) {
    // Check if we're in a single post in the loop
    // TODO: Learn what the loop is

    if(is_singular() && in_the_loop() && is_main_query()) {
        include 'patterns_and_replacements.php';
        $new_content = preg_replace_callback($patterns, 'rcallback', $content);
        return $new_content;
    }

    return $content;
}

add_filter('the_content', 'filter_the_content');

?>
