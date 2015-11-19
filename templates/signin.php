<div class="container">
    <div id="signinModal">
        <div class="container">
            <h2>Login</h2>
            <form id="signinForm" name="signinForm" ng-submit="signin.submit()" novalidate>
                <bootstrap-input form="signinForm" id="username" name="username" type="text" ng-model="signin.signinForm.username" placeholder="Username" ng-minlength="3" ng-maxlength="30" required="required"></bootstrap-input>
                <bootstrap-input form="signinForm" name="password" type="password" ng-model="signin.signinForm.password" placeholder="Password" ng-minlength="8" required="required"></bootstrap-input>
                <input id="signin-submit" type="submit" ng-class="{'btn-success' : signinForm.$valid, 'btn-grey' : signinForm.$invalid}" value="Accedi" />
                <input id="signin-cancel" ng-click="$dismiss()" value="Annulla" readonly/>
            </form>
        </div>
    </div>
</div>