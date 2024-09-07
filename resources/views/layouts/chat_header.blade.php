 <div class="internet-connection-status" id="internetStatus"></div>

  <!-- Header Area -->
  <div class="header-area" id="headerArea">
    <div class="container">
      <!-- Header Content -->
      <div class="header-content position-relative d-flex align-items-center justify-content-between">
        <!-- Chat User Info -->
        <div class="chat-user--info d-flex align-items-center">

          <div class="back-button">
            <a onclick="window.location.href='{{ url('/chatusers') }}'">
              <i class="bi bi-arrow-left-short"></i>
            </a>
          </div>

          <div class="user-thumbnail-name">
            <img src="{{ URL::to('/') }}/upload/user_photo/{{ $recv_photo }}" > 
            <div class="info ms-1">
              <p>{{ $recv_name }}</p>
              <!-- <span class="active-status">Active Now</span> --> 
            </div>
          </div>
        </div>

        <!-- Call & Video Wrapper -->
        <div class="call-video-wrapper d-flex align-items-center">
          <!-- Video Icon -->
          <div class="video-icon me-3">
            <!-- <a class="text-secondary" id="videoCallingButton" href="#">
              <i class="bi bi-camera-video"></i>
            </a> -->
          </div>

          <!-- Call Icon -->
          <div class="call-icon me-3">
            <!-- <a class="text-secondary" id="callingButton" href="#">
              <i class="bi bi-telephone"></i>
            </a> -->
          </div>

          <!-- Info Icon -->
          <div class="info-icon">
            <!-- <a class="text-secondary" href="#">
              <i class="bi bi-info-circle"></i>
            </a> -->
          </div>
        </div>
      </div>
    </div>
  </div>