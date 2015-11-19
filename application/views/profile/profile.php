<div id="profile">
    <div class="container">
        <div gridster>
            <div class="gridster-item bg-light-grey" gridster-item="user.customItemMap" ng-repeat="item in user.items">
                <div class="container">
                    <perfect-scrollbar class="scrollbar-wrapper" suppressScrollX="true">
                        <div class="scrollbar">
                            <div ng-include="item.templateUrl" ng-if="item.ready()"></div>
                        </div>
                    </perfect-scrollbar>
                </div>
            </div>
        </div>
    </div>
</div>