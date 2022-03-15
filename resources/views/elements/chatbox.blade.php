<style>
    .chat {
        overflow: hidden;
        right: 20px;
        border-radius: 3px;
        padding: 25px;
        position: fixed;
        top: 63%;
        border: 1px solid #edf2f9;
        background: #fff;
         background: linear-gradient(to right bottom, rgba(255, 255, 255, 0.5),  rgb(227, 237, 255));
        /*background: rgb(227, 237, 255);*/
        backdrop-filter: blur(2rem);
        transition: .3s;
        box-shadow: 0 10px 25px -3px rgb(0 0 0 / 10%), 0 4px 6px -2px rgb(0 0 0 / 5%) !important;
    }
    .chat-icon {
        overflow: hidden;
        background: #ec6959;
        width: 60px;
        height: 60px;
        right: 20px;
        border-radius: 100%;
        position: fixed;
        top: 85%;
        box-shadow: 0 10px 35px -3px rgb(0 0 0 / 10%), 0 4px 6px -2px rgb(0 0 0 / 5%) !important;
    }
    .chat .icon {
        color: #ec6959;
        font-size: 30px;
        /* padding: 15px 0 0 25px; */
    }
    .chat-icon .icon {
        color: #fff;
        font-size: 25px;
        padding: 12px 0 0 18px;
    }

    .chat:hover {
        margin-top: -10px;
        transition: .3s;
        box-shadow: 0 10px 35px -3px rgb(0 0 0 / 10%), 0 4px 6px -2px rgb(0 0 0 / 5%) !important;
    }
    .notify-1 {
        position: absolute;
        margin: -4px 0 0 10px;
        background: #d5e5fa;
        border-radius: 100%;
        padding: 5px 10px;
        color: #2c7be5 !important;
        font-size: 10px;
    }
</style>
<div class="chat text-center" id="chat">
    <a href="#" class="mb-1 avatar avatar-sm avatar-online">
        @if(Auth::user()->photo)
            <img src="{{Auth::user()->photo}}" class="avatar-img rounded-circle" alt="{{Auth::user()->name}}">
            @else
            <div class="initials">
                <span>{{Str::limit(Auth::user()->name, 1, '')}}{{Str::limit(Auth::user()->surname, 1, '')}}</span>
            </div>
        @endif
    </a>
    <p class="px-1">
        <span class="icon">
            <small class="notify-1">{{$new_chat_count}}</small>
            <span class="icon"><i class="fe fe-bell"></i></span>
        </span>
        You have
        @if($new_chat_count > 1)
                {{$new_chat_count}} new unread messages
            @elseif($new_chat_count == 1)
            a new message
            @elseif($new_chat_count < 1)
            no message
        @endif
        <a href="{{route(config('chatify.routes.prefix'))}}" class="text-color" style="border-bottom: 1px dotted">Connect with friends</a>
    </p>
</div>
<a class="cursor" onclick="showChat()" id="hide-icon" style="display: none">
    <div class="chat-icon">
        <span class="icon"><i class="mdi mdi-forum"></i></span>
    </div>
</a>
<a class="cursor" onclick="hideChat()" id="show-icon">
    <div class="chat-icon">
        <span class="icon"><i class="mdi mdi-close"></i></span>
    </div>
</a>

<script>
    function showChat() {
        document.getElementById('chat').style.display = 'block';
        document.getElementById('hide-icon').style.display = 'none';
        document.getElementById('show-icon').style.display = 'block';
    }
    function hideChat() {
        document.getElementById('chat').style.display = 'none';
        document.getElementById('hide-icon').style.display = 'block';
        document.getElementById('show-icon').style.display = 'none';
    }
</script>
<script type="text/javascript">
    window.onload=function(){
      document.getElementById("notify_sound").play();
    }
</script>
