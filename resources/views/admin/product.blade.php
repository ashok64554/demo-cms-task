@extends('layouts.master')
@section('extracss')
{!! Html::style('assets/js/bootstrap-fileupload/bootstrap-fileupload.css') !!}
@endsection
@section('content')

@if(Request::segment(2)==='edit-product' || Request::segment(2)==='add-product')
@if(Request::segment(2)==='add-product')
<?php
$id          	= '';
$title       	= '';
$description   	= '';
$oldImage    	= '';
$category_id    	= '';
$price    	= '';
$required    	='required';
?>
@else
<?php
$id          	= $product->id;
$title       	= $product->title;
$description   	= $product->description;
$oldImage    	= $product->img;
$category_id    = $product->category_id;
$price    		= $product->price;
$required    	='';
?>
@endif
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">
					@if(Request::segment(2)==='add-product')
					Add
					@else
					Edit
					@endif
					Product
				</h3>
				<div class="card-options">

				</div>
			</div>
			<div class="card-body">
				{{ Form::open(array('route' => 'product-save', 'class'=> 'form-horizontal','enctype'=>'multipart/form-data','files'=>true)) }}
				{!! Form::hidden('id',$id,array('class'=>'form-control')) !!}
				{!! Form::hidden('oldImage',$oldImage,array('class'=>'form-control')) !!}
				
				@csrf
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<label for="title" class="form-label">Title</label>
							{!! Form::text('title',$title,array('id'=>'title','class'=> $errors->has('title') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>' title', 'autocomplete'=>'off', $required)) !!}
							@if ($errors->has('title'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
							@endif
						</div>
					</div>
					
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<label for="name" class="form-label">Category</label>
							{!! Form::select('category_id',$categories,$category_id, ['class' => 'form-control','id'=>'category_id', $required, 'data-placeholder' => '--Select Category--']) !!}
							@if ($errors->has('category_id'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('category_id') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-12">
						<div class="form-group">
							<label for="desc" class="form-label">Description</label>
							{!! Form::textarea('description',$description, array('id'=>'description','class'=> $errors->has('description') ? 'form-control is-invalid state-invalid' : 'form-control', 'rows'=>'4', 'placeholder'=>'description', 'autocomplete'=>'off',$required)) !!} 

							@if ($errors->has('description'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
							@endif
						</div>
					</div>
					
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<label for="name" class="form-label">Price</label>
							{!! Form::number('price',$price,array('id'=>'price','class'=> $errors->has('price') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>' price', 'autocomplete'=>'off', $required)) !!}
							@if ($errors->has('price'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('price') }}</strong>
							</span>
							@endif
						</div>
					</div>
					
					<div class="col-xs-6 col-sm-6 col-md-12">
						<div class="form-group">
						<label for="app_logo" class="form-label">Image</label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
								@if($oldImage!= '')
								<img id="imageThumb" src="{!!URL('/')!!}/assets/uploads/product/{{ $oldImage }}"> 
								@else
								<img id="imageThumb" src="{!!URL('/')!!}/assets/img/noimage.jpg"> 
								@endif
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
						</div>
						<div>
							<span class="btn btn-outline-primary btn-file">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
								{!! Form::file('image',array('id'=>'image','data-icon'=>'false', 'accept'=>'image/*','onchange'=> 'readURL(this)',$required)) !!}

							</span> 
						</div>
						@if ($errors->has('image'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('image') }}</strong>
						</span>
						@endif
					</div>
						
				</div>

				<div class="form-footer text-center">
                    {!! Form::submit('Save', array('class'=>'btn btn-primary btn-fixed')) !!}
                </div>
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>
</div>
@else
<div class="row">
	<div class="col-12">
		<div class="table-responsive">

			<div class="card">
				<div class="card-header">
					<h3 class="card-title "><b>Products</b></h3>
					<div class="card-options">
                     @can('product-create')
						<a class="btn btn-sm btn-outline-primary" href="{{route('add-product')}}"> <i class="fa fa-plus"></i> Add Product</a>
					 @endcan
					&nbsp;&nbsp;&nbsp;<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a> 
					
					</div>
				</div>
				  {{ Form::open(array('route' => 'product-import', 'class'=> 'form-horizontal','enctype'=>'multipart/form-data', 'files'=>true)) }}
		            @csrf
		            <div class="row div-margin">
		                <div class="col-md-2 col-sm-6 col-xs-6">
		                    <div class="input-group"> 
		                        <span class="btn btn-outline-primary btn-file">
		                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Choose File</span>
		                            {!! Form::file('file',array('id'=>'file','data-icon'=>'false','required'=>'required')) !!}

		                        </span> 
		                    </div>
		                </div>
		                <div class="col-md-8 col-sm-6 col-xs-6">
		                    <div class="input-group">
		                        <button type="submit" class="btn btn-danger">Excel Upload</button>
		                    </div>
		                </div>
		                <div class="col-md-2 col-sm-6 col-xs-6">
		        		<a href="{{ route('product-export') }}" class="btn btn-danger">Export</a>
		        		</div>
		            </div>
		           {{ Form::close() }}
		       
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="table table-striped table-bordered ">
							<thead>
								<tr>
									<th scope="col" >#</th>
									<th scope="col">Title</th>             
									<th scope="col">Price</th> 
									<th scope="col">Category</th> 
									<th scope="col">Image</th> 
									<th scope="col" width="10%">Action</th>
									
								</tr>
							</thead>
							<tbody>
								@if($products != '')
								<?php $i=1;?>
								@foreach($products  as $key=>$rows)
								<tr>
									<td>{{ $i++ }}</td>
									<td>{!! $rows->title!!}</td>   
									<td>{!! $rows->price !!}</td> 
									<td>{!! ($rows->category) ? $rows->category->title :'' !!}</td> 
									<td>@if($rows->img)
										<img src="{!!URL('/')!!}/assets/uploads/product/thumb/{{ $rows->img }}"  class="travel-img" width="50" height="50" /> 
										@else 
										<img src="{!!URL('/')!!}/assets/img/noimage.jpg" width="50" height="50"class="travel-img" /></td>
										@endif
									
									<td>
										<div class="btn-group btn-group-xs">                                   
                                            @can('product-edit')
											<a class="btn btn-sm btn-primary" href="{{ route('edit-product',array('id'=>$rows->id)) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
											@endcan
											@can('product-delete')
											 <a class="btn btn-sm btn-danger" href="{{ route('delete-product',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>
											@endcan
											
                                          
										</div>
									</td>
									
								</tr>
								@endforeach
								@endif
							</tbody>
						</table>
					</div>

				</div>
				
			</div>
		</div>
	</div>
</div>
@endif
@endsection
@section('extrajs')


</script>
@endsection