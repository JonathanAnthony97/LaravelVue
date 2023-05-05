@extends('layouts.app')

@section('content')
<div class="wrapper" id="app">
		<!--
				Tip 1: You can change the background color of the main header using: data-background-color="blue | purple | light-blue | green | orange | red"
		-->
		<navbar ref="navbarLink"></navbar>
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<!--<div class="page-header">
						<h5 class="page-title">@{{ target }}</h5>
							<ul class="breadcrumbs">
								<li class="nav-home">
									<a href="#">
										<i class="flaticon-home"></i>
									</a>
								</li>
								<template v-if="link">
									<li  class="separator">
										<i class="flaticon-right-arrow"></i>
									</li>
									<li class="nav-item">
										<a href="#">@{{ link }}</a>
									</li>
									<li class="separator">
										<i class="flaticon-right-arrow"></i>
									</li>
									<li class="nav-item">
										<a href="#">@{{ target }}</a>
									</li>
								</template>
								
							</ul>
					</div>-->
					<div class="page-category">
						<router-view></router-view>
					</div>
				</div>
			</div>
			
		</div>
		<!-- Custom template | don't include it in your project!
		<div class="custom-template">
			<div class="title">Settings</div>
			<div class="custom-content">
				<div class="switcher">
					<div class="switch-block">
						<h4>Topbar</h4>
						<div class="btnSwitch">
							<button type="button" class="changeMainHeaderColor" data-color="blue"></button>
							<button type="button" class="selected changeMainHeaderColor" data-color="purple"></button>
							<button type="button" class="changeMainHeaderColor" data-color="light-blue"></button>
							<button type="button" class="changeMainHeaderColor" data-color="green"></button>
							<button type="button" class="changeMainHeaderColor" data-color="orange"></button>
							<button type="button" class="changeMainHeaderColor" data-color="red"></button>
						</div>
					</div>
					<div class="switch-block">
						<h4>Background</h4>
						<div class="btnSwitch">
							<button type="button" class="changeBackgroundColor" data-color="bg2"></button>
							<button type="button" class="changeBackgroundColor selected" data-color="bg1"></button>
							<button type="button" class="changeBackgroundColor" data-color="bg3"></button>
						</div>
					</div>
				</div>
			</div>
			<div class="custom-toggle">
				<i class="flaticon-settings"></i>
			</div>
		</div>
		End Custom template -->
</div>
 
@endsection
