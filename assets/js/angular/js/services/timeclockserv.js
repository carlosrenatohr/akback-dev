var base_url = "/akback/";
var api_url = "http://akback:1337/";

angular.module("akamaiposApp")
.factory("posData", ["$http", "$q", function posDataFactory($http, $q){
        return {
            GetHeaderInfo: function () {
                return $http({
                    method: 'POST',
                    url: base_url + 'backoffice/cashier/menu-header-info'
                })
            },
            DisplayTimeClock: function(){
                return $http({
                    method: 'GET',
                    url: base_url + 'backoffice/load-timeclock'
                })
            },
            TimeClockData: function(){
                return $http({
                    method: 'GET',
                    url: api_url + 'timeclock'
                })
            },
            TestData: function(){
                return $http({
                    method: 'GET',
                    url:  base_url + 'backoffice/load-timeclock-test'
                })
            },
            AddTimeClock: function(postdata){
                return $http({
                    method: 'POST',
                    data: postdata,
                    url:  api_url + 'time_clock',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                })
            },
            UpdateTimeClock: function(unique, postdata){
                return $http({
                    method: 'PUT',
                    data: postdata,
                    //url:  api_url + 'time_clock/update/'+unique,
                    url:  api_url + 'timeclock/update/'+unique,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                })
            },
            DeleteTimeClock: function(unique, postdata){
                return $http({
                    method: 'PUT',
                    data: postdata,
                    url:  api_url + 'time_clock/update/'+unique,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                })
            },
            TimeClockDateRange: function(fdate, tdate, locIn){
                return $http({
                    method: 'GET',
                    url: api_url + "timeclock-daterange/"+fdate+"/"+tdate+"/"+locIn,
                })
            },
			ExportData: function(postdata){
				return $http({
					method: 'POST',
                    data: postdata,
                    url:  base_url + "backoffice/timeclock/export",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				})
			}
        }
}]);