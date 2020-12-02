{{ Form::open(array('url' => 'admin/save-assignebox', 'class'=> 'form-horizontal')) }}
{{ Form::token() }}
<div class="modal-header">
   <h5 class="modal-title">Assigne Box</h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
   </button>
</div>
<div class="card-body">
   <div class="row">
        <div class="col-md-12">
            <div class="form-group">
               <label class="form-control-label">Select Users <span class="requiredLabel">*</span></label>
               {!! Form::select('user_id',$allUsers,'', ['class' => 'form-control','id'=>'user_id', 'placeholder' => '--Select Users--']) !!}
            </div>
            <div class="form-group">
               <label class="form-control-label">Boxes  <span class="requiredLabel">*</span></label>
               {!! Form::select('box_id',$allBoxes,'', ['class' => 'form-control ','id'=>'box_id', 'placeholder' => '--Select Box --']) !!}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
   {!! Form::button('Assigne to User', array('class'=>'btn btn-primary pull-right','type'=>'submit')) !!}
   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
