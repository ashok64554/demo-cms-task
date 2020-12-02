@extends('layouts.master')

@section('content')
@if(Auth::user()->roles[0]->name =='admin') 
<div class="row row-cards">
	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
		<div class="card card-counter bg-gradient-primary shadow-primary">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="mt-4 mb-0 text-white">
							<h3 class="mb-0">{{$getUsers}}</h3>
							<p class="text-white mt-1">Total Users </p>
						</div>
					</div>
					<div class="col-4">
						<i class="fa fa-bar-chart mt-3 mb-0"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
		<div class="card card-counter bg-gradient-secondary shadow-secondary">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="mt-4 mb-0 text-white">
							<h3 class="mb-0">2</h3>
							<p class="text-white mt-1">Total Active Users</p>
						</div>
					</div>
					<div class="col-4">
						<i class="fa fa-send-o mt-3 mb-0"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
		<div class="card card-counter bg-gradient-warning shadow-warning">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="mt-4 mb-0 text-white">
							<h3 class="mb-0">10</h3>
							<p class="text-white mt-1">Total Products</p>
						</div>
					</div>
					<div class="col-4">
						<i class="fa fa-envelope-o mt-3 mb-0"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row row-deck">
	
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Product List</h3>
			</div>
			{{ Form::open(array('route' => 'import-sheet', 'class'=> 'form-horizontal','enctype'=>'multipart/form-data', 'files'=>true)) }}
           		 @csrf
	            <div class="row div-margin">
	                <div class="col-md-2 col-sm-6 col-xs-6">
	                    <div class="input-group"> 
	                         
	                            {!! Form::text('post_spreadsheet_id','1sEwLVOdlL9X5AkBabaz8nS-YrVIdz_4lSUPlfudAohU',array('id'=>'post_spreadsheet_id','class'=>'form-control','placeholder'=>'spreadsheet id','required'=>'required')) !!}

	                       
	                    </div>
	                </div>
	                 <div class="col-md-2 col-sm-6 col-xs-6">
	                    <div class="input-group"> 
	                         
	                            {!! Form::text('post_spreadsheet_name','Datasheet',array('id'=>'post_spreadsheet_name','class'=>'form-control','placeholder'=>'spreadsheet name','required'=>'required')) !!}

	                       
	                    </div>
	                </div>
	                <div class="col-md-8 col-sm-6 col-xs-6">
	                    <div class="input-group">
	                        <button type="submit" class="btn btn-danger" name="submit" value="import">Import</button>
	                    </div>
	                </div>

	                 
	            </div>
            	{{ Form::close() }}
			<div class="card-body">
				<div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
               
                       
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($allProduct as $key => $rows)
                            <tr>
                                <td>{!! $key+1 !!}</td>
                                <td>{!! $rows->title !!}</td>
                                <td>{!! $rows->description !!}</td>
                                <td>{!! $rows->price !!}</td>
                                
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
	</div>
</div>
@endif
@endsection

