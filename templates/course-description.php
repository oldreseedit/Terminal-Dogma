<div class="container">
    <div class="course-description-introduction">
        <div class="container">
            <div class="course-description">
            	<uib-carousel interval="10000">
            		<uib-slide>
            			<img src="imgs/carousel/provaCarousel.png"/>
            		</uib-slide>
            		<uib-slide>
            			<img src="imgs/header.png"/>
            		</uib-slide>
            		<uib-slide>
            			<img src="imgs/footer.jpg" />
            		</uib-slide>
            		<uib-slide>
            			<img src="imgs/mini-header.png" />
            		</uib-slide>
            	</uib-carousel>
                <p><span ng-bind-html="course.courseInfo.description"></span></p>
            </div>
        </div>
    </div>
</div>