<?php

if (!function_exists('user_avatar')) {
    function user_avatar($name, $size = 100, $bg = 'random', $color = 'fff')
    {
        $name = urlencode($name);

        return "https://ui-avatars.com/api/?name={$name}&background={$bg}&color={$color}&size={$size}";
    }
}

function printArray($data)
{
    echo "<pre>";
    print_r($data);
    echo "<pre>";
}

function setColorStatus($status)
{
    switch ($status) {
        case 'Fresh Lead':
            return '<span class="badge badge-pill bg-warning">'.$status.'</span>';
        case 'RNR':
            return '<span class="badge badge-pill bg-warning">'.$status.'</span>';
        case 'Invalid Number':
            return '<span class="badge badge-pill bg-danger">'.$status.'</span>';
        case 'Junk':
            return '<span class="badge badge-pill bg-dark">'.$status.'</span>';
        case 'Followup':
            return '<span class="badge badge-pill bg-info">'.$status.'</span>';
        case 'Closed':
            return '<span class="badge badge-pill bg-success">'.$status.'</span>';
        case 'Not Interested':
            return '<span class="badge badge-pill bg-danger">'.$status.'</span>';
        case 'Future Requirement':
            return '<span class="badge badge-pill bg-light">'.$status.'</span>';
        default:
            return '<span class="badge badge-pill bg-secondary">'.$status.'</span>';
    }
}