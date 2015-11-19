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
                        <span class="noselect" fittext="0.9" fittext-reference="navbar-logged">
                            <span class="middler"></span>
                            <span class="fa fa-user middle"></span>
                            <span class="middle" ng-bind="username"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>