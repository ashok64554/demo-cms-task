@extends('layouts.master')
@section('content')
<div class="page-header">
	<ol class="breadcrumb breadcrumb-arrow mt-3">
		<li><a href="{{route('dashboard')}}">Home</a></li>
		<li class="active"><span>Products</span></li>
	</ol>
</div>

<div class="row row-deck">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">
               Buy Product
            </h3>
         </div>
         <div class="card-body">
         	<div class="row">
		@if(count($allproduct)>0)
		<?php $i = 0;?>
		@foreach($allproduct as $product)
		<div class="col-sm-6 col-lg-6 col-xl-3 ">
			<div class="card">
				<div class="card-body text-center pricing @if($i%2 =='0')bg-primary @else bg-secondary @endif">
					<div class="card-category">{!! $product->title  !!}</div>
					<div class="display-3 my-4"> &#8377; {!! ROUND($product->price,2)  !!}</div>
					<div class="card-category">{!! ($product->category) ? $product->category->title:'' !!}</div>
					<div class="text-center mt-5">
						<a href="javacript:;"  id="buy-now-product" data-id="{!! $product->id !!}"    class="btn btn-white btn-block">Buy Now</a>
					</div>
				</div>
			</div>
		</div>
		<?php $i++;?>
		@endforeach
		@endif
		
		
	</div>
         </div>
     </div>
 </div>
</div>
		
			
	
@endsection