<div class="profile-level-symbol">
	<img src="imgs/leaf.png" class="resp-img" />
</div>
<div class="profile-name-level-xp">
	<span ng-bind="profile.username" fittext="0.8"></span>
	<p>
		Seed Level: <span ng-bind="profile.level"></span>
	</p>
	<div class="profile-xp">
		<div class="container">
			<uib-progressbar value="profile.currentXP" max="profile.requiredXP"
				type="profile.xpBarTypes()" title="Esperienza"> <span
				ng-bind="profile.currentXP"></span>/<span ng-bind="profile.requiredXP"></span>
			</uib-progressbar>
		</div>
	</div>
</div>