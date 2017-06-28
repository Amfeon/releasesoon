@if($RatingInfo->rating==0)
    <div class="title">Фильм пока, вообще никто не ждет, А ты?</div>
@else
<div class="title">Фильм ждет: {{@round($RatingInfo->rating*100)}}%<span class="qwestion">, А ты?</span></div>
@endif
<div class="vote">
    <div id="negativ" class="rating_bottom">пофиг</div>
    <div class="progress">
        <div class="progress-bar"  style="width:{{@round($RatingInfo->rating*100)}}%;height: 100%" >{{@round($RatingInfo->rating*100)}}%</div>
    </div>
    <div id="positiv" class="rating_bottom">жду</div>
</div>
<div class="social">
    <script type='text/javascript' src='//yastatic.net/es5-shims/0.0.2/es5-shims.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='//yastatic.net/share2/share.js' charset='utf-8'></script>
    <div class='ya-share2' data-services='vkontakte,facebook,odnoklassniki,moimir,twitter,viber,whatsapp'></div>
</div>


