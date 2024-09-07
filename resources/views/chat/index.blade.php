@extends('layouts.use_other_app')
@section('content')
  <div class="page-content-wrapper py-3">

    <div class="container">

  <!-- Element Heading 
      <div class="element-heading">
        <h6 class="ps-1">Recent contacts</h6>
      </div>
-->
      <!-- Chat User List -->
      <ul class="ps-0 chat-user-list ">
@foreach ($upline as $up)        <!-- Single Chat User -->
        <li class="p-3 chat-unread">
          <a class="d-flex" href="{{ url('/chat', $up->id ) }}">
            <!-- Thumbnail -->
            <div class="chat-user-thumbnail me-3 shadow">
              <img class="img-circle" src="{{ URL::to('/') }}/upload/user_photo/{{ $up->user_photo }}" alt="">
              <span class="active-status"></span>
            </div>
            <!-- Info -->
            <div class="chat-user-info">
              <h6 class="text-truncate mb-0">{{ $up->full_name }} <i class="bi bi-arrow-up-square-fill"></i></h6>
              @if($up->msgcount > 0)
              <span class="badge rounded-pill bg-primary float-end">{{ $up->msgcount }}</span>  
              @endif
              <div class="last-chat">
                <p class="mb-0 text-truncate">{{ $up->phone }}
               
                </p>
              </div>
            </div>
          </a>
        </li>
@endforeach
		</ul>
    <ul class="ps-0 chat-user-list">
      @foreach ($downline as $down)    
       <!-- Single Chat User -->
              <li class="p-3 chat-unread">
                <a class="d-flex" href="{{ url('/chat', $down->id ) }}">
                  <!-- Thumbnail -->
                  <div class="chat-user-thumbnail me-3 shadow">
                    <img class="img-circle" src="{{ URL::to('/') }}/upload/user_photo/{{ $down->user_photo }}" alt="">
                    <span class="active-status"></span>
                  </div>
                  <!-- Info -->
                  <div class="chat-user-info">
                    <h6 class="text-truncate mb-0">{{ $down->full_name }} <i class="bi bi-arrow-down-square-fill"></i></h6>
                    @if($down->msgcount > 0)
                    <span class="badge rounded-pill bg-primary float-end">{{ $down->msgcount }}</span> 
                    @endif
                    <div class="last-chat">
                      <p class="mb-0 text-truncate">{{ $down->phone }}
                      
                      </p>
                    </div>
                  </div>
                </a>
              </li>
      @endforeach
          </ul>
@endsection
