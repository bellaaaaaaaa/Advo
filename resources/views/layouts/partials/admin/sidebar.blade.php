<div class="sidebar" data-color="blue" data-image="{{ asset('images/sidebar_bg.jpg') }}">

  <div class="logo">
		<a href="{{ route('dashboard') }}" class="simple-text logo-mini">
      TH
    </a>
    <a href="{{ route('dashboard') }}" class="simple-text logo-normal">
      The Techy Hub
    </a>
  </div>

  <div class="sidebar-wrapper">
    <div class="user">
			<div class="info">
      <div class="photo">
        <img src="{{ avatar_picture_url(current_user()->avatar) }}" >
      </div>
			<a data-toggle="collapse" href="#collapseExample" class="collapsed">
				<span>{{ str_limit(current_user()->name, 20) }}</span>
      </a>
			</div>
    </div>

    <ul class="nav">
      <li class="nav-item {{ is_active('dashboard') }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="fa fa-pie-chart text-info"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item {{ is_active('users') }}">
          <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fa fa-male text-info"></i>
            <p>Users</p>
          </a>
        </li>
        <li class="nav-item {{ is_active('interests') }}">
            <a class="nav-link" href="{{ route('interests.index') }}">
              <i class="fa fa-star text-info"></i>
              <p>Interests</p>
            </a>
          </li>
			<li class="nav-item {{ is_active('badges') }}">
				<a class="nav-link" href="{{ route('badges.index') }}">
					<i class="fa fa-gift text-info"></i>
					<p>Badges</p>
				</a>
			</li>
    </ul>
  </div>
</div>
