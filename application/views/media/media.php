<div id="media" ng-controller="mediaController as media">
    <div class="container">
        <h3>Media</h3>
        <div class="media-tab" ng-repeat="tab in media.tabs" ng-class="[media.spaced($first), {'selected':tab.selected}]" ng-click="media.select($index);">
            <h5 class="clickable noselect" ng-bind="tab.name"></h5>
        </div>
        <div class="media-panel">
            <div class="container">
                <div class="media-panel-title">
                    <h6>Porte aperte a reSeed</h6>
                </div>
                <div class="media-panel-main">
                    <div class="container">
                        <div class="media-content" id="lolloSpiega" size-on-controller>
                            <div class="embed-responsive embed-responsive-16by9">
                                <youtube-video class="embed-responsive-item" video-id="media.videoID" player-vars="media.playerVars" player-width="'100%'"></youtube-video>
                            </div>
                        </div>
                        <div class="media-navbar" ng-style="media.getHeight()">
                            <perfect-scrollbar class="media-navbar-scrollbar" ng-if="media.heightReady">
                                <div class="media-navbar-right-content">
                                    <div class="container">
                                        Ooh<br><br>We're no strangers to love<br>You know the rules and so do I<br>A full commitment's what I'm thinking of<br>You wouldn't get this from any other guy<br><br>I just wanna tell you how I'm feeling<br>Gotta make you understand<br><br>Never gonna give you up<br>Never gonna let you down<br>Never gonna run around and desert you<br>Never gonna make you cry<br>Never gonna say goodbye<br>Never gonna tell a lie and hurt you<br><br>We've known each other for so long<br>Your heart's been aching, but you're too shy to say it<br>Inside, we both know what's been going on<br>We know the game and we're gonna play it<br><br>And if you ask me how I'm feeling<br>Don't tell me you're too blind to see<br><br>Never gonna give you up<br>Never gonna let you down<br>Never gonna run around and desert you<br>Never gonna make you cry<br>Never gonna say goodbye<br>Never gonna tell a lie and hurt you<br><br>Never gonna give you up<br>Never gonna let you down<br>Never gonna run around and desert you<br>Never gonna make you cry<br>Never gonna say goodbye<br>Never gonna tell a lie and hurt you<br><br><i>(Ooh, give you up)<br>(Ooh, give you up)</i><br>Never gonna give, never gonna give<br><i>(Give you up)</i><br>Never gonna give, never gonna give<br><i>(Give you up)</i><br><br>We've known each other for so long<br>Your heart's been aching, but you're too shy to say it<br>Inside, we both know what's been going on<br>We know the game and we're gonna play it<br><br>I just wanna tell you how I'm feeling<br>Gotta make you understand<br><br>Never gonna give you up<br>Never gonna let you down<br>Never gonna run around and desert you<br>Never gonna make you cry<br>Never gonna say goodbye<br>Never gonna tell a lie and hurt you<br><br>Never gonna give you up<br>Never gonna let you down<br>Never gonna run around and desert you<br>Never gonna make you cry<br>Never gonna say goodbye<br>Never gonna tell a lie and hurt you<br><br>Never gonna give you up<br>Never gonna let you down<br>Never gonna run around and desert you<br>Never gonna make you cry<br>Never gonna say goodbye<br>Never gonna tell a lie and hurt you
                                    </div>
                                </div>
                            </perfect-scrollbar>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>