@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Special Members</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissable" style="margin: 15px;">
                                    <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                                        aria-label="close">&times;</a>
                                    <strong> {{ session('success') }} </strong>
                                </div>
                            @endif

                            @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                                    <a href="#" style="color:white !important" class="close" data-dismiss="alert"
                                        aria-label="close">&times;</a>
                                    <strong> {{ session('error') }} </strong>
                                </div>
                            @endif
                            @foreach ($specialmembers as $members)
                                <form action="{{ url('/updatespecial') }}" enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" name="id" value="{{ $member->id }}" />
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="work_two_id">வாரியம் பெயர்</label>
                                                    <select class="form-control select2" name="work_two_id" id="work_two"
                                                        style="width: 100%;" required="required">
                                                        <option value=""> வாரியம் பெயர் தேர்ந்தெடு</option>
                                                        @foreach ($work_two as $work)
                                                            <option @if ($member->work_two_id == $work->id) selected @endif
                                                                value="{{ $work->id }}">{{ $work->work_two_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="work_there_id">தொழிலின் தன்மை</label>
                                                    <select class="form-control select2" name="work_there_id"
                                                        id="work_there_id" style="width: 100%;" required="required">
                                                        <option value=""></option>
                                                        @foreach ($work_there as $working)
                                                            <option @if ($member->work_there_id == $working->id) selected @endif
                                                                value="{{ $working->id }}">{{ $working->work_there_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="dist_id">மாவட்டத்தின் பெயர்</label>
                                                    <select class="form-control select2" name="dist_id" id="district"
                                                        style="width: 100%;" required="required">
                                                        <option value="">மாவட்டத்தின் பெயர்</option>
                                                        @foreach ($managedistrict as $district)
                                                            <option @if ($member->dist_id == $district->id) selected @endif
                                                                value="{{ $district->id }}">{{ $district->district_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="taluk_id">தாலுக்கா</label>
                                                    <select class="form-control select2" name="taluk_id" id="taluk_id"
                                                        style="width: 100%;" required="required">
                                                        @foreach ($managetaluk as $taluk)
                                                            <option @if ($member->taluk_id == $taluk->id) selected @endif
                                                                value="{{ $taluk->id }}">{{ $taluk->taluk_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="full_name">முழு பெயர்</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $member->full_name }}" name="full_name" id="full_name"
                                                        placeholder="முழு பெயர்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="permenent_door_no">கதவு எண்</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ $member->permanent_door_no }}" name="permanent_door_no"
                                                        placeholder="கதவு எண்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">தொலைபேசி எண்</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ $member->phone }}" name="phone" id="phone"
                                                        placeholder="தொலைபேசி எண்" onkeyup="checkphone(0)" maxlength="10">
                                                    <span id="dupphone" style="color:red"></span>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="add">ஆதார்</label>
                                                        <div class="input-group roe">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    name="aadhaarfile" autocomplete="off">
                                                                <label class="custom-file-label"
                                                                    for="exampleInputFile">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="registeration_date">பதிவு நாள்</label>
                                                        <input type="date" class="form-control"
                                                            value="{{ $member->registeration_date }}"
                                                            name="registeration_date" placeholder="பதிவு நாள்">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="father_or_husband_name">தந்தை / கனவர் பெயர்</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $member->father_or_husband_name }}"
                                                        name="father_or_husband_name" placeholder="தந்தை / கனவர் பெயர்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="street_no">தெருவின் பெயர்</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $member->street_name }}" name="street_name"
                                                        placeholder="தெருவின் பெயர்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="pincode">பின்கோடு</label>
                                                    <input type="text" onchange="validateSize(this)" maxlength="6"
                                                        class="form-control number" value="{{ $member->pincode }}"
                                                        name="pincode" placeholder="பின்கோடு">
                                                </div>
                                                <div class="form-group">
                                                    <label for="rationfile">குடும்ப அட்டை</label>
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="rationfile"
                                                            autocomplete="off">
                                                        <label class="custom-file-label" for="rationfile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="renew_date">புதுப்பித்தல்</label>
                                                    <input type="date" class="form-control"
                                                        value="{{ $member->registeration_date }}" name="renew_date"
                                                        placeholder="புதுப்பித்தல்">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="aadhaar_no">ஆதார் எண்</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $member->aadhaar_no }}" onkeyup="checkaadhar(0)"
                                                        maxlength="12" name="aadhaar_no" placeholder="ஆதார் எண்">
                                                    <span id="duplicateaadhar" style="color:red"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="post_name">அஞ்சல் பெயர்</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $member->post_name }}" name="post_name"
                                                        placeholder="அஞ்சல பெயர்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="signature2">கையொப்பம்</label>
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="signature2"
                                                            autocomplete="off">
                                                        <label class="custom-file-label" for="add">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nalavariyam_card">நலவாரியம் அட்டை</label>
                                                    <div class="input-group roe">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                name="nalavariyam_card" id="nalavariyamFile"
                                                                autocomplete="off" required="required">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dob">பிறந்த தேதி</label>
                                                    <input type="date" class="form-control"
                                                        value="{{ $member->dob }}" name="dob"
                                                        placeholder="பிறந்த தேதி">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="family_smart_card_no">குடும்ப அட்டை எண்</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ $member->family_smart_card_no }}"
                                                        name="family_smart_card_no" placeholder="குடும்ப அட்டை எண்">
                                                </div>
                                                <div class="form-group">
                                                    <label for="panchayath_id">
                                                        கிராம நிர்வக பகுதி</label>
                                                    <select class="form-control select2" name="panchayath_id"
                                                        id="panchayath_id" style="width: 100%;" required="required">
                                                        @foreach ($managepanchayath as $panchayath)
                                                            <option @if ($member->panchayath_id == $panchayath->id) selected @endif
                                                                value="{{ $panchayath->id }}">
                                                                {{ $panchayath->panchayath_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="member_photo">புகைப்படம்</label>
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="member_photo"
                                                            autocomplete="off">
                                                        <label class="custom-file-label" for="member_photo">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="registeration_no">பதிவு எண்</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ $member->registeration_no }}"
                                                        name="registeration_no" placeholder="பதிவு எண்">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 text-center">
                                            <a href="" class="btn btn-info">Back</a>
                                            <input id="save" class="btn btn-info" type="submit" name="submit"
                                                value="Submit" />
                                        </div>
                                    </div>
                                </form>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
