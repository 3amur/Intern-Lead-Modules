<nav class="navbar navbar-vertical navbar-expand-lg" style="display:none;">
    <script>
        var navbarStyle = localStorage.getItem("phoenixNavbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    <!-- parent pages-->
                    <span class="nav-item-wrapper">
                        <a class="nav-link label-1 @if (Illuminate\Support\Facades\Route::currentRouteName() == 'home.index') active @endif"
                            href="{{ route('home.index') }}" role="button">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon">
                                </div><span class="nav-link-icon"><i class="fa-solid fa-display mt-1"></i></span><span
                                    class="nav-link-text">{{ __('Dashboard') }}</span>
                            </div>
                        </a>
                    </span>
                </li>


            </ul>
            <hr>
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                @if (app\Helpers\Helpers::perUser('lead_home.index'))

                    <li class="nav-item">
                        <!-- parent pages-->
                        <span class="nav-item-wrapper">
                            <a class="nav-link label-1 @if (Illuminate\Support\Facades\Route::currentRouteName() == 'lead_home.index') active @endif" href="{{ route('lead_home.index') }}" role="button">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon">
                                    </div><span class="nav-link-icon"><i
                                            class="fa-solid fa-display mt-1"></i></span><span
                                        class="nav-link-text">{{ __('Leads Home') }}</span>
                                </div>
                            </a>
                        </span>
                    </li>
                @endif

            </ul>
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    <!-- parent pages-->
                    <span class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1 collapsed"
                            href="#leadFunctions" role="button" data-bs-toggle="collapse" aria-expanded="true"
                            aria-controls="leadFunctions">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span
                                    class="nav-link-icon"><i class="fa-regular fa-clipboard fa-lg"></i></span><span
                                    class="nav-link-text">{{ __('Lead Functions') }} </span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav parent collapse" data-bs-parent="#navbarVerticalCollapse" id="leadFunctions"
                                style="">
                                <p class="collapsed-nav-item-title d-none">{{ __('Lead Functions') }} </p>
                                <!-- Lead Account -->
                                @if (app\Helpers\Helpers::perUser('lead_account.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('lead_account.index') }}" data-bs-toggle=""
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Lead Account') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                <!-- Potential Account -->
                                @if (app\Helpers\Helpers::perUser('potential_account.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('potential_account.index') }}"
                                            data-bs-toggle="" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Potential Customer') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </span>


                    <!-- Target Function pages-->
                    <span class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 collapsed" href="#targetFunctions" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="targetFunctions">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span>
                                </div><span class="nav-link-icon"><i
                                        class="fa-regular fa-clipboard fa-lg"></i></span><span
                                    class="nav-link-text">{{ __('Target Functions') }} </span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1 ">
                            <ul class="nav  parent collapse" data-bs-parent="#settingCollapse" id="targetFunctions">
                                <p class="collapsed-nav-item-title d-none">{{ __('Target Functions') }}</p>

                                @if (app\Helpers\Helpers::perUser('sales_targets.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('sales_targets.index') }}" data-bs-toggle=""
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Sales Targets') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                <!-- Sales Agents -->
                                @if (app\Helpers\Helpers::perUser('sales_agents.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('sales_agents.index') }}" data-bs-toggle=""
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Sales Agents') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                <!-- Sales Agents -->
                                @if (app\Helpers\Helpers::perUser('brokers.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('brokers.index') }}" data-bs-toggle=""
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Brokers') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </span>


                    @if (app\Helpers\Helpers::perUser('leadSettings.leadSettings'))

                    <!-- lead settings pages-->
                    <span class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 collapsed" href="#leadSettings" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="leadSettings">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span>
                                </div><span class="nav-link-icon"><span data-feather="settings"></span></span><span
                                    class="nav-link-text">{{ __('Leads Settings') }} </span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1 ">
                            <ul class="nav  parent collapse" data-bs-parent="#settingCollapse" id="leadSettings">
                                <p class="collapsed-nav-item-title d-none">{{ __('Leads Settings') }}</p>
                                @if (app\Helpers\Helpers::perUser('lead_source.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('lead_source.index') }}"
                                            data-bs-toggle="" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Lead Source') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                <!-- Lead Status -->
                                @if (app\Helpers\Helpers::perUser('lead_status.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('lead_status.index') }}"
                                            data-bs-toggle="" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Lead Status') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                <!-- Lead Value -->
                                @if (app\Helpers\Helpers::perUser('lead_value.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('lead_value.index') }}" data-bs-toggle=""
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Lead Value') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                @if (app\Helpers\Helpers::perUser('lead_type.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('lead_type.index') }}" data-bs-toggle=""
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Lead Type') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </span>
                    @endif

                    @if (app\Helpers\Helpers::perUser('leadSettings.targetSettings'))

                    <!-- lead settings pages-->
                    <span class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 collapsed" href="#targetSettings" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="targetSettings">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span>
                                </div><span class="nav-link-icon"><span data-feather="settings"></span></span><span
                                    class="nav-link-text">{{ __('Target Settings') }} </span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1 ">
                            <ul class="nav  parent collapse" data-bs-parent="#settingCollapse" id="targetSettings">
                                <p class="collapsed-nav-item-title d-none">{{ __('Target Settings') }}</p>
                                @if (app\Helpers\Helpers::perUser('target_types.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('target_types.index') }}"
                                            data-bs-toggle="" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Target Type') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                @if (app\Helpers\Helpers::perUser('broker_types.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('broker_types.index') }}"
                                            data-bs-toggle="" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Broker Type') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </span>
                    @endif

                    @if (app\Helpers\Helpers::perUser('leadSettings.countrySettings'))

                    <!-- country settings pages-->
                    <span class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 collapsed" href="#countrySettings"
                            role="button" data-bs-toggle="collapse" aria-expanded="true"
                            aria-controls="countrySettings">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span>
                                </div><span class="nav-link-icon"><span data-feather="settings"></span></span><span
                                    class="nav-link-text">{{ __('Country Settings') }} </span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1 ">
                            <ul class="nav  parent collapse" data-bs-parent="#settingCollapse" id="countrySettings">
                                <p class="collapsed-nav-item-title d-none">{{ __('Country Settings') }}</p>
                                <!-- Country Settings -->

                                @if (app\Helpers\Helpers::perUser('countries.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('countries.index') }}"
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Countries') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                <!-- States -->
                                @if (app\Helpers\Helpers::perUser('states.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('states.index') }}"
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('States') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                <!-- Cities -->
                                @if (app\Helpers\Helpers::perUser('cities.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('cities.index') }}"
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Cities') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </span>
                    @endif

                </li>
            </ul>
            <hr>

            {{-- Reminders Modules Pages --}}

            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    <!-- parent pages-->
                    <span class="nav-item-wrapper">
                        <a class="nav-link label-1 @if (Illuminate\Support\Facades\Route::currentRouteName() == 'reminders.home') active @endif"
                            href="{{ route('reminders.home') }}" role="button">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon">
                                </div><span class="nav-link-icon"><i class="fa-solid fa-display mt-1"></i></span><span
                                    class="nav-link-text">{{ __('Reminders Home') }}</span>
                            </div>
                        </a>
                    </span>
                </li>
            </ul>

            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    <!-- parent pages-->
                    <span class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1 collapsed"
                            href="#remindersModule" role="button" data-bs-toggle="collapse" aria-expanded="true"
                            aria-controls="remindersModule">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div><span
                                    class="nav-link-icon"><i class="fa-regular fa-clipboard fa-lg"></i></span><span
                                    class="nav-link-text">{{ __('Reminders Modules') }} </span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav parent collapse" data-bs-parent="#navbarVerticalCollapse" id="remindersModule"
                                style="">
                                <p class="collapsed-nav-item-title d-none">{{ __('Reminders Modules') }} </p>
                                <!-- Reminder  Pages -->
                                @if (app\Helpers\Helpers::perUser('reminders.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('reminders.index') }}" data-bs-toggle=""
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Reminders') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                <!--  Contacts Pages -->
                                @if (app\Helpers\Helpers::perUser('contacts.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('contacts.index') }}"
                                            data-bs-toggle="" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">{{ __('Contacts') }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                @if (app\Helpers\Helpers::perUser('reminders.calendar'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('reminders.calendar') }}"
                                        data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">{{ __('Calender') }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            </ul>
                        </div>
                    </span>
                </li>
            </ul>

            <hr>

            {{-- Settings pages --}}
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    <!-- parent pages-->
                    <span class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1 collapsed"
                            href="#events" role="button" data-bs-toggle="collapse" aria-expanded="true"
                            aria-controls="events">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><svg class="svg-inline--fa fa-caret-right"
                                        aria-hidden="true" focusable="false" data-prefix="fas"
                                        data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 256 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z">
                                        </path>
                                    </svg><!-- <span class="fas fa-caret-right"></span> Font Awesome fontawesome.com -->
                                </div><span class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-clipboard">
                                        <path
                                            d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2">
                                        </path>
                                        <rect x="8" y="2" width="8" height="4" rx="1"
                                            ry="1"></rect>
                                    </svg></span><span class="nav-link-text">{{ __('Staff Management') }} </span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav parent collapse" data-bs-parent="#navbarVerticalCollapse" id="events"
                                style="">
                                <p class="collapsed-nav-item-title d-none">{{ __('Staff Management') }} </p>
                                <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}"
                                        data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span
                                                class="nav-link-text">{{ __('Users') }}</span></div>
                                    </a><!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link " href="{{ route('roles.index') }}"
                                        data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span
                                                class="nav-link-text">{{ __('Roles') }}</span></div>
                                    </a><!-- more inner pages-->
                                </li>
                            </ul>
                        </div>
                    </span>
                    <!-- settings pages-->
                    <span class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 collapsed" href="#setting" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="setting">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span>
                                </div><span class="nav-link-icon"><span data-feather="settings"></span></span><span
                                    class="nav-link-text">{{ __('Main Setting') }} </span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1 ">
                            <ul class="nav  parent collapse" data-bs-parent="#settingCollapse" id="setting">
                                <p class="collapsed-nav-item-title d-none">{{ __('Main Setting') }}</p>

                                <li class="nav-item"><a class="nav-link " href="{{ route('setting.themeSetting') }}"
                                        data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span
                                                class="nav-link-text">{{ __('Theme Setting') }}</div>
                                    </a><!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link "
                                        href="{{ route('setting.generalSetting') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span
                                                class="nav-link-text">{{ __('General Setting') }}</div>
                                    </a><!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link "
                                        href="{{ route('setting.moduleSetting') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span
                                                class="nav-link-text">{{ __('Modules Settin') }}g</div>
                                    </a><!-- more inner pages-->
                                </li>
                            </ul>
                        </div>
                    </span>

                </li>
            </ul>
        </div>
    </div>
    <div class="navbar-vertical-footer"><button onclick="toggleNavArrow()"
            class="btn navbar-vertical-toggle border-0 fw-semi-bold w-100 text-start white-space-nowrap"><span
                id="toggleArrow" class="fas fa-arrow-right d-none fs-0"></span><span
                class="navbar-vertical-footer-text ms-2"> <span class="fas fa-arrow-left  ms-2"></span> Collapsed View
            </span></span></button></div>
</nav>
