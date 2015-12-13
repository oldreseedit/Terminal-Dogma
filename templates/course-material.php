<div class="container text-center" ng-if="self.subscribed && course.materials.length == 0">
	<p>Questo corso non ha ancora materiale disponibile.</p>
</div>
<div class="container text-center" ng-if="!self.subscribed">
	<p>Iscriviti al corso per vedere il nostro materiale!</p>
</div>
<table class="table table-striped">
    <tr ng-repeat="material in course.materials">
        <td>
            <div class="container" id="material{{material.materialID}}" size-on-scope>
                <div class="material-title" id="material{{material.materialID}}Title" size-on-scope ng-style="course.getMargin(material{{material.materialID}}Height,material{{material.materialID}}TitleHeight)">
                    <div class="container" id="materialContainer">
                        <a ng-href="{{material.fileURI}}">
                            <span class="middler"></span>
                            <span class="middle fa fa-3x" ng-class="material.getFA()"></span>
                            <span class="middle" fittext="0.8" fittext-multiple="materialTitles" fittext-exclusive="width" fittext-reference="materialContainer" ng-bind="material.getTitle()"></span>
                        </a>
                    </div>
                </div>
                <div class="material-content" id="material{{material.materialID}}Content" size-on-scope ng-style="course.getMargin(material{{material.materialID}}Height,material{{material.materialID}}ContentHeight)">
                    <div class="container" ng-if="material.note">
                        <span ng-bind="material.note"></span>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>