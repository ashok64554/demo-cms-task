@extends('layouts.master')
@section('content')
<div class="page-header">
	<ol class="breadcrumb breadcrumb-arrow mt-3">
		<li><a href="{{route('dashboard')}}">Home</a></li>
		<li class="active"><span>Cart</span></li>
	</ol>
</div>

<div class="row row-cards">
	<div class="col-lg-12 col-md-12 col-sm-12 bootstrap snippets">
		<!-- Cart -->
		<div class="card">
			<div class="card-header">
				<span class="card-title">Cart View</span>
			</div>
			<div class="card-body hero-feature">
				 @if(count($data)>0)
				 <form method="post" action="{{route('updateCart')}}">
  					{{ csrf_field() }}
				<div class="table-responsive push">
					<table class="table table-bordered table-hover tbl-cart text-nowrap">
						<thead>
							<tr>
								<td>Title</td>
								<td>Image</td>
								<td>Price</td>
								<td class="td-qty"> Qty</td>
								<td>Remove</td>
								<td>Sub Total</td>
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
								<td class="text-primary">{!! $showdata['title'] !!}</td>
								<td class="text-primary">
										@if($product->img)
										<img src="{!!URL('/')!!}/assets/uploads/product/thumb/{{ $product->img }}"  class="travel-img" width="50" height="50" /> 
										@else 
										<img src="{!!URL('/')!!}/assets/img/noimage.jpg" width="50" height="50"class="travel-img" /></td>
										@endif</td>
								<td class="price">&#8377;  {!! $showdata['price'] !!}</td>
								<td class="text-primary">{!! $showdata['qty'] !!}</td>
								
								<td>
									<div class="input-group bootstrap-touchspin">
										<span class="input-group-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Decrement by 1">
											<button class="btn btn-primary bootstrap-touchspin-down ddd"  type="button">-</button>
										</span>
										<span class="input-group-addon bootstrap-touchspin-prefix d-none"></span>
										<input type="hidden" name="price" value="{{$showdata['price']}}" class="input-price form-control text-center d-block" >
										<input type="hidden" name="rowId" value="{{$showdata['id']}}" class="input-rowId form-control text-center d-block" >
										<input type="text" name="{{$showdata['id']}}" id="qty" value="{{$showdata['qty']}}" class="input-qty form-control text-center d-block quantity" min='1'>
										<span class="input-group-addon bootstrap-touchspin-postfix d-none"></span>
										<span class="input-group-append" data-toggle="tooltip" data-placement="top" title="" data-original-title="Increment by 1">
											<button class="btn btn-primary  bootstrap-touchspin-up ddd" type="button">+</button>
										</span>
									</div>
								</td>
								</td>
								<td class="text-center">
									<a href="{{ url('itemremove') }}/{{$showdata['id']}}" class="btn btn-primary btn-outline-primary remove_cart"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove">
										<i class="fa fa-trash-o"></i>
									</a>
								</td>
								<td data-label="Total" class="product-subtotal" id="subtotal-{{$showdata['id']}}"> {{$showdata['qty']}} x {{$showdata['price']}} =  &#8377; {{ $showdata['qty']*$showdata['price'] }}
							</tr>
							<?php $i++;?>
							 @endforeach
							<tr>
								<td colspan="7"><strong class="pull-right font-weight-bold">Total</strong></td>
								<input type="hidden" name="subtotal-amount"  id="subtotal-amount" value="{{$total}}" >
								<td class="total font-weight-bold"  id="total-amount">&#8377; {{$total}}
								</td>
								
							</tr>
						</tbody>
					</table>
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
				<div class=" float-right">
					<a href="{{ route('payment-system') }}" class="btn btn-primary mt-2"><i class="fa fa-long-arrow-left"></i>Back to Product</a>
					<input type="submit" class="btn btn-warning mt-2 btn-outline-primary" value="Update Cart">
					<a href="{{ route('checkout') }}" class="btn btn-primary mt-2">Checkout <i class="fa fa-long-arrow-right"></i></a>
				</div>
				</form>

			</div>
		</div>
		<!-- End Cart -->
	</div>
</div>
@endsection
@section('extrajs')
<script type="text/javascript">
$(".ddd").on("click", function () {
    var $button = $(this);
    var oldValue = $button.closest('.input-group').find("input.input-qty").val();
    var price 	= $button.closest('.input-group').find("input.input-price").val();
    var rowId 	= $button.closest('.input-group').find("input.input-rowId").val();
    var total=0;
    if ($button.text() == "+") {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        // Don't allow decrementing below zero
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 0;
        }
    }

    $button.closest('.input-group').find("input.input-qty").val(newVal);
    var total  = newVal* price;
    var subtotal = newVal + 'x'+price+ '='+'&#8377;'+ newVal*price;
    document.getElementById("subtotal-"+rowId).innerHTML = subtotal;
    findTotal()
});

function findTotal(){
	 	var arr = document.getElementsByClassName('quantity');
        var scale = document.getElementsByName('price');
        var tot = 0;
        for(var i=0;i<arr.length;i++){
            if(arr[i].value != "" && scale[i].value != ""){
                tot += parseInt(scale[i].value) * parseInt(arr[i].value);
            
            }
        }
        document.getElementById('subtotal-amount').value = tot;
       document.getElementById("total-amount").innerHTML = '&#8377;'+ tot;
}




</script>

@endsection
