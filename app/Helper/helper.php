<?php

function highlightText($str, $search_term) {
    if (empty($search_term))
        return $str;

    $pos = strpos(strtolower($str), strtolower($search_term));

    if ($pos !== false) {
        $replaced = substr($str, 0, $pos);
        $replaced .= '<mark>' . substr($str, $pos, strlen($search_term)) . '</mark>';
        $replaced .= substr($str, $pos + strlen($search_term));
    } else {
        $replaced = $str;
    }
    return $replaced;
}



function returnHighlightText($str, $search_term) {
    if (empty($search_term))
        return false;

    $pos = strpos(strtolower($str), strtolower($search_term));

    if ($pos !== false) {
        return true;
    } else {
       return false;
    }
}


