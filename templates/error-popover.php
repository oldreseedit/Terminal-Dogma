<div id="error-popover" ng-show="form['{{name}}'].$invalid && form['{{name}}'].$dirty">
    <span class="fa-stack">
        <i class="fa fa-stack-2x fa-square" style="color: #f0ad4e"></i>
        <i class="fa fa-stack-1x white fa-exclamation"></i>
    </span>
    <span ng-messages="errors"><span ng-messages-include="templates/error-messages.php"></span></span>
</div>