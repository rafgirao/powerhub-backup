<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner scroll-scrollx_visible">
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('argon/img/brand/PowerHub.svg') }}" class="navbar-brand-img" alt="...">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'dashboard' ? 'active' : '') : '' }}">
{{--                        <a class="nav-link collapsed" href="#navbar-dashboards" data-toggle="collapse" role="button" aria-expanded="{{ $parentSection == 'dashboards' ? 'true' : '' }}" aria-controls="navbar-dashboards">--}}
                        <a class="nav-link collapsed" href="{{ route('home') }}" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'dashboards' ? 'true' : '') : '' }}" aria-controls="navbar-dashboards">
                        <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">{{ __('Dashboard') }}</span>
                        </a>
{{--                        <div class="collapse {{ $parentSection == 'dashboards' ? 'show' : '' }}" id="navbar-dashboards">--}}
{{--                            <ul class="nav nav-sm flex-column">--}}
{{--                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'dashboard' ? 'active') : ' : '' }}">--}}
{{--                                    <a href="{{ route('home') }}" class="nav-link">{{ __('Dashboard') }}</a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'dashboard-alternative' ? 'active') : ' : '' }}">--}}
{{--                                    <a href="{{ route('page.index','dashboard-alternative') }}" class="nav-link">{{ __('Alternative') }}</a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                    </li>

                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'projects' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-projects" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'projects' ? 'true' : '') : '' }}" aria-controls="navbar-projects">
                            <i class="ni ni-spaceship text-green"></i>
                            <span class="nav-link-text">{{ __('Projetos') }}</span>
                        </a>

                        <div class="collapse show {{ isset($parentSection) ? ( $parentSection == 'projects' ? 'show' : '') : '' }}" id="navbar-projects">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'all' ? 'active' : '') : '' }}">
                                    <a href="{{ route('projects.index') }}" class="nav-link">{{ __('Todos os Projetos') }}</a>
                                </li>
                            </ul>
                        </div>

                        <div class="collapse show {{ isset($parentSection) ? ( $parentSection == 'projects' ? 'show' : '') : '' }}" id="navbar-projects">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'newproject' ? 'active' : '') : '' }}">
                                    <a href="{{ route('projects.create') }}" class="nav-link">{{ __('Novo Projeto') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'leads' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-leads" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'leads' ? 'true' : '') : 0 }}" aria-controls="navbar-leads">
                            <i class="ni ni-like-2 text-yellow"></i>
                            <span class="nav-link-text">{{ __('Leads') }}</span>
                        </a>
                        <div class="collapse show {{ isset($parentSection) ? ( $parentSection == 'leads' ? 'show' : '') : '' }}" id="navbar-leads">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'todos' ? 'active' : '') : '' }}">
                                    <a href="{{ route('leads') }}" class="nav-link">{{ __('Todos os Leads') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'campaigns' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-campaigns" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'campaigns' ? 'true' : '') : 0 }}" aria-controls="navbar-campaigns">
                            <i class="ni ni-chart-bar-32 text-orange"></i>
                            <span class="nav-link-text">{{ __('Campanhas') }}</span>
                        </a>
                        <div class="collapse show {{ isset($parentSection) ? ( $parentSection == 'campaigns' ? 'show' : '') : '' }}" id="navbar-campaigns">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'facebook' ? 'active' : '') : '' }}">
                                    <a href="{{ route('campaigns.facebook') }}" class="nav-link">{{ __('Facebook') }}</a>
                                </li>
                            </ul>
                        </div>
                        @if(Illuminate\Support\Facades\Auth::user()->role_id == 1)
                        <div class="collapse {{ isset($parentSection) ? ( $parentSection == 'campaigns' ? 'show' : '') : '' }}" id="navbar-campaigns">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'google' ? 'active' : '') : '' }}">
                                    <a href="{{ route('home') }}" class="nav-link">{{ __('Google') }}</a>
                                </li>
                            </ul>
                        </div>
                        @endif
                    </li>

                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'links' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-links" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'links' ? 'true' : '') : 0 }}" aria-controls="navbar-products">
                            <i class="fa fa-link text-green"></i>
                            <span class="nav-link-text">{{ __('Deeplinks') }}</span>
                        </a>
                        <div class="collapse show {{ isset($parentSection) ? ( $parentSection == 'links' ? 'show' : '') : '' }}" id="navbar-products">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'todos' ? 'active' : '') : '' }}">
                                    <a href="{{ route('links.index') }}" class="nav-link">{{ __('Todos os Deeplinks') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'products' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-products" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'products' ? 'true' : '') : 0 }}" aria-controls="navbar-products">
                            <i class="ni ni-hat-3 text-blue"></i>
                            <span class="nav-link-text">{{ __('Produtos') }}</span>
                        </a>
                        <div class="collapse show {{ isset($parentSection) ? ( $parentSection == 'products' ? 'show' : '') : '' }}" id="navbar-products">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'todos' ? 'active' : '') : '' }}">
                                    <a href="{{ route('products') }}" class="nav-link">{{ __('Todos os Produtos') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'sales' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-sales" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'sales' ? 'true' : '') : 0 }}" aria-controls="navbar-sales">
                            <i class="ni ni-basket text-orange"></i>
                            <span class="nav-link-text">{{ __('Vendas') }}</span>
                        </a>
                        <div class="collapse show {{ isset($parentSection) ? ( $parentSection == 'sales' ? 'show' : '') : '' }}" id="navbar-sales">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'todos' ? 'active' : '') : '' }}">
                                    <a href="{{ route('sales') }}" class="nav-link">{{ __('Todas as Vendas') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>

{{--                    @if(Illuminate\Support\Facades\Auth::user()->role_id == 1)--}}

{{--                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'messages' ? 'active' : '') : '' }}">--}}
{{--                        <a class="nav-link" href="#navbar-messages" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'messages' ? 'true' : '') : 0 }}" aria-controls="navbar-messages">--}}
{{--                            <i class="ni ni-chat-round text-success"></i>--}}
{{--                            <span class="nav-link-text">{{ __('Mensagens') }}</span>--}}
{{--                        </a>--}}
{{--                        <div class="collapse show {{ isset($parentSection) ? ( $parentSection == 'messages' ? 'show' : '') : '' }}" id="navbar-messages">--}}
{{--                            <ul class="nav nav-sm flex-column">--}}
{{--                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'todos' ? 'active' : '') : '' }}">--}}
{{--                                    <a href="{{ route('messages') }}" class="nav-link">{{ __('Todas as Menags') }}</a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    @endif--}}

                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'debriefings' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-debriefing" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'debriefings' ? 'true' : '') : 0 }}" aria-controls="navbar-reports">
                            <i class="fa fa-users text-purple"></i>
                            <span class="nav-link-text">{{ __('Debriefings') }}</span>
                        </a>
                        <div class="collapse show {{ isset($parentSection) ? ( $parentSection == 'debriefings.index' ? 'show' : '') : '' }}" id="navbar-reports">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'todos' ? 'active' : '') : '' }}">
                                    <a href="{{ route('debriefings.index') }}" class="nav-link">{{ __('Todos os Debriefings') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->

                <ul class="navbar-nav">
                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'profile' ? 'active' : '') : '' }}">
                        <a class="nav-link collapsed" href="{{ route('profile.edit') }}" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'profile' ? 'true' : '') : 0 }}" aria-controls="navbar-profile">
                            <i class="ni ni-single-02 text-black-50"></i>
                            <span class="nav-link-text">{{ __('Perfil') }}</span>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'integrations' ? 'active' : '') : '' }}">
                        <a class="nav-link collapsed" href="{{ route('integrations') }}" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'integrations' ? 'true' : '') : 0 }}" aria-controls="navbar-integrations">
                            <i class="ni ni-settings-gear-65 text-black-50"></i>
                            <span class="nav-link-text">{{ __('Integrações') }}</span>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'support' ? 'active' : '') : '' }}">
                        <a class="nav-link collapsed" href="https://forms.gle/yZ9imZVV2zzTqYAC8" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'support' ? 'true' : '') : 0 }}" aria-controls="navbar-support">
                            <i class="ni ni-support-16 text-black-50"></i>
                            <span class="nav-link-text">{{ __('Suporte') }}</span>
                        </a>
                    </li>
                </ul>



                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02 text-s"></i>
                        <span>{{ __('Perfil') }}</span>
                    </a>
                    <a href="{{ route('integrations') }}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Integrações') }}</span>
                    </a>

                    @if(Illuminate\Support\Facades\Auth::user()->role_id == 1)
                        <a href="#!" class="dropdown-item">
                            <i class="ni ni-app"></i>
                            <span>{{ __('Conta') }}</span>
                        </a>
                    @endif
                    <a href="https://forms.gle/yZ9imZVV2zzTqYAC8" target="_blank" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Suporte') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Sair') }}</span>
                    </a>
                </div>

            @if(Illuminate\Support\Facades\Auth::user()->role_id == 1)

                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->
                    <h6 class="navbar-heading p-0 text-muted">{{ __('Admin') }}</h6>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link active" href="#navbar-admin" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-admin">
                            <i class="fab fa-laravel" style="color: #f4645f;"></i>
                            <span class="nav-link-text" style="color: #f4645f;">{{ __('Menu Admin') }}</span>
                        </a>
                        <div class="collapse show" id="navbar-admin">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'profile' ? 'active' : '') : '' }}">
                                    <a href="{{ route('profile.edit') }}" class="nav-link">{{ __('Profile') }}</a>
                                </li>
                                @can('manage-users', App\Models\User::class)
                                    <li class="nav-item  {{ isset($elementName) ? ($elementName == 'role-management' ? 'active' : '') : '' }}">
{{--                                        <a href="{{ route('role.index') }}" class="nav-link">{{ __('Role Management') }}</a>--}}
                                    </li>
                                @endcan
                                @can('manage-users', App\Models\User::class)
                                    <li class="nav-item {{ isset($elementName) ? ($elementName == 'user-management' ? 'active' : '') : '' }}">
{{--                                        <a href="{{ route('user.index') }}" class="nav-link">{{ __('User Management') }}</a>--}}
                                    </li>
                                @endcan
                                @can('manage-items', App\Models\User::class)
                                    <li class="nav-item {{ isset($elementName) ? ($elementName == 'category-management' ? 'active' : '') : '' }}">
{{--                                        <a href="{{ route('category.index') }}" class="nav-link">{{ __('Category Management') }}</a>--}}
                                    </li>
                                @endcan
                                @can('manage-items', App\Models\User::class)
                                    <li class="nav-item {{ isset($elementName) ? ($elementName == 'tag-management' ? 'active' : '') : '' }}">
{{--                                        <a href="{{ route('tag.index') }}" class="nav-link">{{ __('Tag Management') }}</a>--}}
                                    </li>
                                @endcan
                                @can('manage-items', App\Models\User::class)
                                    <li class="nav-item {{ isset($elementName) ? ($elementName == 'item-management' ? 'active' : '') : '' }}">
{{--                                        <a href="{{ route('item.index') }}" class="nav-link">{{ __('Item Management') }}</a>--}}
                                    </li>
                                @else
                                    <li class="nav-item {{ isset($elementName) ? ($elementName == 'item-management' ? 'active' : '') : '' }}">
{{--                                        <a href="{{ route('item.index') }}" class="nav-link">{{ __('Items') }}</a>--}}
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'old' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-pages" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'old' ? 'true' : '') : 0 }}" aria-controls="navbar-pages">
                            <i class="ni ni-collection text-yellow"></i>
                            <span class="nav-link-text">{{ __('Pages') }}</span>
                        </a>
                        <div class="collapse {{ isset($parentSection) ? ( $parentSection == 'old' ? 'show' : '') : '' }}" id="navbar-pages">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'timeline' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index', 'timeline') }}" class="nav-link">{{ __('Timeline') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'components' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-components" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'components' ? 'true' : '') : 0 }}" aria-controls="navbar-components">
                            <i class="ni ni-ui-04 text-info"></i>
                            <span class="nav-link-text">{{ __('Components') }}</span>
                        </a>
                        <div class="collapse {{ isset($parentSection) ? ( $parentSection == 'components' ? 'show' : '') : '' }}" id="navbar-components">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'buttons' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','buttons') }}" class="nav-link">{{ __('Buttons') }}</a>
                                </li>
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'cards' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','cards') }}" class="nav-link">{{ __('Cards') }}</a>
                                </li>
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'grid' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','grid') }}" class="nav-link">{{ __('Grid') }}</a>
                                </li>
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'messages' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','messages') }}" class="nav-link">{{ __('messages') }}</a>
                                </li>
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'icons' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','icons') }}" class="nav-link">{{ __('Icons') }}</a>
                                </li>
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'typography' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','typography') }}" class="nav-link">{{ __('Typography') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#navbar-multilevel" class="nav-link" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-multilevel">{{ __('Multi') }} level</a>
                                    <div class="collapse show" id="navbar-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link ">{{ __('Thirdlevelmenu') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link ">{{ __('Justanotherlink') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link ">{{ __('Onelastlink') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'forms' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'forms' ? 'true' : '') : 0 }}" aria-controls="navbar-forms">
                            <i class="ni ni-single-copy-04 text-pink"></i>
                            <span class="nav-link-text">{{ __('Forms') }}</span>
                        </a>
                        <div class="collapse {{ isset($parentSection) ? ( $parentSection == 'forms' ? 'show' : '') : '' }}" id="navbar-forms">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'elements' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','elements') }}" class="nav-link">{{ __('Elements') }}</a>
                                </li>
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'components' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','components') }}" class="nav-link">{{ __('Components') }}</a>
                                </li>
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'validations' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','validation') }}" class="nav-link">{{ __('Validations') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'tables' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-tables" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'tables' ? 'true' : '') : 0 }}" aria-controls="navbar-tables">
                            <i class="ni ni-align-left-2 text-default"></i>
                            <span class="nav-link-text">{{ __('Tables') }}</span>
                        </a>
                        <div class="collapse {{ isset($parentSection) ? ( $parentSection == 'tables' ? 'show' : '') : '' }}" id="navbar-tables">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'tables' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','tables') }}" class="nav-link">{{ __('Tables') }}</a>
                                </li>
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'sortable' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','sortable') }}" class="nav-link">{{ __('Sortable') }}</a>
                                </li>
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'datatables' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','datatables') }}" class="nav-link">{{ __('Datatables') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ isset($parentSection) ? ( $parentSection == 'maps' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="#navbar-maps" data-toggle="collapse" role="button" aria-expanded="{{ isset($parentSection) ? ($parentSection == 'maps' ? 'true' : '') : 0 }}" aria-controls="navbar-maps">
                            <i class="ni ni-map-big text-primary"></i>
                            <span class="nav-link-text">{{ __('Maps') }}</span>
                        </a>
                        <div class="collapse {{ isset($parentSection) ? ( $parentSection == 'maps' ? 'show' : '') : '' }}" id="navbar-maps">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'google' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','googlemaps') }}" class="nav-link">{{ __('Google') }}</a>
                                </li>
                                <li class="nav-item {{ isset($elementName) ? ($elementName == 'vector' ? 'active' : '') : '' }}">
                                    <a href="{{ route('page.index','vectormaps') }}" class="nav-link">{{ __('Vector') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ isset($elementName) ? ($elementName == 'widgets' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="{{ route('page.index','widgets') }}">
                            <i class="ni ni-archive-2 text-green"></i>
                            <span class="nav-link-text">{{ __('Widgets') }}</span>
                        </a>
                    </li>
                    <li class="nav-item {{ isset($elementName) ? ($elementName == 'charts' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="{{ route('page.index','charts') }}">
                            <i class="ni ni-chart-pie-35 text-info"></i>
                            <span class="nav-link-text">{{ __('Charts') }}</span>
                        </a>
                    </li>
                    <li class="nav-item {{ isset($elementName) ? ($elementName == 'calendar' ? 'active' : '') : '' }}">
                        <a class="nav-link" href="{{ route('page.index','calendar') }}">
                            <i class="ni ni-calendar-grid-58 text-red"></i>
                            <span class="nav-link-text">{{ __('Calendar') }}</span>
                        </a>
                    </li>
                </ul>
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading p-0 text-muted">{{ __('Documentation') }}</h6>
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html" target="_blank">
                            <i class="ni ni-spaceship"></i>
                            <span class="nav-link-text">Getting started</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html" target="_blank">
                            <i class="ni ni-palette"></i>
                            <span class="nav-link-text">Foundation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html" target="_blank">
                            <i class="ni ni-ui-04"></i>
                            <span class="nav-link-text">Components</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/plugins/charts.html" target="_blank">
                            <i class="ni ni-chart-pie-35"></i>
                            <span class="nav-link-text">Plugins</span>
                        </a>
                    </li>
                </ul>
            @endif
            </div>
        </div>
    </div>
</nav>
