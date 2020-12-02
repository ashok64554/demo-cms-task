@extends('layouts.master')
@section('extracss')
{!! Html::style('assets/js/bootstrap-fileupload/bootstrap-fileupload.css') !!}
@endsection
@section('content')

{{ Form::open(array('route' => 'app-setting-update', 'class'=> 'card','enctype'=>'multipart/form-data', 'files'=>true)) }}
@csrf
<input type="hidden" name="old_app_logo" value="{{ $appsetting->app_logo }}">
<input type="hidden" name="old_footer_logo" value="{{ $appsetting->footer_logo }}">
<input type="hidden" name="old_background_image" value="{{ $appsetting->background_image }}">
<div class="row row-deck">
	<div class="col-lg-4">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">App Setting</h3>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label for="app_name" class="form-label">App Name</label>
					{!! Form::text('app_name',$appsetting->app_name,array('id'=>'app_name','class'=> $errors->has('app_name') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'App Name', 'autocomplete'=>'off','required'=>'required')) !!}
					@if ($errors->has('app_name'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('app_name') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="email" class="form-label">Email</label>
					{!! Form::text('email',$appsetting->email,array('id'=>'email','class'=> $errors->has('email') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Email', 'autocomplete'=>'off','required'=>'required')) !!}
					@if ($errors->has('email'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="address" class="form-label">Address</label>
					{!! Form::text('address',$appsetting->address,array('id'=>'address','class'=> $errors->has('address') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Address', 'autocomplete'=>'off','required'=>'required')) !!}
					@if ($errors->has('address'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('address') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="mobilenum" class="form-label">Mobile / Contact Number</label>
					{!! Form::text('mobilenum',$appsetting->mobilenum,array('id'=>'mobilenum','class'=> $errors->has('mobilenum') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Mobile / Contact Number', 'autocomplete'=>'off','required'=>'required')) !!}
					@if ($errors->has('mobilenum'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('mobilenum') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="app_logo" class="form-label"> Logo</label>
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
							<img id="imageThumb" src="{{url('/')}}/{!! $appsetting->app_logo !!}"> 
						</div>
						<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
					</div>
					<div>
						<span class="btn btn-outline-primary btn-file">
							<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
							{!! Form::file('app_logo',array('id'=>'app_logo','data-icon'=>'false', 'accept'=>'image/*',  'onchange'=> 'readURL(this)')) !!}

						</span> 
					</div>
					@if ($errors->has('app_logo'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('app_logo') }}</strong>
					</span>
					@endif
				</div>
				



			</div>
		</div>
	</div>

	<div class="col-lg-8">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">SEO / Google Analytics</h3>
				<div class="card-options">
					<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a>
				</div>
			</div>
			<div class="card-body">
				<div class="row">

					
					<div class="col-lg-12">
						<div class="form-group">
							<label for="seo_keyword" class="form-label">SEO Keywords</label>
							{!! Form::textarea('seo_keyword',$appsetting->seo_keyword,array('id'=>'seo_keyword','class'=> $errors->has('seo_keyword') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'SEO Keywords', 'autocomplete'=>'off','required'=>'required', 'rows'=>'4')) !!}
							@if ($errors->has('seo_keyword'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('seo_keyword') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label for="seo_description" class="form-label">SEO Description</label>
							{!! Form::textarea('seo_description',$appsetting->seo_description,array('id'=>'seo_description','class'=> $errors->has('seo_description') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'SEO Description', 'autocomplete'=>'off','required'=>'required', 'rows'=>'4')) !!}
							@if ($errors->has('seo_description'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('seo_description') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label for="google_analytics" class="form-label">Google Analytics <pre>Without script tag</pre></label>
							{!! Form::textarea('google_analytics',$appsetting->google_analytics,array('id'=>'google_analytics','class'=> $errors->has('google_analytics') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Google Analytics', 'autocomplete'=>'off', 'rows'=>'4')) !!}
							@if ($errors->has('google_analytics'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('google_analytics') }}</strong>
							</span>
							@endif
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-footer text-right">
							{!! Form::submit('Update App Setting', array('class'=>'btn btn-primary')) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{ Form::close() }}
	@endsection
	@section('extracss')

	@endsection
