<div class="profile-level-symbol">
	<img src="imgs/leaf.png" class="resp-img" />
</div>
<div class="profile-name-level-xp">
	<span ng-bind="user.username" fittext="0.8"></span>
	<p>
		Seed Level: <span ng-bind="user.level"></span>
	</p>
	<div class="profile-xp">
		<div class="container">
			<uib-progressbar value="user.currentXP" max="user.requiredXP"
				type="user.xpBarTypes()" title="Esperienza"> <span
				ng-bind="user.currentXP"></span>/<span ng-bind="user.requiredXP"></span>
			</uib-progressbar>
		</div>
	</div>
</div>