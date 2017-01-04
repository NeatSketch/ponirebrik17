<?php
    $raw_data = file_get_contents('site-access.txt');
    $lines = explode("\n", $raw_data);
    foreach ($lines as $line) {
        $line_values = explode(' -- ', $line);
        echo implode(',', array_map(map_value, $line_values)) . "\n";
    }

    function map_value($value) {
        $escaped = str_replace("\"", "\"\"", $value);
        return "\"$escaped\"";
    }
?>