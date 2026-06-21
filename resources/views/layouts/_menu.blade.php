<style>
    i.fa-regular.fa-circle {
        padding: 0 6px;
        font-size: 10px;
    }
</style>
<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0"
       data-bg-class="bg-menu-theme"
       style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
    <div class="container-xxl d-flex h-100">

        <a href="#" class="menu-horizontal-prev d-none"></a>
        <div class="menu-horizontal-wrapper">
            <ul class="menu-inner" style="margin-left: 0px;">
                <!-- Dashboards -->
                <li class="menu-item">
                    <a href="{{ route('dashboard.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-table"></i>
                        <div data-i18n="Tables">الرئيسية</div>
                    </a>
                </li>
                {{-- users --}}

                @canany(['Read-Roles', 'Read-Users'])
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon fa-solid fa-users-gear"></i>
                            <div data-i18n="Apps">المستخدمين</div>
                        </a>
                        <ul class="menu-sub">
                            @can('Read-Roles')
                                <li class="menu-item">
                                    <a href="{{ route('roles.index') }}" class="menu-link">
                                        <i class="fa-regular fa-circle"></i>
                                        <div data-i18n="List">الأدوار</div>
                                    </a>
                                </li>
                            @endcan
                            @can('Read-Users')
                                <li class="menu-item">
                                    <a href="{{ route('users.index') }}" class="menu-link"><i
                                            class="fa-regular fa-circle"></i>
                                        <div data-i18n="List">الحسابات</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @canany(['Read-LicenseForms', 'Create-LicenseForm', 'Read-Streets', 'Read-Zones', 'Read-Sub-Zones',
                    'Read-Subscriptions', 'Read-Clients', 'Read-Buildings', 'Create-Building', 'BuildingTypes'])
                    <!-- GIS -->
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            {{-- <i class="menu-icon tf-icons ti ti-layout-grid-add"></i> --}}
                            <i class="menu-icon fa-solid fa-hotel"></i>
                            <div data-i18n="Apps">التنظيم</div>
                        </a>
                        <ul class="menu-sub">
                            @canany(['Read-LicenseForms', 'Create-LicenseForm'])
                                {{-- license_forms --}}
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon fa-regular fa-map"></i>
                                        <div data-i18n="Invoice">طلبات الترخيص</div>
                                    </a>
                                    <ul class="menu-sub">
                                        @can('Read-LicenseForms')
                                            <li class="menu-item">
                                                <a href="{{ route('license_forms.index') }}" class="menu-link">
                                                    <div data-i18n="List">{{ __('Show All') }}</div>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('Create-LicenseForm')
                                            <li class="menu-item">
                                                <a href="{{ route('license_forms.create') }}" class="menu-link">
                                                    <div data-i18n="List">أضف جديد</div>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            {{-- Streets --}}
                            @can('Read-Streets')
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon fa-regular fa-map"></i>
                                        <div data-i18n="Invoice">{{ __('Streets') }}</div>
                                    </a>
                                    <ul class="menu-sub">
                                        <li class="menu-item">
                                            <a href="{{ route('streets.index') }}" class="menu-link">
                                                <div data-i18n="List">{{ __('Show All') }}</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @canany(['Read-Zones', 'Create-Sub-Zones'])
                                {{-- Zones --}}
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                                        <div data-i18n="Invoice">{{ __('Zones') }}</div>
                                    </a>
                                    <ul class="menu-sub">
                                        @can('Read-Zones')
                                            <li class="menu-item">
                                                <a href="{{ route('zones.index') }}" class="menu-link">
                                                    <div data-i18n="List">{{ __('Zones') }}</div>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('Read-Sub-Zones')
                                            <li class="menu-item">
                                                <a href="{{ route('sub-zones.index') }}" class="menu-link">
                                                    <div data-i18n="List">{{ __('Sub Zones') }}</div>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            @can('Read-Subscriptions')
                                {{-- Subscription --}}
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                                        <div data-i18n="Invoice">{{ __('Subscription') }}</div>
                                    </a>
                                    <ul class="menu-sub">
                                        <li class="menu-item">
                                            <a href="{{ route('subscriptions.index') }}" class="menu-link">
                                                <div data-i18n="List">{{ __('Show All') }}</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('Read-Clients')
                                {{-- Client --}}
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                                        <div data-i18n="Invoice">المشتركين</div>
                                    </a>
                                    <ul class="menu-sub">
                                        <li class="menu-item">
                                            <a href="{{ route('clients.index') }}" class="menu-link">
                                                <div data-i18n="List">{{ __('Show All') }}</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            {{-- Craft --}}
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <i class="menu-icon fa-solid fa-person-digging"></i>

                                    <div data-i18n="Users">{{ __('Economical') }}</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="{{route('economical.index')}}" class="menu-link">
                                            <div data-i18n="List">{{ __('Show All') }}</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <i class="menu-icon fa-solid fa-person-digging"></i>

                                    <div data-i18n="Users">الوحدات</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="{{route('units.index')}}" class="menu-link">
                                            <div data-i18n="List">{{ __('Show All') }}</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{-- Buildings --}}
                            @canany(['Read-Buildings', 'Create-Building', 'BuildingTypes'])
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                                        <i class="menu-icon fa-regular fa-building"></i>
                                        <div data-i18n="Users">{{ __('Buildings') }}</div>
                                    </a>
                                    <ul class="menu-sub">
                                        @can('Read-Buildings')
                                            <li class="menu-item">
                                                <a href="{{ route('buildings.index') }}" class="menu-link">
                                                    <div data-i18n="List">{{ __('Show All') }}</div>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('Create-Building')
                                            <li class="menu-item">
                                                <a href="#" class="menu-link">
                                                    <div data-i18n="List">{{ __('Add New') }}</div>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('BuildingTypes')
                                            <li class="menu-item">
                                                <a href="{{ route('building-types.index') }}" class="menu-link">
                                                    <div data-i18n="List">{{ __('Types') }}</div>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                {{-- //// --}}
                <li class="menu-item">
                    
                    <ul class="menu-sub">
                        @can('Read-Users')
                            <li class="menu-item">
                                <a href="{{ route('departments.index') }}" class="menu-link"><i
                                        class="fa-regular fa-circle"></i>
                                    <div data-i18n="List">الأقسام</div>
                                </a>
                            </li>
                        @endcan
                        @can('Read-Roles')
                            <li class="menu-item">
                                <a href="{{ route('treatments.index') }}" class="menu-link">
                                    <i class="fa-regular fa-circle"></i>
                                    <div data-i18n="List">المعاملات</div>
                                </a>
                            </li>
                        @endcan
                        @can('Read-Users')
                            <li class="menu-item">
                                <a href="{{ route('customer-pens.index') }}" class="menu-link"><i
                                        class="fa-regular fa-circle"></i>
                                    <div data-i18n="List">المكلفين</div>
                                </a>
                            </li>
                        @endcan
                        @can('Read-Users')
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <i class="fa-regular fa-circle"></i>
                                    <div data-i18n="Invoice">معاملات المكلفين</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="{{ route('customer-pen-treatments.create') }}" class="menu-link">
                                            <div data-i18n="List">أضف جديد</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{ route('customer-pen-treatments.index') }}" class="menu-link">
                                            <div data-i18n="List">{{ __('Show All') }}</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#" class="menu-link">
                                            <div data-i18n="List">عرض المعاملات المفتوحة</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#" class="menu-link">
                                            <div data-i18n="List">عرض المعاملات المنتهية</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#" class="menu-link">
                                            <div data-i18n="List">عرض الأرشيف</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <i class="menu-icon fa-solid fa-users-gear"></i>
                        <div data-i18n="Apps">إدارة الحرف</div>
                    </a>
                    <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('economical.index') }}" class="menu-link"><i
                                        class="fa-regular fa-circle"></i>
                                    <div data-i18n="List">عرض قائمة الحرف الفعالة</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('economical.index') }}" class="menu-link"><i
                                        class="fa-regular fa-circle"></i>
                                    <div data-i18n="List">عرض قائمة الحرف المنتهية</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('economical.new') }}" class="menu-link"><i
                                        class="fa-regular fa-circle"></i>
                                    <div data-i18n="List">اضافة حرفة جديدة</div>
                                </a>
                            </li>
                        
                    </ul>
                </li>
               

                {{-- //// --}}

            </ul>
        </div>
        <a href="#" class="menu-horizontal-next d-none"></a>
    </div>
</aside>
