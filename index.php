<!DOCTYPE html>
<html ng-app = "myApp">
<head>
    <title>First Angularjs app</title>
    <style>
        body{
            background: none repeat scroll 0 0 #eee;
            color: #3e3333;
            font-family: fantasy;
            font-size: 25px;
            font-weight: 100;
            margin: 0 auto;
            width: 960px;

        }

        input,select{
            width: 100%;
            border: medium none;
            height: 30px;
            margin-top: 10px;
            padding-left: 5px;
            border-radius: 5px;
        }
       .serchField > li {
            display: inline-block;
            margin: 0 5px;
        }
        .error {
            color: red;
        }
        .searchDataList > ul > li {
            display: inline-block;
            width: 165px;
            padding: 0 5px;
        }
        .searchDataList img {
            width: 165px;
            height: 250px;
        }
        .details > p {
            font-size: 12px;
            font-weight: 400;
            margin: 0;
        }
        .searchDataList {
            margin-bottom: 50px;
            display: inline-block;
            width: 100%;
        }
        .img {
            float: left;
            height: 315px;
            width: 20%;
        }
        .details {
            height: 315px;
            float: left;
            width: 80%;
        }
        .details > p span:nth-child(2) {
            color: #878080;
            font-family: cursive;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>
</head>
<body>
    <div id="content" ng-controller="MainCtrl">
        <label>By Title</label>
        <ul class="serchField">
            <li>
                <span>id</span>
                <span><input type='text' ng-model='searchId' placeholder="movie Id" /></span>
            </li>
            <li>
                <span>Title</span>
                <span><input type='text' ng-model='searchText' placeholder="movie name" /></span>
            </li>
            <li>
                <span>Type</span>
                <span>
                    <select ng-model='type'>
                        <option value="movie">Movie</option>
                        <option value="xml">Series</option>
                        <option value="episode">Episode</option>
                    </select>
                </span>
            </li>
            <li>
                <span>Year</span>
                <span><input type='text' ng-model='year' placeholder="year" /></span>
            </li>
            <li>
                <span><button type="button" class="btn-sm btn-primary" ng-click="SearchByTitle()">Search</button></span>
                <span><button type="button" class="btn-sm btn-primary" ng-click="Reset()">Reset</button></span>
            </li>
        </ul>
        <p class="error" id='titleError'></p>
        <div class="searchDataList" ng-show="dataByTitle">
            <div class="img">
                <a ng-href="{{dataByTitle.Website}}" target="_blank"><img ng-src="{{dataByTitle.Poster}}"></a>
                <div ng-bind="dataByTitle.Title"></div>
            </div>
            <div class="details">
                <p><span>Actors: </span><span>{{dataByTitle.Actors}}</span></p>
                <p><span>Awards: </span><span>{{dataByTitle.Awards}}</span></p>
                <p><span>BoxOffice: </span><span>{{dataByTitle.BoxOffice}}</span></p>
                <p><span>Country: </span><span>{{dataByTitle.Country}}</span></p>
                <p><span>DVD: </span><span>{{dataByTitle.DVD}}</span></p>
                <p><span>Director: </span><span>{{dataByTitle.Director}}</span></p>
                <p><span>Genre: </span><span>{{dataByTitle.Genre}}</span></p>
                <p><span>Language: </span><span>{{dataByTitle.Language}}</span></p>
                <p><span>Metascore: </span><span>{{dataByTitle.Metascore}}</span></p>
                <p><span>Plot: </span><span>{{dataByTitle.Plot}}</span></p>
                <p><span>Production: </span><span>{{dataByTitle.Production}}</span></p>
                <p><span>Rated: </span><span>{{dataByTitle.Rated}}</span></p>
                <p><span>Released: </span><span>{{dataByTitle.Released}}</span></p>
                <p><span>Runtime: </span><span>{{dataByTitle.Runtime}}</span></p>
                <p><span>Title: </span><span>{{dataByTitle.Title}}</span></p>
                <p><span>Type: </span><span>{{dataByTitle.Type}}</span></p>
                <p><span>Writer: </span><span>{{dataByTitle.Writer}}</span></p>
                <p><span>Year: </span><span>{{dataByTitle.Year}}</span></p>
                <p><span>imdbID: </span><span>{{dataByTitle.imdbID}}</span></p>
                <p><span>imdbRating: </span><span>{{dataByTitle.imdbRating}}</span></p>
                <p><span>imdbVotes: </span><span>{{dataByTitle.imdbVotes}}</span></p>
            </div>
        </div>

        <div>
            <label>By ID or Title</label>
            <div class="searchDataList">
                <ul>
                    <li ng-repeat="movie in savedMovie">
                        <div>
                            <a ng-href="{{movie.Website}}" target="_blank"><img ng-src="{{movie.Poster}}"></a>
                            <div ng-bind="movie.Title"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</body>
<script>
    (function(){
        var app = angular.module('myApp' ,[]);
        app.controller("MainCtrl", function($scope, $http){
            var url = 'http://www.omdbapi.com/';
            var apikey = "93caff46";
            $scope.savedMovie = [];

            $scope.SearchByTitle = function(){
                var params = { apikey : apikey, r : 'json' };
                if($scope.searchText){ 
                    params.t = $scope.searchText; 
                }else if($scope.searchId){
                    params.i = $scope.searchId; 
                }
                if($scope.year){ params.y = $scope.year; }
                if($scope.type){ params.type = $scope.type; }
                if($scope.responce){ params.r = $scope.responce; }

                $http({
                    url: url, 
                    method: "GET",
                    params: params
                }).then(function(response) {
                    if(response.data.Response == 'True'){
                        $scope.dataByTitle = response.data;
                        $scope.savedMovie.unshift($scope.dataByTitle);
                        if($scope.savedMovie.length > 5){
                            $scope.savedMovie.pop();
                        }
                        angular.element(document.querySelector('#titleError')).html('');
                    }else{
                        angular.element(document.querySelector('#titleError')).html(response.data.Error);
                    }
                }, function(error){
                    angular.element(document.querySelector('#titleError')).html("Error: Daily request limit reached!");
                });
            }

            $scope.Reset = function(){
                $scope.searchText = '';
                $scope.searchId = '';
                $scope.year = '';
                $scope.type = null;
            }
        });
    })();
</script>
</html>