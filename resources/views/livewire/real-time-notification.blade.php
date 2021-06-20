<div  wire:poll>
<div class="main-notification-list Notification-scroll" id="display_notifi" >
    @foreach( auth()->user()->unreadNotifications as $notification)

     <a class="d-flex p-3 border-bottom" href="/showInvoices/{{ $notification->data['id']}}">
        <div class="notifyimg bg-pink">
            <i class="la la-file-alt text-white"></i>
        </div>
        <div class="mr-3">
            <h5 class="notification-label mb-1">{{ $notification->data['title'] }} </h5>
            <h5 class="notification-label mb-1"> بواسطة : {{ $notification->data['user'] }}</h5>
            <div class="notification-subtext">{{ $notification->data['date'] }}  </div>
        </div>
        <div class="mr-auto" >
            <i class="las la-angle-left text-left text-muted"></i>
        </div>
      </a>


     @endforeach

    {{--	<a class="d-flex p-3" href="#">
        <div class="notifyimg bg-purple">
            <i class="la la-gem text-white"></i>
        </div>
        <div class="mr-3">
            <h5 class="notification-label mb-1">Updates Available</h5>
            <div class="notification-subtext">2 days ago</div>
        </div>
        <div class="mr-auto" >
            <i class="las la-angle-left text-left text-muted"></i>
        </div>
    </a>
    <a class="d-flex p-3 border-bottom" href="#">
        <div class="notifyimg bg-success">
            <i class="la la-shopping-basket text-white"></i>
        </div>
        <div class="mr-3">
            <h5 class="notification-label mb-1">New Order Received</h5>
            <div class="notification-subtext">1 hour ago</div>
        </div>
        <div class="mr-auto" >
            <i class="las la-angle-left text-left text-muted"></i>
        </div>
    </a>
    <a class="d-flex p-3 border-bottom" href="#">
        <div class="notifyimg bg-warning">
            <i class="la la-envelope-open text-white"></i>
        </div>
        <div class="mr-3">
            <h5 class="notification-label mb-1">New review received</h5>
            <div class="notification-subtext">1 day ago</div>
        </div>
        <div class="mr-auto" >
            <i class="las la-angle-left text-left text-muted"></i>
        </div>
    </a>
    <a class="d-flex p-3 border-bottom" href="#">
        <div class="notifyimg bg-danger">
            <i class="la la-user-check text-white"></i>
        </div>
        <div class="mr-3">
            <h5 class="notification-label mb-1">22 verified registrations</h5>
            <div class="notification-subtext">2 hour ago</div>
        </div>
        <div class="mr-auto" >
            <i class="las la-angle-left text-left text-muted"></i>
        </div>
    </a>
    <a class="d-flex p-3 border-bottom" href="#">
        <div class="notifyimg bg-primary">
            <i class="la la-check-circle text-white"></i>
        </div>
        <div class="mr-3">
            <h5 class="notification-label mb-1">Project has been approved</h5>
            <div class="notification-subtext">4 hour ago</div>
        </div>
        <div class="mr-auto" >
            <i class="las la-angle-left text-left text-muted"></i>
        </div>
    </a> --}}
</div>
</div>
