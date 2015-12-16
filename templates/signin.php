<div class="container">
    <div class="modal-wrapper">
        <div class="container">
            <h2>Login</h2>
            <form id="signinForm" name="signinForm" ng-submit="signin.submit()" novalidate>
                <bootstrap-input form="signinForm" id="username" name="username" type="text" ng-model="signin.signinForm.username" placeholder="Username" ng-minlength="3" ng-maxlength="30" required="required"></bootstrap-input>
                <bootstrap-input form="signinForm" name="password" type="password" ng-model="signin.signinForm.password" placeholder="Password" ng-minlength="8" required="required"></bootstrap-input>
                <input class="modal-submit btn-success" type="submit" value="Accedi" />
                <input class="modal-cancel" ng-click="$dismiss()" value="Annulla" readonly/>
            </form>
        </div>
    </div>
</div>