<style>html {scroll-behavior: smooth;}</style>
@php
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
@endphp
@php
    if (isset(request()->search) && !empty(request()->search)) {
        $searchData = request()->search;
    } elseif(isset(request()->year_result) && !empty(request()->year_result)) {
        $searchData = request()->year_result;
    } elseif(isset(request()->more_result) && !empty(request()->more_result)) {
        $searchData = request()->more_result;
    } else {
        $searchData = "";
    }
@endphp
