     <div class="form-inline mr-auto">
         <ul class="navbar-nav mr-3">
             <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn">
                     <i data-feather="align-justify"></i></a></li>
             <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                     <i data-feather="maximize"></i>
                 </a></li>
             <li>
                 <form class="form-inline mr-auto">
                     <div class="search-element">
                         <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                             data-width="200">
                         <button class="btn" type="submit">
                             <i class="fas fa-search"></i>
                         </button>
                     </div>
                 </form>
             </li>
         </ul>
     </div>
     <ul class="navbar-nav navbar-right">
         @if (Auth::user()->role_id == 2)
             <x-notification-dropdown />
         @endif
         @if (Auth::user()->role_id == 4)
             <x-patient-notification-dropdown />
         @endif

         @if (Auth::user()->role_id == 1)
             <li class="dropdown"><a href="#" data-toggle="dropdown"
                     class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                     <img alt="image"
                         src="{{ Auth::user()->user_image ? asset('/' . Auth::user()->user_image) : asset('images/users/default.png') }}"
                         class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
                 <div class="dropdown-menu dropdown-menu-right pullDown">
                     <div class="dropdown-title">Hello {{ Auth::user()->name }}</div>
                     <a href="{{ route('users.edit', Auth::user()->id) }}" class="dropdown-item has-icon"> <i
                             class="far fa-user"></i> Profile</a>
                     <div class="dropdown-divider"></div>

                     <a href="#" class="dropdown-item has-icon text-danger"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         <i class="fas fa-sign-out-alt"></i> Logout
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                 </div>
             </li>
         @endif

         @if (Auth::user()->role_id == 2)
             <li class="dropdown"><a href="#" data-toggle="dropdown"
                     class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                     <img alt="image"
                         src="{{ auth()->user()->doctor->profile_image ? asset('/' . auth()->user()->doctor->profile_image) : asset('images/users/default.png') }}"
                         class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
                 <div class="dropdown-menu dropdown-menu-right pullDown">
                     <div class="dropdown-title">Hello {{ Auth::user()->name }}</d iv>
                         <a href="{{ route('doctor.edit', auth()->user()->doctor->id) }}"
                             class="dropdown-item has-icon"> <i class="far fa-user"></i> Profile</a>
                         <div class="dropdown-divider"></div>
                         <a href="#" class="dropdown-item has-icon text-danger"
                             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                             <i class="fas fa-sign-out-alt"></i> Logout
                         </a>
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                             @csrf
                         </form>
                     </div>
             </li>
         @elseif (Auth::user()->role_id == 4)
             <li class="dropdown"><a href="#" data-toggle="dropdown"
                     class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                     <img alt="image"
                         src="{{ auth()->user()->patient->profile_image ? asset('/' . auth()->user()->patient->profile_image) : asset('images/users/default.png') }}"
                         class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
                 <div class="dropdown-menu dropdown-menu-right pullDown">
                     <div class="dropdown-title">Hello {{ Auth::user()->name }}</div>
                     <a href="{{ route('patient.edit', auth()->user()->patient->id) }}" class="dropdown-item has-icon">
                         <i class="far fa-user"></i> Profile</a>
                     <div class="dropdown-divider"></div>
                     <a href="#" class="dropdown-item has-icon text-danger"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         <i class="fas fa-sign-out-alt"></i> Logout
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                 </div>
             </li>
         @else

             <li class="dropdown"><a href="#" data-toggle="dropdown"
                     class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                     <img alt="image"
                         src="{{ auth()->user()->user_image ? asset('/' . auth()->user()->user_image) : asset('images/users/default.png') }}"
                         class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
                 <div class="dropdown-menu dropdown-menu-right pullDown">
                     <div class="dropdown-title">Hello {{ Auth::user()->name }}</div>
                     <a href="{{ route('users.edit', auth()->user()->id) }}" class="dropdown-item has-icon">
                         <i class="far fa-user"></i> Profile</a>
                     <div class="dropdown-divider"></div>
                     <a href="#" class="dropdown-item has-icon text-danger"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         <i class="fas fa-sign-out-alt"></i> Logout
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                 </div>
             </li>
        @endif
     </ul>
