@extends('layouts.master')
@section('content')
@include('includes.message')
<div class="page-header">
	<ol class="breadcrumb breadcrumb-arrow mt-3">
		<li><a href="{{route('dashboard')}}">Home</a></li>
		<li class="active"><span>Checkout</span></li>
	</ol>
</div>
<div class="row row-cards">
	<div class="col-lg-12 col-md-12 col-sm-12 bootstrap snippets">
		<!-- Cart -->
		<div class="card">
			<div class="card-header">
				<span class="card-title">Checkout</span>
			</div>
			<div class="card-body hero-feature">
				<div class="row">
					<div class="col-md-8">
						@if($data)
						<form method="post"  id="makePay" action="{{route('makePayment')}}">
							{{ csrf_field() }}
							<div class="table-responsive push">
								<table class="table table-bordered table-hover tbl-cart text-nowrap">
									<thead>
										<tr>
											<td>Title</td>
											<td>Image</td>
											<td>Price</td>
											<td> Qty</td>
											<td> Total</td>
											<!-- <td class="td-qty"></td> -->
										</tr>
									</thead>
									<tbody>
										<?php $total =0; 
										$i =1;
										?>
										@foreach($data as $showdata)
										<?php 
										$product = App\Models\Product::find($showdata['id']);
										$total += $showdata['qty']*$showdata['price'];
										?>
										<tr>
											<td><a href="#">{!! $showdata['title'] !!}</a>
											</td>
											<td><a href="#">@if($product->img)
										<img src="{!!URL('/')!!}/assets/uploads/product/thumb/{{ $product->img }}"  class="travel-img" width="50" height="50" /> 
										@else 
										<img src="{!!URL('/')!!}/assets/img/noimage.jpg" width="50" height="50"class="travel-img" /></td>
										@endif</a>
											</td>
											<td class="price">&#8377;  {!! $showdata['price'] !!}</td>
											<td><a href="#">{!! $showdata['qty'] !!}</a>

											</td>

											<td data-label="Total" class="product-subtotal" id="subtotal-{{$showdata['id']}}">  &#8377; {{ $showdata['qty']*$showdata['price'] }}
											</tr>
											<?php $i++;?>
											@endforeach

										</tbody>
									</table>
								</div>
							</div>

							<div class="col-md-4">
								<div class="subt-total-pp">
									<div id="cart-subtotal-row"> <span class="cart-subtext-h2 floatLeft cart-feesandtaxes-text sf-tipper-target">Subtotal</span> <span class="floatRight b"><i class="fa fa-inr" aria-hidden="true"></i> {{$total}}</span> </div>
									<div class="hr-line"></div>
									<div id="cart-taxfees-row" class="cboth"> <span class="cart-subtext-h2 floatLeft cart-feesandtaxes-text sf-tipper-target"><a href="javascript:void(0)">Estimated Taxes &amp; GST </a></span> <span class="floatRight cart-feesandtaxes-value">18%</span> </div>


									<?php $amount = $total*18;
									$taxAmount = round($amount/100, 2);
									$finalTotal = round($total+ $taxAmount, 2);

									?>
									<div class="cart-os-payment-total padTop20 borderbottom1px" id="apllycoupan">
										<div id="cart-taxfees-row" class="cboth"> <span class="cart-subtext-h2 floatLeft cart-feesandtaxes-text sf-tipper-target"><a href="javascript:void(0)">Tax Amount </a></span> <span class="floatRight cart-feesandtaxes-value"><i class="fa fa-inr" aria-hidden="true"></i>  {!! $taxAmount !!} </span> </div>
										<div class="hr-line"></div>
										<span> <span id="cart-total-text" class="cart-subtext-h2 text-primary">Total</span>  </span> 
										<strong class="cart-subtext-h2 pull-right text-primary font-large"><i class="fa fa-inr" aria-hidden="true"></i> {!! $finalTotal !!}</strong> 
									</div>
									{!! Form::hidden('amount',$finalTotal,array('class'=>'form-control')) !!}

								</div>
							</div>

							<div class="col-lg-12">
								<div class="p-r-0 subt-total-pp">
									<strong for="">Payment Method</strong>
									<div class="form-group coupon-form">
										<div class="cc-selector">
											<div class="row"> 
											<div class="col-md-3">
												<input form="makePay" id="payu" type="radio" name="credit-card" value="payu" checked />
												<label class="drinkcard-cc payu" for="payu" style="background-image: url({!!URL('/')!!}/assets/payment/payu.png);"><span class="this-label">Payu</span><i class="fa fa-check-circle"></i></label>
											</div>
										</div>
										</div>
									</div>

								</div>
							</div>

							<div class="col-lg-12">
								<div class="pull-right">
									<a href="{{ route('payment-system') }}" class="btn btn-info mt-2"><i class="fa fa-long-arrow-left"></i>Back to Product List</a>
									<input  type="submit"  id="paymentButton" class="btn btn-primary btn-outline-primary mt-2" value="Make Payment">
								</div> 
							</div>
							@else
							<div class="col-lg-12">
								<div class="alert alert-warning login-alert"> <a href="javascript:;" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Cart Empty,</strong>No item in a Cart List </div>
							</div>
							@endif
				<!-- <div class="float-left mt-2">
					<div class="row">
						<div class="col-8"><input class="productcart form-control" type="text" placeholder="Apply Coupon Code"></div>
						<div class="col-4"><a href="#" class="btn btn-primary btn-md">Apply</a></div>
					</div>
				</div> -->
				
			</form>

		</div>
	</div>
	<!-- End Cart -->
</div>
</div>
@endsection
@section('extrajs')


@endsection
