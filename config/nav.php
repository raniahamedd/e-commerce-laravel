<?php

return [
    [
        'icon' => 'nav-icon fas fa-techometer=alt',
        'route' => 'dashboard.',
        'title' => 'Dashboard',
        'active' => 'dashboard.'
    ],
    [
        'icon' => 'nav-icon far fa-circle',
        'route' => 'dashboard.categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'dashboard.categories.*'
    ],
    [
        'icon' => 'nav-icon far fa-circle',
        'route' => 'dashboard.products.index',
        'title' => 'Products',
        'badge' => 'New',
        'active' => 'dashboard.products.*'
    ],
];
