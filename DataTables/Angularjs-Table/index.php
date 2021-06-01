<!DOCTYPE html>
<html>
	<head>
		<script src="jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
		<script src="angular-datatables.min.js"></script>
		<script src="jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="bootstrap.min.css">
		<link rel="stylesheet" href="datatables.bootstrap.css">
	</head>
	<body>
		<div ng-app="customerApp" ng-controller="customerController" class="container">

			<br />
			<h3 align="center">Hello Parthibans</h3>
			<br />

			<table datatable="ng" dt-options="vm.dtOptions" class="table table-striped table-bordered" id="example">
				<thead>
					<tr>
						<th>SI.NO</th>
						<th>Customer Name</th>
						<th>Address</th>
						<th>City</th>
						<th>Postal Code</th>
						<th>Country</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="customer in customers  track by customer.CustomerName">
						<td>{{ $index + 1 }}</td>
						<td>{{ customer.CustomerName }}</td>
						<td>{{ customer.Address }}</td>
						<td>{{ customer.City }}</td>
						<td>{{ customer.PostalCode }}</td>
						<td>{{ customer.Country }}</td>
					</tr>
				</tbody>
			</table>
			<p class="lead" ><button id="json" class="btn btn-primary">TO JSON</button> <button id="csv" class="btn btn-info">TO CSV</button>  <button id="pdf" class="btn btn-danger">TO PDF</button></p>

			<br />
			<br />
		</div>
	</body>
</html>

<script>

var app = angular.module('customerApp', ['datatables']);
app.controller('customerController', function($scope, $http){
	$http.get('fetch.php').success(function(data, status, headers, config){
		$scope.customers = data;
	});
});

</script>
<script src="jquery-pdf-gen-lib/tableHTMLExport.js" ></script>
<script src="jquery-pdf-gen-lib/jspdf.min.js"></script>
<script src="jquery-pdf-gen-lib/jspdf.plugin.autotable.min.js"></script>
<script src="jquery-pdf-gen-lib/pdfmake.min.js"></script>
<script  src="jquery-pdf-gen-lib/html2canvas.min.js"></script>
<script src="src/tableHTMLExport.js"></script>
<script>
	$('#json').on('click',function(){
	  $("#example").tableHTMLExport({type:'json',filename:'sample.json'});
	})
	$('#csv').on('click',function(){
	  $("#example").tableHTMLExport({type:'csv',filename:'sample.csv'});
	})
	$('#pdf').on('click',function(){
	 // $("#example").tableHTMLExport({type:'pdf',filename:'sample.pdf'});
	 html2canvas($('#example')[0], {
	  onrendered: function (canvas) {
		  var data = canvas.toDataURL();
		  var docDefinition = {
			  content: [{
				  image: data,
				  width: 500
			  }]
		  };
		  pdfMake.createPdf(docDefinition).download("sample.pdf");
	  }
  });
  });
	</script>