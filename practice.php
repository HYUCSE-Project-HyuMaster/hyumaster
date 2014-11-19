<!DOCTYPE html>

<html ng-app='aloha'>

<head>
	<title>ALOHA Practice</title>
	<meta charset='utf-8'>
	<script src='/js/jquery-2.1.1.min.js'></script>
	<script src='/js/bootstrap.min.js'></script>
	<link href='/css/bootstrap.min.css' rel='stylesheet' media='screen'>
	<link href='/css/bootstrap-theme.min.css' rel='stylesheet' media='screen'>
	<script src='//ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js'></script>
	<script>
		var myApp = angular.module('aloha', []);
		myApp.controller('listController', function($scope) {
			$scope.currentView = 'list';

			$scope.changeView = function(viewName) {
				$scope.currentView = viewName;
			};

			$scope.eventList = [];

			$scope.newEventTitle="";
			$scope.newEventContent="";

			$scope.addEvent = function(title, content) {
				if(title=="")
				{
					alert("Please insert Title.");
					return false;
				}

				if(content=="")
				{
					alert("Please insert Content.");
					return false;
				}

				$scope.eventList.push({
					'title': title,
					'content': content
				});
			};
		});
	</script>
</head>

<body>
	
	<div class='container' ng-controller='listController'>
		<div class='page-header'>
			<h4>한양대학교 알로하 동아리 포트폴리오 제작 수업</h4>
		</div>

		<div class='btn-group'>
			<button class='btn btn-default' ng-click='changeView("list")'>
				<span class='glyphicon glyphicon-list'></span> 목록형
			</button>
			<button class='btn btn-default' ng-click='changeView("calendar")'>
				<span class='glyphicon glyphicon-calendar'></span> 달력형
			</button>
		</div>

		<button class='btn btn-primary' data-toggle="modal" data-target="#myModal">
			<span class='glyphicon glyphicon-plus'></span> 추가
		</button>

		<style>
			.content {
				margin-top : 25px;
			}
		</style>

		<div class='content'>
			<div ng-show='currentView == "list"'>
				<div class='row'>
					<div class='col-xs-4'>
						<div class="list-group">
							<a href="#" class="list-group-item" ng-repeat='(eventKey, eventRow) in eventList'>
								<h4 class="list-group-item-heading">{{eventRow.title}}</h4>
								<p class="list-group-item-text">{{eventRow.content}}</p>
							</a>

						</div>
					</div>

					<div class='col-xs-8'>
						test2
					</div>
				</div>
			</div>

			<div ng-show='currentView == "calendar"'>
				
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">일정 추가하기</h4>
					</div>

					<div class="modal-body">
						<div class='form-group'>
							<label>제목</label>
							<input type='text' class='form-control' ng-model='newEventTitle'>
						</div>

						<div class='form-group'>
							<label>내용</label>
							<input type='text' class='form-control' ng-model='newEventContent'>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-success" ng-click='addEvent(newEventTitle, newEventContent)'>Save changes</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</div>

</body>

</html>