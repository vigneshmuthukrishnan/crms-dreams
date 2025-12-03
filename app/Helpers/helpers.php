<?php

if (!function_exists('user_avatar')) {
    function user_avatar($name, $size = 100, $bg = 'random', $color = 'fff')
    {
        $name = urlencode($name);

        return "https://ui-avatars.com/api/?name={$name}&background={$bg}&color={$color}&size={$size}";
    }
}