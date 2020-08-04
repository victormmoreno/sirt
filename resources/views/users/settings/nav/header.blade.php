<div class="left">
    <div class="left">
        {!!$user->present()->userProfileUserImage()!!}
    </div>
    <div class="left">
        <span class="mailbox-title ">
            {{$user->present()->userFullName()}} 
        </span>
        <span class="mailbox-author">
            {{$user->present()->userRolesNames()}}
            <br/>
            Miembro desde {{$user->present()->userCreatedAtFormat()}}
            <br/>
            {{$user->present()->userYearOld()}} 
        </span>
    </div>
</div>