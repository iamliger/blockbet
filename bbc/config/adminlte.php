<?php

return [

    'title' => 'BLOCK BET 관리자',
    'title_prefix' => '',
    'title_postfix' => '',

    'use_ico_only' => false,
    'use_full_favicon' => false,

    'google_fonts' => [
        'allowed' => true,
    ],

    'logo' => '<b>Admin</b>LTE',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    'use_route_url' => false,
    'dashboard_url' => 'admin',
    'logout_method' => 'POST', // 라우터가 POST 방식이라면 이 설정도 필요
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,
    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',
    'usermenu_url' => 'admin/profile', // 사용자 메뉴 URL (선택 사항)
    'usermenu_icon' => 'fas fa-user-cog', // 사용자 메뉴 아이콘 (선택 사항)
    'usermenu_text' => '관리자 계정', // 사용자 메뉴 텍스트 (선택 사항)

    'menu' => [
        // 회원관리 카테고리 (최상위 메뉴 항목으로 정의하고 하위 메뉴를 가짐)
        [
            'text' => '회원 관리', // 클릭 가능한 카테고리 이름
            'url'  => '#', // 클릭 시 이동할 URL이 없다면 '#' (또는 첫 번째 하위 메뉴의 URL)
            'icon' => 'fas fa-fw fa-users-cog', // 카테고리 아이콘
            'can'  => 'admin', // 관리자 권한 필요
            'submenu' => [ // <-- 하위 메뉴를 정의합니다.
                [
                    'text' => '회원 목록',
                    'url'  => 'admin/users',
                    'icon' => 'fas fa-fw fa-user-friends', // 하위 메뉴 아이콘 (선택 사항)
                    'can'  => 'admin',
                ],
                // 향후 추가될 다른 회원 관리 메뉴 (예: 회원 상세, 회원 등급 변경 등)
                // [
                //     'text' => '회원 등급 설정',
                //     'url'  => 'admin/users/levels',
                //     'icon' => 'fas fa-fw fa-chart-line',
                //     'can'  => 'admin',
                // ],
            ],
        ],

        // 게임포인트 카테고리 (최상위 메뉴 항목으로 정의하고 하위 메뉴를 가짐)
        [
            'text' => '게임 포인트', // 클릭 가능한 카테고리 이름
            'url'  => '#', // 클릭 시 이동할 URL이 없다면 '#'
            'icon' => 'fas fa-fw fa-gamepad', // 카테고리 아이콘
            'can'  => 'admin',
            'submenu' => [ // <-- 하위 메뉴를 정의합니다.
                [
                    'text' => '토큰 전송 내역',
                    'url'  => 'admin/transfers',
                    'icon' => 'fas fa-fw fa-exchange-alt',
                    'can'  => 'admin',
                ],
                [
                    'text' => '입출금 내역',
                    'url'  => 'admin/balances',
                    'icon' => 'fas fa-fw fa-money-bill-wave',
                    'can'  => 'admin',
                ],
                [
                    'text' => '포인트 내역',
                    'url'  => 'admin/points',
                    'icon' => 'fas fa-fw fa-coins',
                    'can'  => 'admin',
                ],
            ],
        ],

        // 계정 관리 카테고리 (이것은 헤더가 아니라 최상위 메뉴여야 합니다.)
        // 로그아웃은 보통 최상단 또는 특정 위치에 독립적으로 두는 경우가 많습니다.
        // AdminLTE는 `logout_url` 옵션을 통해 자체 로그아웃 버튼을 제공하기도 합니다.
        // 여기서는 기존 방식대로 별도 메뉴로 둡니다.
        [
            'text' => '계정 관리',
            'url'  => '#', // 계정 관리 자체의 페이지가 있다면 해당 URL, 없다면 '#'
            'icon' => 'fas fa-fw fa-user-circle',
            'can'  => 'admin',
            'submenu' => [
                [
                    'text' => '로그아웃',
                    'url'  => 'logout',
                    'icon' => 'fas fa-fw fa-sign-out-alt',
                    // 'topnav_right' => true, // 상단바 오른쪽에도 로그아웃 표시 (선택 사항)
                    'attr' => [
                        'onclick' => "event.preventDefault(); document.getElementById('logout-form').submit();",
                    ],
                ],
                // 기타 계정 관리 메뉴 (예: 비밀번호 변경 등)
            ]
        ],
        // --- AdminLTE의 자체 로그아웃 버튼을 사용하려면 아래와 같이 할 수 있습니다 ---
        // ['separator' => true], // 구분선 (선택 사항)
        // [
        //     'text'    => '로그아웃',
        //     'url'     => 'logout',
        //     'icon'    => 'fas fa-fw fa-power-off',
        //     'can'     => 'admin', // 관리자만 볼 수 있도록
        //     'topnav_right' => true, // 상단바에도 표시 (선택 사항)
        //     'attr' => [
        //         'target' => '_self', // 현재 창에서 로그아웃
        //         'onclick' => "event.preventDefault(); document.getElementById('logout-form').submit();",
        //     ],
        // ],
    ],
    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],
    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],
    'livewire' => false,
];