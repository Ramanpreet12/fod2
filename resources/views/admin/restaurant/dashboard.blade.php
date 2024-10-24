<h1>WElcome jjjjiiiiiiiiii</h1>

<li>
    <!-- Authentication -->
<form method="POST" action="{{ route('restaurant.logout') }}">
@csrf

<x-responsive-nav-link :href="route('restaurant.logout')"
onclick="event.preventDefault();
   this.closest('form').submit();">
{{ __('Log Out') }}
</x-responsive-nav-link>
</form>

   {{-- <a class="dropdown-item" href="{{ route('admin.logout') }}">
       <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
   </a> --}}
</li>
