<div id="navbar" ng-controller="navbarController as navbar">
    <div class="container">
        <div id="navbar-home">
            <div class="container">
                <div class="macrotab">
                    <a href="#!/"><span class="middler"></span><span class="fa fa-home middle"></span><span class="middle">Home</span></a>
                </div>
            </div>
        </div>
        
        <div id="navbar-tabs">
            <div class="container">
                <div class="macrotab" ng-repeat="tab in navbar.tabs" ng-class="navbar.spaced($first)">
                    <a ng-href="#!/{{tab.url}}"><span class="middler"></span><span class="middle" ng-bind="tab.content"></span></a>
                </div> 
            </div>
        </div>
        
        <div id="navbar-profile">
            <div class="container macrotab">
                <div id="navbar-signup" ng-if="!userVerified">
                    <div class="container">
                        <button class="btn btn-success btn-sm" ng-click="navbar.signup()">
                            <span>Registrati</span>
                        </button>
                    </div>
                </div>
                <div id="navbar-signin" ng-if="!userVerified">
                    <div class="container">
                        <button class="btn btn-success btn-sm" ng-click="navbar.signin()">
                            <span>Accedi</span>
                        </button>
                    </div>
                </div>
                
                <!-- If logged -->
                <div id="navbar-logged" ng-if="userVerified">
                    <div class="container">
                    	<div class="navbar-profile-name">
                    		<span class="noselect" fittext="0.9" ng-controller="avatarController as avatar">
	                            <span class="middler"></span>
                    			<a class="clickable" ng-href="#!/profile/{{username}}" ng-if="avatar.getAvatar()">
		                            <span class="fa-stack" >
		                            	<img class="navbar-avatar" ng-src="{{avatar.getAvatar()}}">
		                            </span>
	                            </a>
	                            <a  ng-mouseenter="hover = true" ng-mouseleave="hover = false" ng-click="avatar.changeAvatar()" ng-if="!avatar.getAvatar()">
	                            	<span class="fa-stack fa-sm clickable">
	                            		<i class="fa fa-question-circle fa-stack-2x" ng-class="{'light-olive':hover, 'white':!hover}"></i>
	                            	</span>
		                         </a>
		                         
		                         <a ng-href="#!/profile/{{username}}">
	                            	<span class="middle navbar-username" ng-bind="username"></span>
	                            </a>
	                            
	                            <span class="navbar-icons">
									<a ng-href="#!/profile/{{username}}">
										<span class="fa-stack clickable" >
	                            			<i class="fa fa-sticky-note-o fa-stack-2x"></i>
                            				<i class="fa-stack-1x number-of-notifications" ng-if="numberOfNotifications!==0"><span ng-bind="numberOfNotifications"  fittext="2"></span></i>
	                            		</span>
	                          		</a>
	                        		<a  ng-click="navbar.signout()">
	                        			<span class="fa-stack clickable">
	                        				<i class="fa fa-sign-out fa-stack-2x"></i>
	                        			</span>
	                        		</a>
	                            </span>
                        	</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>