<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
	<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
		<li class="m-menu__item  m-menu__item--" aria-haspopup="true"><a href="{{route('dashboard')}}" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">{{ __('messages.dashboard')}}</span>
						<span class="m-menu__link-badge"></span> </span></span></a></li>
		<!--<li class="m-menu__section ">
			<h4 class="m-menu__section-text">Components</h4>
			<i class="m-menu__section-icon flaticon-more-v2"></i>
		</li>-->

		<li class="m-menu__item  m-menu__item--submenu m-menu__item--expanded {{isset($users_links)?'m-menu__item--open m-menu__item--hover':''}}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-text">{{__('messages.sysUsers')}}</span><i
				 class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent " aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">{{__('AllAdmins')}}</span></span></li>
					<li class="m-menu__item {{isset($admins_atcive_class)?$admins_atcive_class:''}}" aria-haspopup="true"><a href="{{route('AllUsers')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.AllAdmins')}}</span></a></li>
					<li class="m-menu__item {{isset($add_admins_atcive_class)?$add_admins_atcive_class:''}} " aria-haspopup="true"><a href="{{route('AddAdminUser')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.AdminsForm')}}</span></a></li>
{{--					<li class="m-menu__item {{isset($users_atcive_class)?$users_atcive_class:''}}" aria-haspopup="true"><a href="{{route('AllRegisteredUsers')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.AllUsers')}}</span></a></li>--}}

				</ul>
			</div>
		</li>


		<li class="m-menu__item  m-menu__item--submenu m-menu__item--expanded {{isset($users_links_users)?'m-menu__item--open m-menu__item--hover':''}}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-text">مستخدمو التطبيق</span><i
						class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item {{isset($users_atcive_class)?$users_atcive_class:''}}" aria-haspopup="true"><a href="{{route('AllRegisteredUsers')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.AllUsers')}}</span></a></li>

				</ul>
			</div>
		</li>


		<li class="m-menu__item  m-menu__item--submenu {{isset($drivers_links)?'m-menu__item--open m-menu__item--hover':''}}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-truck"></i><span class="m-menu__link-text">{{__('messages.DriversRequests')}}</span><i
				 class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item {{isset($all_drivers_class)?$all_drivers_class:''}}" aria-haspopup="true"><a href="{{route('ALlUsersRequests')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.AllOrders')}}</span></a></li>
					<li class="m-menu__item {{isset($accepted_drivers_class)?$accepted_drivers_class:''}}" aria-haspopup="true"><a href="{{route('AllAcceptedDrivers')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.DriversApprovedRequests')}}</span></a></li>
                    <li class="m-menu__item {{isset($rejectes_drivers_class)?$rejectes_drivers_class:''}}" aria-haspopup="true"><a href="{{route('AllRejectedDrivers')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.DriversRejectedRequests')}}</span></a></li>
				</ul>
			</div>
		</li>

		<li class="m-menu__item  m-menu__item--submenu {{isset($drivers__links)?'m-menu__item--open m-menu__item--hover':''}}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-squares"></i><span class="m-menu__link-text">السائقون</span><i
						class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">

					<li class="m-menu__item {{isset($all_drivers__class)?$all_drivers__class:''}}" aria-haspopup="true"><a href="{{route('drivers.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">السائقون</span></a></li>
					<li class="m-menu__item {{isset($add_drivers__class)?$add_drivers__class:''}}" aria-haspopup="true"><a href="{{route('drivers.create')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">أضف جديد</span></a></li>

				</ul>
			</div>
		</li>


		<li class="m-menu__item  m-menu__item--submenu {{isset($services_links)?'m-menu__item--open m-menu__item--hover':''}}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-squares"></i><span class="m-menu__link-text">{{__('messages.AllServices')}}</span><i
				 class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">

                    <li class="m-menu__item {{isset($all_services_class)?$all_services_class:''}}" aria-haspopup="true"><a href="{{route('AllServices')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.AllServices')}}</span></a></li>
                    <li class="m-menu__item {{isset($add_services_class)?$add_services_class:''}}" aria-haspopup="true"><a href="{{route('AddService')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.addService')}}</span></a></li>

				</ul>
			</div>
		</li>

		<li class="m-menu__item  m-menu__item--submenu {{isset($orders_links)?'m-menu__item--open m-menu__item--hover':''}}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">{{__('messages.all Orders')}}</span><i
				 class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">

                    <li class="m-menu__item {{isset($all_orders_class)?$all_orders_class:''}}" aria-haspopup="true"><a href="{{route('AllNewOrders')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.AllOrders')}}</span></a></li>
					<li class="m-menu__item {{isset($refused_orders_class)?$refused_orders_class:''}}" aria-haspopup="true"><a href="{{route('RefusedOrders')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.refused_orders')}}</span></a></li>
                    <li class="m-menu__item {{isset($inprogress_orders_class)?$inprogress_orders_class:''}}" aria-haspopup="true"><a href="{{route('ProgressOrders')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.inprogress_orders')}}</span></a></li>
                    <li class="m-menu__item {{isset($cancelled_orders_class)?$cancelled_orders_class:''}}" aria-haspopup="true"><a href="{{route('CancelledOrders')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.cancelled_orders')}}</span></a></li>
                    <li class="m-menu__item {{isset($finished_orders_class)?$finished_orders_class:''}}" aria-haspopup="true"><a href="{{route('allFinishedOrders')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.finished_orders')}}</span></a></li>
				</ul>
			</div>
		</li>

        <li class="m-menu__item  m-menu__item--submenu {{isset($contact_links)?'m-menu__item--open m-menu__item--hover':''}}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-multimedia-2"></i><span class="m-menu__link-text">إتصل بنا</span><i
				 class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">كل الرسائل</span></span></li>
					<li class="m-menu__item {{isset($contact_class)?$contact_class:''}}" aria-haspopup="true"><a href="{{route('Contact_us_messages')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">كل الرسائل</span></a></li>

				</ul>
			</div>
		</li>

		<li class="m-menu__item  m-menu__item--submenu {{isset($settings_links)?'m-menu__item--open m-menu__item--hover':''}}" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-cogwheel-2"></i><span class="m-menu__link-text">{{__('messages.AppSettings')}}</span><i
				 class="m-menu__ver-arrow la la-angle-right"></i></a>
			<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">{{__('messages.AppSettings')}}</span></span></li>
					<li class="m-menu__item {{isset($settings_class)?$settings_class:''}}" aria-haspopup="true"><a href="{{route('AppSettings')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.AppSettings')}}</span></a></li>
					<li class="m-menu__item {{isset($slider_class)?$slider_class:''}}" aria-haspopup="true"><a href="{{route('slider.index')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{__('messages.Slider')}}</span></a></li>
				</ul>
			</div>
		</li>


		<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{url('Admin/logout')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-logout"></i><span class="m-menu__link-text">{{__('messages.Logout')}}</span></a>
		</li>


	</ul>
</div>
