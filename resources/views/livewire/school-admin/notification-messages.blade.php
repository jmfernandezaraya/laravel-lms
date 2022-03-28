<li class="nav-item dropdown {{$show}}" {{$count->where('seen', 0)->count() > 0 ?  "wire:click=updateMessageSeen" : ''}}>



    <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown"
       {{$aria_hidden}}>

        <i class="mdi mdi-email-outline"></i>


    @if($count->where('seen', 0)->count() > 0)
        <span class="count-symbol bg-warning"></span>
        @endif

    </a>

    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list {{$show}}" aria-labelledby="messageDropdown">

        <h6 class="p-3 mb-0">Messages</h6>

        @foreach($messages as $message )

        <div class="dropdown-divider"></div>

        <a class="dropdown-item preview-item" href="{{route('schooladmin.manage_application.view_message', $message->id)}}">

            <div class="preview-thumbnail">

                <img src="//img.favpng.com/9/3/19/conversation-message-online-chat-computer-icons-image-png-favpng-SqARma0cN1a08EsEKipnk57Zn.jpg" alt="image" class="profile-pic">

            </div>

            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">

                <h6 class="preview-subject ellipsis mb-1 font-weight-normal">{{$message->subject}}</h6>

                <p class="text-gray mb-0"> {{$message->created_at->diffForHumans()}} Minutes ago </p>

            </div>

        </a>

        <div class="dropdown-divider"></div>
    @endforeach


        <h6 class="p-3 mb-0 text-center">{{$count->count()}} new messages</h6>

    </div>

</li>
