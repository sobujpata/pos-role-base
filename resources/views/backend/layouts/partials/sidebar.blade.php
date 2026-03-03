		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{ asset('assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Localbazer</h4>
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
				@can('product-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Online Invoices</div>
					</a>
					<ul>
						@can('pos-view')
						<li>
							<a href="{{ route('invoice.index') }}"><i class='bx bx-radio-circle'></i>New Invoices</a>
						</li>
						@endcan
						@can('pos-create')
						<li>
							<a href="{{ route('invoice.index') }}"><i class='bx bx-radio-circle'></i>Complete Invoices</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('pos-menu')
				<li class="menu-label">Point of Sales Pages</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">Point of Sale</div>
					</a>
					<ul>
						@can('pos-view')
						<li>
							<a href="{{ url('/point-of-sales') }}"><i class='bx bx-radio-circle'></i>Create Sale</a>
						</li>
						@endcan
						@can('pos-create')
						<li>
							<a href="{{ url('/invoicePage') }}"><i class='bx bx-radio-circle'></i>Invoice for POS</a>
						</li>
						@endcan
						@can('pos-create')
						<li>
							<a href="{{ url('/pos-by-barcode-scanner') }}"><i class='bx bx-radio-circle'></i>Create Sale by Barcode Scanner</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				
				@can('product-menu')
				<li class="menu-label">Product Details Pages</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-box"></i></div>
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
						@can('product-create')
						<li>
							<a href="{{ url('/import-product-page') }}"><i class='bx bx-radio-circle'></i>Import Product</a>
						</li>
						@endcan
						@can('product-create')
						<li>
							<a href="{{ url('/product-barcode-generate') }}"><i class='bx bx-radio-circle'></i>Barcode Generate</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				
				@can('category-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i></div>
						<div class="menu-title">Main Category</div>
					</a>
					<ul>
						@can('category-view')
						<li>
							<a href="{{ route('MainCategories.index') }}"><i class='bx bx-radio-circle'></i>All category</a>
						</li>
						@endcan
						@can('category-create')
						<li>
							<a href="{{ route('MainCategories.create') }}"><i class='bx bx-radio-circle'></i>Create category</a>
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
				@can('category-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-bitcoin"></i></div>
						<div class="menu-title">Brand</div>
					</a>
					<ul>
						@can('category-view')
						<li>
							<a href="{{ route('brand.index') }}"><i class='bx bx-radio-circle'></i>All category</a>
						</li>
						@endcan
						@can('category-create')
						<li>
							<a href="{{ route('brand.create') }}"><i class='bx bx-radio-circle'></i>Create category</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('color-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-palette"></i></div>
						<div class="menu-title">Colors</div>
					</a>
					<ul>
						@can('color-view')
						<li>
							<a href="{{ route('colors.index') }}"><i class='bx bx-radio-circle'></i>All Colors</a>
						</li>
						@endcan
						@can('color-create')
						<li>
							<a href="{{ route('colors.create') }}"><i class='bx bx-radio-circle'></i>Create Color</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('color-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-left-top-arrow-circle"></i></div>
						<div class="menu-title">Sizes</div>
					</a>
					<ul>
						@can('color-view')
						<li>
							<a href="{{ route('sizes.index') }}"><i class='bx bx-radio-circle'></i>All Sizes</a>
						</li>
						@endcan
						@can('color-create')
						<li>
							<a href="{{ route('sizes.create') }}"><i class='bx bx-radio-circle'></i>Create Sizes</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('color-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-circle"></i></div>
						<div class="menu-title">Tags</div>
					</a>
					<ul>
						@can('color-view')
						<li>
							<a href="{{ route('tags.index') }}"><i class='bx bx-radio-circle'></i>All tags</a>
						</li>
						@endcan
						@can('color-create')
						<li>
							<a href="{{ route('tags.create') }}"><i class='bx bx-radio-circle'></i>Create tags</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('subscribe-menu')
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-circle"></i></div>
						<div class="menu-title">Subscribe</div>
					</a>
					<ul>
						@can('subscribe-menu')
						<li>
							<a href="{{ route('subscribe-notice.index') }}"><i class='bx bx-radio-circle'></i>Subscribe page settings</a>
						</li>
						@endcan
						@can('subscribe-menu')
						<li>
							<a href="{{ route('subscribe-notice.create') }}"><i class='bx bx-radio-circle'></i>Create tags</a>
						</li>
						@endcan
					</ul>
				</li>
				@endcan
				
				
				
				
				@can('role-menu')
				<li class="menu-label">Super Admin Pages</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-lock'></i>
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