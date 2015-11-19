<div class="profile-rewards">
    <div class="container">
        <h4>Rewards</h4>
        <table class="table table-striped">
            <tr><td class="bg-grey">Level</td><td class="bg-grey">Reward</td></tr>
            <tr ng-repeat="reward in user.rewards">
                <td ng-bind="reward.level">
                    
                </td>
                <td ng-bind="reward.content">
                    
                </td>
            </tr>
        </table>
    </div>
</div>