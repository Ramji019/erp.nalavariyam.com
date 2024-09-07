
<div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
        <!-- Footer Content -->
        <div class="footer-nav position-relative shadow-sm footer-style-two">
            <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                <li>
                    <a href="">
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a data-bs-toggle="offcanvas" href="#offcanvasBottom" role="button" aria-controls="offcanvasBottom">
                        <i class="bi bi-collection"></i>
                        <span>Category</span>
                    </a>
                </li>

                <li class="active">
                    @if (Auth::user() && Auth::user()->usertype_id == 3)
                    <a href="">
                        <span id="boot-icon" class="bi bi-plus"
                            style="font-size: 3rem; color: rgb(255, 255, 255);"></span>
                    </a>
                    @else
                    <a id="current_locationtop" data-bs-toggle="offcanvas" data-bs-target="#login"
                        aria-controls="offcanvasBottom">
                        <span id="boot-icon" class="bi bi-plus"
                            style="font-size: 3rem; color: rgb(255, 255, 255);"></span>

                    </a>
                    @endif
                    <div class="text-center">Sell</div>
                </li>

                @if(Auth::user())
                @if(isset($currentRouteName) && $currentRouteName == "product")
                <li>
                    <a href="{{ url('/chat') }}/{{ $prod->seller_id }}">
                        <i class="bi bi-chat-dots"></i>
                        <span>Chat</span>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ url('/chatusers') }}">
                        <i class="bi bi-chat-dots"></i>
                        <span>Chat</span>
                    </a>
                </li>
                @endif
                @else
                <li>
                    <a data-bs-toggle="offcanvas" data-bs-target="#login" aria-controls="offcanvasBottom">
                        <i class="bi bi-chat-dots"></i>
                        <span>Chat</span>
                    </a>
                </li>
                @endif

                <li>
                  
                        <a onclick="history.back()">
                            <i class="bi bi-arrow-left-short"></i>
                            <span>Back</span>
                        </a>
                </li>
            </ul>
        </div>
    </div>
</div>





