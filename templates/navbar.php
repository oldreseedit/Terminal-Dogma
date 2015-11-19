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
                    		<span class="noselect" fittext="0.9">
                    			<a class="clickable" ng-href="#!/profile/{{username}}">
		                            <span class="middler"></span>
		                            <span class="fa-stack" ng-if="navbar.getAvatar()">
		                            	<img class="navbar-avatar" ng-src="{{navbar.getAvatar()}}">
		                            </span>
		                            <span class="fa fa-user middle" ng-if="!navbar.getAvatar()"></span>
	                            	<span class="middle" ng-bind="username"></span>
	                            </a>
	                            <span class="navbar-icons">
	                        		<a ng-href="#!/profile/{{username}}"><span class="fa fa-user middle clickable"></span></a>
	                        		<a  ng-click="navbar.signout()"><span class="fa fa-sign-out middle clickable"></span></a>
	                            </span>
                        	</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>