@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Register as a Donor</div>

          <div class="panel-body">
            <form class="form-horizontal" action="{{Route('donor.store')}}" method="POST">

              {{ csrf_field() }}

              <div class="form-group {{ $errors->has('name') ? 'has-name' : '' }}">
                <label for="name" class="col-md-4 control-label">Donor Name</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required autofocus>
                  @if ($errors->has('name'))
                  <span class="help-block">
                  <strong>{{ $errors->first('name')}}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group {{ $errors->has('dob') ? 'has-dob' : '' }}">
                <label for="dob" class="col-md-4 control-label">Date of Birth</label>
                <div class="col-md-6">
                  <input type="date" class="form-control" name="dob" id="dob" value="{{ old('dob') }}" required>
                  @if ($errors->has('dob'))
                  <span class="help-block">
                  <strong>{{ $errors->first('dob')}}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                  <label for="address" class="col-md-4 control-label">Address</label>
                  <div class="col-md-6">
                      <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required>
                      @if ($errors->has('address'))
                          <span class="help-block">
                              <strong>{{ $errors->first('address') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group {{ $errors->has('contact_no') ? 'has-error' : '' }}">
                  <label for="contact_no" class="col-md-4 control-label">Contact Number</label>

                  <div class="col-md-6">
                      <input id="contact_no" type="text" class="form-control" name="contact_no" value="{{ old('contact_no') }}" required>

                      @if ($errors->has('contact_no'))
                          <span class="help-block">
                              <strong>{{ $errors->first('contact_no') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group {{ $errors->has('blood_type') ? 'has-blood_type' : '' }}">
                  <label for="blood-type" class="col-md-4 control-label">Blood Type</label>
                  <div class="col-md-6">
                      <input id="blood_type" type="text" class="form-control" name="blood_type" value="{{ old('blood_type') }}" required>
                      @if ($errors->has('blood_type'))
                          <span class="help-block">
                              <strong>{{ $errors->first('blood_type') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group {{ $errors->has('health_issues') ? 'has-health_issues' : '' }}">
                  <label for="health_issues" class="col-md-4 control-label">Health Issues</label>
                  <div class="col-md-6">
                      <textarea id="health_issues" class="form-control" name="health_issues" value="{{ old('health_issues') }}" fixed></textarea>
                      @if ($errors->has('health_issues'))
                          <span class="help-block">
                              <strong>{{ $errors->first('health_issues') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-md-8 col-md-offset-4">
                      <input type="submit" class="btn btn-primary" value="Submit">
                  </div>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
