<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{ asset('assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Rocker</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="{{ url('/dashboard') }}" class="">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>

				</li>
				@can('category-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i></div>
						<div class="menu-title">Main Category</div>
					</a>
					<ul>
						@can('category-view')
						<li>
							<a href="{{ route('categories.index') }}"><i class='bx bx-radio-circle'></i>All category</a>
						</li>
						@endcan
						@can('category-create')
						<li>
							<a href="{{ route('categories.create') }}"><i class='bx bx-radio-circle'></i>Create category</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('category-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i></div>
						<div class="menu-title">Category</div>
					</a>
					<ul>
						@can('category-view')
						<li>
							<a href="{{ route('categories.index') }}"><i class='bx bx-radio-circle'></i>All category</a>
						</li>
						@endcan
						@can('category-create')
						<li>
							<a href="{{ route('categories.create') }}"><i class='bx bx-radio-circle'></i>Create category</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('product-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i></div>
						<div class="menu-title">Product</div>
					</a>
					<ul>
						@can('product-view')
						<li>
							<a href="{{ route('products.index') }}"><i class='bx bx-radio-circle'></i>All Product</a>
						</li>
						@endcan
						@can('product-create')
						<li>
							<a href="{{ route('products.create') }}"><i class='bx bx-radio-circle'></i>Create Product</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				<li class="menu-label">Pages</li>
				@can('role-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Role and Permission</div>
					</a>
					<ul>
						@can('role-view')
						<li>
							<a href="{{ url('/roles') }}"><i class='bx bx-radio-circle'></i>All Roles</a>
						</li>
						@endcan
						@can('role-create')
						<li>
							<a href="{{ url('/roles/create') }}"><i class='bx bx-radio-circle'></i>Create Role</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('permission-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-key'></i>

						</div>
						<div class="menu-title">Permissions</div>
					</a>
					<ul>
						@can('permission-view')
						<li>
							<a href="{{ url('/permissions') }}"><i class='bx bx-radio-circle'></i>All Permissions</a>
						</li>
						@endcan
						@can('permission-create')
						<li>
							<a href="{{ url('/permissions/create') }}"><i class='bx bx-radio-circle'></i>Create Permission</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('user-menu')
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-user-circle"></i>
						</div>
						<div class="menu-title">Users</div>
					</a>
					<ul>
						@can('user-view')
						<li>
							<a href="{{ route('users.index') }}"><i class='bx bx-radio-circle'></i>All Users</a>
						</li>
						@endcan
						@can('user-create')
						<li>
							<a href="{{ route('user.create') }}"><i class='bx bx-radio-circle'></i>Create User</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('menu-menu')
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-user-circle"></i>
						</div>
						<div class="menu-title">Menus</div>
					</a>
					<ul>
						@can('menu-view')
						<li>
							<a href="{{ route('menus.index') }}"><i class='bx bx-radio-circle'></i>All Menus</a>
						</li>
						@endcan
						@can('menu-create')
						<li>
							<a href="{{ route('menus.create') }}"><i class='bx bx-radio-circle'></i>Create Menu</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				

			</ul>
			<!--end navigation-->
		</div>