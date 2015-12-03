<form name="xpAddForm" id="xpAddForm" ng-submit="admin.addXP()" ng-init="admin.getUsers()" novalidate>
    <select class="form-control" name="xpAddForm" ng-if="admin.users" ng-model="admin.xpAddForm.username" ng-options="user.userID as (user.name + ' ' + user.surname) for user in admin.users">
    	<option></option>
    </select>
    <input form="xpAddForm" id="xp" name="xp" type="number" step="50" ng-model="admin.xpAddForm.exp" placeholder="0" />
    <input class="btn btn-success form-group" type="submit" value="Aggiungi XP"/>
</form>