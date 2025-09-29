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
        // 회원관리 카테고리
        [
            'text' => '회원 관리', // 클릭 가능한 카테고리 이름
            'url'  => '#', // 클릭 시 이동할 URL이 없다면 '#'
            'icon' => 'fas fa-fw fa-users-cog', // 카테고리 아이콘
            'can'  => 'admin', // 관리자 권한 (level >= 10) 필요
            'submenu' => [ // 하위 메뉴
                [
                    'text' => '회원 목록',
                    'url'  => 'admin/users',
                    'icon' => 'fas fa-fw fa-user-friends',
                    'can'  => 'admin',
                ],
                [
                    'text' => '트리구조 보기', // <-- 새로운 메뉴 추가
                    'url'  => 'admin/users/tree-view', // 새로운 라우트
                    'icon' => 'fas fa-fw fa-sitemap', // 트리뷰 아이콘
                    'can'  => 'admin',
                    'active' => ['admin.users.tree-view'],
                ],
                [
                    'text' => '하위 멤버 포인트 지급', // 레벨 9~3 파트너용
                    'url'  => 'admin/partners/send-points',
                    'icon' => 'fas fa-fw fa-handshake',
                    'can'  => 'admin', // 파트너 권한 (level >= 1) 필요
                    'active' => ['admin.partners.send-points.form', 'admin.partners.send-points'],
                ],
                // 기타 회원 관리 기능
            ],
        ],
        [
            'text' => '파트너 대시보드',
            'url'  => 'partner/dashboard', // 새로운 라우트
            'icon' => 'fas fa-fw fa-handshake', // 아이콘은 Font Awesome 5 Free 기준
            'can'  => 'partner', // level >= 1인 모든 파트너 접근 가능            
            'active' => ['partner.dashboard'], // 이 메뉴가 활성화될 라우트 이름
            'submenu' => [ // 하위 메뉴
                [
                    'text' => '회원 목록',
                    'url'  => 'partner/users',
                    'icon' => 'fas fa-fw fa-user-friends',
                    'can'  => 'partner',
                    'active' => ['partner.users.index'],
                ],
                [
                    'text' => '트리구조 보기', // <-- 새로운 메뉴 추가
                    'url'  => 'partner/users/tree-view', // 새로운 라우트
                    'icon' => 'fas fa-fw fa-sitemap', // 트리뷰 아이콘
                    'can'  => 'partner',
                    'active' => ['admin.users.tree-view'],
                ],
                // [
                //     'text' => '하위 멤버 포인트 지급', // 레벨 9~3 파트너용
                //     'url'  => 'admin/partners/send-points',
                //     'icon' => 'fas fa-fw fa-handshake',
                //     'can'  => 'partner', // 파트너 권한 (level >= 1) 필요
                // ],
                // 기타 회원 관리 기능
            ],
        ],

        // 게임포인트 카테고리
        [
            'text' => '게임 포인트',
            'url'  => '#',
            'icon' => 'fas fa-fw fa-gamepad',
            'can'  => 'admin', // 관리자 권한 (level >= 10) 필요
            'submenu' => [ // 하위 메뉴
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
                [
                    'text' => '출금 요청 승인', // 하위 레벨 출금 요청 승인
                    'url'  => 'admin/balances/approve-withdrawals',
                    'icon' => 'fas fa-fw fa-check-double',
                    'can'  => 'admin', // 파트너 권한 (level >= 1) 또는 더 높은 권한 필요
                ],
            ],
        ],

        // 환경설정 카테고리
        [
            'text' => '환경설정',
            'url'  => '#',
            'icon' => 'fas fa-fw fa-cogs',
            'can'  => 'admin', // 슈퍼관리자만 접근 가능
            'submenu' => [ // 하위 메뉴
                [
                    'text' => '게임포인트 설정', // 총자산 설정 포함
                    'url'  => 'admin/settings/game-points',
                    'icon' => 'fas fa-fw fa-sliders-h',
                    'can'  => 'admin',
                ],
                [
                    'text' => '포인트 지급', // 슈퍼관리자용 모든 회원에게 포인트 지급
                    'url'  => 'admin/points/distribute',
                    'icon' => 'fas fa-fw fa-money-check',
                    'can'  => 'admin',
                ],
                [
                    'text' => '자본금 관리', // 총자본금 추가/회수
                    'url'  => 'admin/settings/capital-manage', // 새로운 라우트
                    'icon' => 'fas fa-fw fa-wallet', // 아이콘 변경 가능
                    'can'  => 'admin', // 슈퍼관리자만 가능하도록
                ],
            ],
        ],

        // 계정 관리 카테고리
        [
            'text' => '계정 관리',
            'url'  => '#',
            'icon' => 'fas fa-fw fa-user-circle',
            'can'  => 'admin', // 슈퍼관리자만 접근 가능 (또는 로그인 사용자 모두)
            'submenu' => [
                [
                    'text' => '로그아웃',
                    'url'  => '#',
                    'icon' => 'fas fa-fw fa-sign-out-alt',
                    'method' => 'post',
                    'classes' => 'logout-link',
                    /*'attr' => [                        
                        'onclick' => "event.preventDefault(); document.getElementById('logout-form').submit();",                    
                    ],*/
                ],
                // 기타 계정 관리 메뉴 (예: 비밀번호 변경 등)
            ]
        ],

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