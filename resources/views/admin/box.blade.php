@extends('layouts.master')
@section('extracss')
{!! Html::style('assets/js/bootstrap-fileupload/bootstrap-fileupload.css') !!}
{!! Html::style('assets/plugins/select2/select2.min.css') !!}
@endsection
@section('content')

@if(Request::segment(2)==='edit-box' || Request::segment(2)==='add-box')
@if(Request::segment(2)==='add-box')
<?php
$id          	= '';
$name       	= '';
$description   	= '';
$oldImage    	= '';
$resubscribePeriod    	= '';
$required    	='required';
?>
@else
<?php
$id          	= $box->id;
$name       	= $box->name;
$description   	= $box->description;
$oldImage    	= $box->img;
$resubscribePeriod    	= $box->resubscribePeriod;
$required    	='';
?>
@endif
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-name">
					@if(Request::segment(2)==='add-box')
					Add
					@else
					Edit
					@endif
					Box
				</h3>
				<div class="card-options">

				</div>
			</div>
			<div class="card-body">
				{{ Form::open(array('route' => 'box-save', 'class'=> 'form-horizontal','enctype'=>'multipart/form-data','files'=>true)) }}
				{!! Form::hidden('id',$id,array('class'=>'form-control')) !!}
				{!! Form::hidden('oldImage',$oldImage,array('class'=>'form-control')) !!}
				
				@csrf
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<label for="name" class="form-label">Name</label>
							{!! Form::text('name',$name,array('id'=>'name','class'=> $errors->has('name') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>' name', 'autocomplete'=>'off', $required)) !!}
							@if ($errors->has('name'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
							@endif
						</div>
					</div>
					
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<label for="name" class="form-label">Subscribe Period</label>
							{!! Form::select('resubscribePeriod',$ReceiveOption,$resubscribePeriod, ['class' => 'form-control','id'=>'resubscribePeriod', $required, 'data-placeholder' => '--Select resubscribe Period--']) !!}
							@if ($errors->has('resubscribePeriod'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('resubscribePeriod') }}</strong>
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
							<label for="name" class="form-label">Product</label>
							<select class="form-control select2" id="products" name="products[]" multiple="multiple" placeholder="Select Product" required="">
                                    @foreach($allProduct as $key => $value)
                                        <option value="{{ $value->id }}" {{ (in_array($value->id,$boxProduct)) ? 'selected' : '' }} >{{ $value->title }} &nbsp;&nbsp;&nbsp;
                                        </option>
                                    @endforeach
                                </select>
							@if ($errors->has('products'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('products') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<label for="name" class="form-label">Benifits</label>
							<select class="form-control select2" id="benefitIds" name="benefitIds[]" multiple="multiple"  placeholder="Select Benifits" required="">
                                    @foreach($allBenifites as $key => $value)
                                        <option value="{{ $value->id }}" {{ (in_array($value->id,$boxBenifits)) ? 'selected' : '' }} >{{ $value->name }} &nbsp;&nbsp;&nbsp;
                                        </option>
                                    @endforeach
                                </select>
							@if ($errors->has('benefitIds'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('benefitIds') }}</strong>
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
								<img id="imageThumb" src="{!!URL('/')!!}/assets/uploads/box/{{ $oldImage }}"> 
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
					<h3 class="card-title "><b>Boxes</b></h3>
					<div class="card-options">
                     @can('box-create')
						<a class="btn btn-sm btn-outline-primary" href="{{route('add-box')}}"> <i class="fa fa-plus"></i> Add News Box</a>
					 @endcan
					 @can('assigne-box')
						&nbsp;&nbsp;&nbsp;
						 <a class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#assigneBoxs" id="assigneBoxId" data-id="" href="javascript:;" class="btn btn-sm btn-outline-primary" > <i class="fa fa-user"></i> Assign Box  To User</a>
						 	&nbsp;&nbsp;&nbsp;<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a> 
					@endcan
					</div>
				</div>
				
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="table table-striped table-bordered ">
							<thead>
								<tr>
									<th scope="col" >#</th>
									<th scope="col">Name</th>             
									<th scope="col">Description</th> 
									<th scope="col">Image</th> 
									@if(Auth::user()->roles[0]->name =='admin') 
									<th scope="col">User</th> 
									<th scope="col" width="10%">Action</th>
									@endif
								</tr>
							</thead>
							<tbody>
								@if($boxes != '')
								<?php $i=1;?>
								@foreach($boxes  as $key=>$rows)
								<tr>
									<td>{{ $i++ }}</td>
									<td>{!! $rows->name!!}</td>   
									<td>{!! $rows->description !!}</td> 
									<td>@if($rows->img)
										<img src="{!!URL('/')!!}/assets/uploads/box/thumb/{{ $rows->img }}"  class="travel-img" width="50" height="50" /> 
										@else 
										<img src="{!!URL('/')!!}/assets/img/noimage.jpg" width="50" height="50"class="travel-img" /></td>
										@endif
									@if(Auth::user()->roles[0]->name =='admin') 
									<td>{!! ($rows->user) ? $rows->user->name:'' !!}</td> 
									
									<td>
										<div class="btn-group btn-group-xs">                                   
                                            @can('box-edit')
											<a class="btn btn-sm btn-primary" href="{{ route('edit-box',array('id'=>$rows->id)) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
											@endcan
											
                                          
										</div>
									</td>
									@endif
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
<div id="assigneBoxs" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog modal-md" role="document">
      <div class="text-center loading"> 
         <div class="spinner4">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
         </div>
      </div>
      <div class="modal-content" id="boxId"> </div>
   </div>
</div>
@endsection
@section('extrajs')

{!! Html::script('assets/plugins/select2/select2.full.min.js') !!}
{!! Html::script('assets/js/select2.js') !!}

<script type="text/javascript">
$(document).on("click", "#assigneBoxId", function () {
  $('#boxId').hide();
  $('.loading').show();
  var id = '';
  $.ajax({
    url: appurl+"admin/assigneBoxId",
    type: 'POST',
    data: "id="+id,  
    success:function(info){
      $('.loading').hide();
      $('#boxId').html(info);
      $('#boxId').show();
    }
  });
});

</script>
@endsection