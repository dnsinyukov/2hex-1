@extends('layouts.app')

@section('title', 'SKATEBOARD PRODUCTION CONFIGURATOR')

@push('head.meta')
    <meta name="description" content="2HEX skateboard configurator summary. A manufacturer of skateboards, skateboard decks, skateboard wheels, skateboard griptapes and high quality complete skateboards.">

	<meta name="keywords" content="skateboard production configurator, skateboard configurator, skateboard manufacturer, skateboard supplier, skateboard factory, skateboard, manufacturer, supplier, factory, skateboard manufacturers, skateboard factories, 2hex, Germany, Australia, Europe, England, Great Britain, Board, skateboard production">
@endpush

@section('content')
	@php 
		$isAdmin = auth()->check() && auth()->user()->isAdmin();
		setlocale(LC_MONETARY, 'en_US');
	@endphp

	<div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <!-- BEGIN: Subheader -->
		<div class="m-subheader ">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="m-subheader__title m-subheader__title--separator">ORDER SUMMARY</h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="#" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="/" class="m-nav__link">
								<span class="m-nav__link-text">Products</span>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="skateboard-manufacturer/skateboard-deck-manufacturer.html" class="m-nav__link">
								<span class="m-nav__link-text">Skateboard Decks</span>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="/skateboard-deck-configurator" class="m-nav__link">
								<span class="m-nav__link-text">Online Order</span>
							</a>
						</li>
                        <li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="/summary" class="m-nav__link">
								<span class="m-nav__link-text">Summary</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
        
        
		<!-- END: Subheader -->
		<div class="m-content">
			
			@if(session()->has('success'))
				<submit-order-modal></submit-order-modal>
				<div 
					class="alert alert-brand m-alert m-alert--icon m-alert--air m-alert--square m--margin-bottom-30" 
					role="alert"
					style="background-color: #008000;"
				>
	                <div class="m-alert__icon">
	                    <i class="flaticon-exclamation-1"></i>
	                </div>
	                <div class="m-alert__text">
	                    {{session()->get('success')}}
	                </div>
	            </div>		
			@endif
            
			<div class="m-portlet">
				<div class="m-portlet__head" style="flex-wrap: wrap;height: auto;float: right;">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
						</div>
					</div>
					<div class="m-portlet__head-tools" style="flex-wrap:wrap;">
						@if(Session::get('viewonly') == null)

						<div class="dropdown">
						  	<button 
						  		class="btn m-btn dropdown-toggle dropdown-toggle-split m-btn--gradient-from-primary m-btn--gradient-to-info"
						  		type="button"
						  		data-toggle="dropdown"
						  		aria-haspopup="true" 
						  		aria-expanded="false"
						  		id="actions"
					  		>
						    	Add More
						  	</button>


						  	<div class="dropdown-menu" aria-labelledby="actions">
						  		<a class="dropdown-item" href="{{ route('griptape.index') }}">
						  			Add Griptapes
						  		</a>
						  		<a class="dropdown-item" href="{{ route('get.skateboard.configurator') }}">
						  			Add Decks
						  		</a>
								<a class="dropdown-item" href="{{ route('wheels.configurator') }}">
									Add Wheels
								</a>
						  		@if($isAdmin)
									<a class="dropdown-item" href="{{ route('get.skateboard.configurator') }}">
										Saved Batches
									</a>
								@endif
								
						  	</div>

						</div>

                        <ul class="m-portlet__nav">
							<li class="m-portlet__nav-item">
								<a href="profile#m_user_profile_tab_2" class="btn btn-secondary m-btn m-btn--custom m-btn--icon m-btn--air">
									<span>
										<i class="la la-ship"></i>
										<span>Check Address</span>
									</span>
								</a>
							</li>
						</ul>
                        @endif
                        
					</div>
      
				</div>
				<div class="m-portlet__body">
					<div class="pane pane--table2">
					<table class="table table-striped- table-bordered table-hover table-checkable table-responsive" id="summary-table">
						<tr>
							@if(count($orders) > 0)
								@include('partials.skateboards', ['skateboards' => $orders])
							@endif
							
							@if(count($grips) > 0)
								@include('partials.grips', ['grips' => $grips])
							@endif

							@if(count($wheels) > 0)
								@include('partials.wheels', ['wheels' => $wheels])
							@endif

							<thead style="background-color: #52a3f0; color: white;">
								<tr>
									<td colspan="3">Fixed Cost</td>
									<td colspan="3">Batches</td>
									<td colspan="2">Colors</td>
									<td colspan="5">Filename</td>
									<td>Fixed&nbspTotal</td>
								</tr>
						   	</thead>

                            @foreach($fees as $key => $group)
                            	@foreach($group as $k => $value)
                            		<tr>
										<td colspan="3">{{ $value['type'] }}</td>
										<td colspan="3">{{ $value['batches'] }}</td>
										<td colspan="2">{{ array_key_exists('color', $value) ? $value['color'] : '' }}</td>
										<td colspan="5">{{ $value['image'] }}</td>
										<td>{{ auth()->check() ? money_format('%.2n', $value['price']) : '$?.??' }}</td>
									</tr>
                            	@endforeach
							@endforeach

							@if(! empty($orders->first()->promocode))
								@php 
									$promocode = json_decode($orders->first()->promocode); 
								@endphp
								<tr>
									<td colspan="8">Discount</td>

									<td colspan="5">{{ $promocode->code }}</td>
									<td>{{ $promocode->type == 'fixed' 
										? money_format('-%.2n', $promocode->reward)
										: ($promocode->reward . '%')}}</td>
								</tr>		
							@endif

							<tr>
								<td colspan="16"></td>
							</tr>
						</tr>

					</table>
					</div>

					<!--begin: Datatable (color options: #4CAF50, #586ad5, #8933eb, #52a3f0 or #60bca4) -->
			
					<div class="m-portlet__head" style="padding-left:0;flex-wrap: wrap;">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title" style="padding-left: 20px;">
								<h3 class="m-portlet__head-text">
									USD TOTAL:  {{ auth()->check() ? money_format('%.2n', $totalOrders) : '$?.??' }}
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							@if(Session::get('viewonly') != null)
							
							@else
							<ul class="m-portlet__nav">
								
								<!-- <li class="m-portlet__nav-item">
									<a href="{{ route('export.invoice') }}" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" >
										<span>
											<i class="la la-save"></i>
											<span>ExportInvoice</span>
										</span>
									</a>
								</li> -->

								<li class="m-portlet__nav-item">
									<btn-order-later/>
								</li>
								
								<li class="m-portlet__nav-item">
									@php $auth = auth()->user(); @endphp
									
									@if (
										$auth 
										&& strlen($auth->company_name) 
										&& strlen($auth->position) 
										&& strlen($auth->phone_num)
									)
										@php 
											$gripsQuantity = $grips->sum('quantity');
											$wheelsQuantity = $wheels->sum('quantity');
										@endphp

										@if(($gripsQuantity == 0 && $totalOrders > 1170) || ($totalOrders > 1170 && $gripsQuantity > 0))
											<a href="{{ route('orders.submit') }}" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-rocket"></i>
													<span>SUBMIT</span>
												</span>
											</a>
										@else
											@php 
												$message = 'Your order is too small to add custom grip tapes. Please order at least a total of 400 grip tapes or 50 decks to enable grip tapes.';
											@endphp

											@if($wheelsQuantity < 300 && $wheelsQuantity != 0)
												@php 
													$message = 'Your ordered too few wheels to run a custom wheels production. Please order at least 300 sets of wheels.'; 
												@endphp
											@endif
											<a 
												href="javascript:void(0);" 
												class="btn btn-secondary m-btn m-btn--custom m-btn--icon"
												onclick="alert('{{$message}}')"
											>
											<span>
												<i class="la la-rocket"></i>
												<span>SUBMIT</span>
											</span>
										</a>
										@endif
									@else
									<a 
										href="javascript:void(0);" 
										class="btn btn-secondary m-btn m-btn--custom m-btn--icon"
										onclick="alert('Please fill in your complete profile before submitting an order')"
									>
										<span>
											<i class="la la-rocket"></i>
											<span>SUBMIT</span>
										</span>
									</a>
									@endif
								</li>
							</ul>
							@endif
						</div>
					</div>
				</div>
            </div>

            <!-- TOTAL ORDERS QUANTITY LESS 40 -->
            @if($orders->count() && $orders->sum('quantity') <= 40)
				@include('partials.warning-quantity-less')
			@endif

			<!-- VENDOR CODE -->
			@if(!$orders->every->submit && !session()->get('viewonly'))
				@include('partials.vendor-code')
				<!-- <vendor-code /> -->
			@endif
            
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
	<change-name-order-modal></change-name-order-modal>
@endsection