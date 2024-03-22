<?php

namespace Studio\Totem\Helpers;

use Illuminate\Support\HtmlString;

function columnSort(string $label, string $columnKey, bool $isDefault = false)
{
    $icon = '';

    if (request()->has('sort_by')) {
        if (request()->input('sort_by') == $columnKey) {
            $icon = ' <span class="fa fa-caret-'
                .(request()->input('sort_direction', 'asc') == 'asc' ? 'up' : 'down')
                .'"></span>';
        }
    } elseif ($isDefault) {
        $icon = ' <span class="fa fa-caret-'
            .(request()->input('sort_direction', 'asc') == 'asc' ? 'up' : 'down')
            .'"></span>';
    }

    $order = 'asc';
    if (request()->has('sort_direction')) {
        $order = (request()->input('sort_direction') == 'desc' ? 'asc' : 'desc');
    } elseif ($isDefault) {
        $order = 'desc';
    }

    $url = request()->fullUrlWithQuery([
        'sort_by' => $columnKey,
        'sort_direction' => $order,
        'filter' => request('filter'),
        'limit' => request('limit'),
    ]);

    return new HtmlString(
        '<a href="'
        .$url
        .'">'
        .$label
        .$icon
        .'</a>'
    );
}
