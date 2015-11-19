<table class="table table-striped">
    <tr ng-repeat="material in course.materials">
        <td>
            <div class="container" id="material{{material.materialID}}" size-on-scope>
                <div class="material-title" ng-style="{'height':material{{material.materialID}}Height + 'px'}">
                    <div class="container" id="materialContainer">
                        <a ng-href="{{material.fileURI}}">
                            <span class="middler"></span>
                            <span class="middle fa fa-3x" ng-class="material.getFA()"></span>
                            <span class="middle" fittext="0.8" fittext-multiple="materialTitles" fittext-exclusive="width" fittext-reference="materialContainer" ng-bind="material.getTitle()"></span>
                        </a>
                    </div>
                </div>
                <div class="material-content" ng-style="{'height':material{{material.materialID}}Height + 'px'}">
                    <div class="container" ng-if="material.note">
                        <span ng-bind="material.note"></span>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>