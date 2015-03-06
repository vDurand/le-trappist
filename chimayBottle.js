var myApp = angular.module('myApp',[]);
 
myApp.controller('trappeBarrel', ['$scope','$http', '$filter', '$location', '$anchorScroll', function($scope,$http, $filter, $location, $anchorScroll) {

    // Lets get drunk
	$http.get("beer_keg.php")
	.success(function(response) {
            $scope.beers = response;
            console.log('got gulden draak!');

            // List all the drunkards
            $http.get("drunkard_list.php")
                .success(function(response) {$scope.drunkards = response;});

            // Get Type, Pays, Cdmt, Robe
            $http.get("beer_cdmt.php")
                .success(function(response) {$scope.beercdmt = response;});
            $http.get("beer_pays.php")
                .success(function(response) {$scope.beerpays = response;});
            $http.get("beer_type.php")
                .success(function(response) {$scope.beertype = response;});
            $http.get("beer_robe.php")
                .success(function(response) {$scope.beerrobe = response;});

            // Are we drunk?
            $scope.userLoggedIn = false;
            $http.get("session.php")
                .success(function(data) {
                    if (data.success) {
                        $scope.userLoggedIn = true;
                        $scope.userLogId = data.message;
                        $scope.listAllChecked();
                        console.log('yes session');
                    }
                    else{
                        console.log('no session');
                    }
                })
                .error(function (response){console.log('error session');});
        });

    // Lets sober up
    $scope.logout = function(){
        $http.get("logout.php")
            .success(function(response) {
                $scope.userLoggedIn = false;
                console.log('logged out');
                var index;
                for (index = 0; index < $scope.beers.length+1; ++index) {
                    $scope.beers[index].selected = "";
                }
                $scope.nbbrew = 0;
                $scope.ratebrew = 0;
                $scope.submitButtonLogin = "blue";
            })
            .error(function (response){console.log('error logout');});
    };

    // List all the dead bottles
    $scope.brew;
    $scope.nbbrew = 0;
    $scope.ratebrew = 0;
    $scope.listAllChecked = function(){
        $http.get("what_brew.php")
            .success(function(response) {
                $scope.brew = response;
                console.log('brew list ok');
                $scope.nbbrew = 0;
                $scope.ratebrew = 0;
                var index;
                var jndex;
                for (index = 0; index < $scope.beers.length; index++) {
                    if($scope.brew.indexOf($scope.beers[index].Id) != -1){
                        $scope.beers[index].selected = "green";
                        $scope.nbbrew++;
                        console.log('one added');
                    }
                }
                $scope.checksober();
            });
    };
    $scope.getrate = function(){
        $scope.ratebrew = Math.round($scope.nbbrew/$scope.beers.length*100);
    };

    // Select your poison of choice
	$scope.select = function(beer){
		if(beer.selected == "green"){
            $http({
                method  : 'POST',
                url     : 'uncheck_beverage.php',
                data: { 'Id' : beer.Id },  //param method from jQuery
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
            }).success(function(data){
                console.log(data.message);
                if (data.success) { //success comes from the return json object
                    beer.selected = "";
                    $scope.nbbrew--;
                    $scope.getrate();
                    $scope.checksober();
                    $('#conso').progress({percent: $scope.ratebrew});
                } else {

                }
            })
            .error(function (data){
                console.log('error1');
            });
		}
		else{
            $http({
                method  : 'POST',
                url     : 'check_beverage.php',
                data: { Id : beer.Id },  //param method from jQuery
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
            }).success(function(data){
                console.log(data.message);
                if (data.success) { //success comes from the return json object
                    beer.selected = "green";
                    $scope.nbbrew++;
                    $scope.checksober();
                } else {

                }
            })
                .error(function (data){
                    console.log('error2');
                });
		}
	};

    // Reorder from the barman
	var orderBy = $filter('orderBy');
	$scope.order = function(predicate, reverse) {
		$scope.beers = orderBy($scope.beers, predicate, reverse);
	};
    $scope.order('Nom',false);

    $scope.sober = "sobre";
    $scope.checksober = function(){
        if($scope.nbbrew < 2){$scope.sober = "sobre";}
        else if($scope.nbbrew < 5){$scope.sober = "euphorique";}
        else if($scope.nbbrew < 11){$scope.sober = "légèrement éméché";}
        else if($scope.nbbrew < 21){$scope.sober = "bien ivre";}
        else if($scope.nbbrew < 41){$scope.sober = "complètement saoul";}
        else if($scope.nbbrew < 61){$scope.sober = "ivre mort";}
        else if($scope.nbbrew < 75){$scope.sober = "en coma éthylique";}
        else if($scope.nbbrew == $scope.beers.length){$scope.sober = "mort";}
    };

	// Menu stuff
	$scope.carte = true;
	$scope.carteclass = "active item";
	$scope.newbeer = false;
	$scope.newbeerclass = "item";
	$scope.stat = false;
	$scope.statclass = "item";
	$scope.signup = false;
	$scope.gocarte = function(){
		$scope.carte = true;
		$scope.newbeer = false;
		$scope.stat = false;
		$scope.signup = false;
		$scope.carteclass = "active item";
		$scope.newbeerclass = "item";
		$scope.statclass = "item";
        $scope.signUpSuccess = false;
        $scope.loginSuccess = false;
        $scope.newbeerSuccess = false;
        $location.hash('caen');
        $anchorScroll();
	};
	$scope.gonewbeer = function(){
		$scope.carte = false;
		$scope.newbeer = true;
		$scope.stat = false;
		$scope.signup = false;
		$scope.carteclass = "item";
		$scope.newbeerclass = "active item";
		$scope.statclass = "item";
        $location.hash('caen');
        $anchorScroll();
	};
	$scope.gostat = function(){
		$scope.carte = false;
		$scope.newbeer = false;
		$scope.stat = true;
		$scope.signup = false;
		$scope.carteclass = "item";
		$scope.newbeerclass = "item";
		$scope.statclass = "active item";
        $scope.getrate();
        $location.hash('caen');
        $anchorScroll();
        $('#conso').progress({percent: $scope.ratebrew});
	};
	$scope.gosignup = function(){
		$scope.carte = false;
		$scope.newbeer = false;
		$scope.stat = false;
		$scope.signup = true;
		$scope.carteclass = "item";
		$scope.newbeerclass = "item";
		$scope.statclass = "active item";
        $location.hash('caen');
        $anchorScroll();
	};

    // Register a drunkard
    $scope.signupData;
    $scope.submitButtonSignup = "green basic";
    $scope.resultSignupMessage = "";
    $scope.signUpSuccess = false;
    $scope.submitSignup = function(signupform){
        if($scope.signupData.pseudo){
            if(signupform.$valid){
                if($scope.drunkards.indexOf($scope.signupData.pseudo) == -1){
                    $scope.submitButtonSignup = "basic loading";
                    $http({
                        method  : 'POST',
                        url     : 'user_signup.php',
                        data    : $.param($scope.signupData),  //param method from jQuery
                        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
                    }).success(function(data){
                        console.log(data.message);
                        if (data.success) { //success comes from the return json object
                            $scope.submitButtonSignup = "green";
                            $scope.resultSignupMessage = "";
                            $scope.result='msgsuccess';
                            $scope.drunkards.push($scope.signupData.pseudo);
                            $scope.signupData="";
                            $scope.signUpSuccess = true;
                            $scope.loginSuccess = false;
                            $scope.newbeerSuccess = false;
                            $scope.carte = true;
                            $scope.newbeer = false;
                            $scope.stat = false;
                            $scope.signup = false;
                            $scope.carteclass = "active item";
                            $scope.newbeerclass = "item";
                            $scope.statclass = "item";
                        } else {
                            $scope.submitButtonSignup = "red";
                            $scope.resultSignupMessage = data.message;
                            $scope.result='msgfail';
                        }
                    })
                    .error(function (data){
                        console.log('error');
                    });
                }
                else{
                    $scope.submitButtonSignup = "red";
                    $scope.resultSignupMessage = "Pseudo déjà pris, désolé.";
                    console.log("already in use");
                }
            }
            else{
                $scope.submitButtonSignup = "green basic";
            }
        }
    };

    // Login a drunkard
    $scope.loginData;
    $scope.submitButtonLogin = "blue";
    $scope.resultLoginMessage = "";
    $scope.loginSuccess = false;
    $scope.submitLogin = function(loginform){
        var tempseudo = $scope.loginData.pseudo;
        if($scope.loginData.pseudo){
            if(loginform.$valid){
                if($scope.drunkards.indexOf($scope.loginData.pseudo) != -1){
                    $scope.submitButtonLogin = "primary loading";
                    $http({
                        method  : 'POST',
                        url     : 'login.php',
                        data    : $.param($scope.loginData),  //param method from jQuery
                        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
                    }).success(function(data){
                        console.log(data.message);
                        if (data.success) { //success comes from the return json object
                            console.log("success");
                            $scope.submitButtonLogin = "blue";
                            $scope.resultLoginMessage = "";
                            $scope.result='msgsuccess';
                            $scope.loginData="";
                            $scope.loginSuccess = true;
                            $scope.signUpSuccess = false;
                            $scope.newbeerSuccess = false;
                            $scope.userLoggedIn = true;
                            $scope.listAllChecked();
                            $scope.userLogId = tempseudo;
                            $scope.carte = true;
                            $scope.newbeer = false;
                            $scope.stat = false;
                            $scope.signup = false;
                            $scope.carteclass = "active item";
                            $scope.newbeerclass = "item";
                            $scope.statclass = "item";
                        } else {
                            console.log("fail");
                            $scope.submitButtonLogin = "red";
                            $scope.resultLoginMessage = data.message;
                            $scope.result='msgfail';
                        }
                    })
                        .error(function (data){
                            console.log('error');
                        });
                }
                else{
                    $scope.submitButtonLogin = "red";
                    $scope.resultLoginMessage = "Pseudo inexistant.";
                    console.log("dont exist");
                }
            }
            else{
                $scope.submitButtonLogin = "blue";
            }
        }
    };

    // Add new beverage
    $scope.newbeerData;
    $scope.submitButtonNewbeer = "green basic";
    $scope.resultNewbeerMessage = "";
    $scope.newbeerSuccess = false;
    $scope.submitNewbeer = function(newbeerform){
        if($scope.newbeerData.nom && $scope.newbeerData.type && $scope.newbeerData.pays && $scope.newbeerData.alcool && $scope.newbeerData.robe && $scope.newbeerData.prix && $scope.newbeerData.cdmt){
            if(newbeerform.$valid){
                if($scope.beers.indexOf($scope.newbeerData.nom) == -1){
                    $scope.submitButtonNewbeer = "basic loading";
                    $http({
                        method  : 'POST',
                        url     : 'add_beer.php',
                        data    : $.param($scope.newbeerData),  //param method from jQuery
                        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
                    }).success(function(data){
                        console.log(data.message);
                        if (data.success) { //success comes from the return json object
                            $scope.submitButtonNewbeer = "green";
                            $scope.resultNewbeerMessage = "";
                            $scope.result='msgsuccess';
                            $scope.newbeerData="";
                            $scope.newbeerSuccess = true;
                            $scope.signUpSuccess = false;
                            $scope.loginSuccess = false;
                            $scope.carte = true;
                            $scope.newbeer = false;
                            $scope.stat = false;
                            $scope.signup = false;
                            $scope.carteclass = "active item";
                            $scope.newbeerclass = "item";
                            $scope.statclass = "item";
                            $http.get("beer_keg.php")
                                .success(function(response) {
                                    $scope.beers = response;
                                    console.log('relisted');
                                });
                        } else {
                            $scope.submitButtonNewbeer = "red";
                            $scope.resultNewbeerMessage = data.message;
                            $scope.result='msgfail';
                        }
                    })
                        .error(function (data){
                            console.log('error');
                        });
                }
                else{
                    $scope.submitButtonNewbeer = "red";
                    $scope.resultNewbeerMessage = "Pseudo déjà pris, désolé.";
                    console.log("already in use");
                }
            }
            else{
                $scope.submitButtonNewbeer = "green basic";
            }
        }
        else{console.log("not all good");}
    };
}]);