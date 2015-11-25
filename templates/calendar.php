<div class="agendaButtons">
    <button class="btn btn-success" ng-click="changeView('agendaDay')">Vista Quotidiana</button>
    <button class="btn btn-success" ng-click="changeView('agendaWeek')">Vista Settimanale</button>
    <button class="btn btn-success" ng-click="changeView('month')">Vista Mensile</button>
</div>
<div ui-calendar="uiConfig.calendar" ng-model="eventSources" calendar="register"></div>