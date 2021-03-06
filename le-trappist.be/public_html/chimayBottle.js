var rateNote = 0;
$(window).load(function() {
    /*$('.ui.heart.rating.front')
        .rating('setting', 'clearable', true)
    ;
    $('.ui.heart.rating.front')
        .rating('setting', 'onRate', function(value) {
            rateNote = value;
        });*/
    $('.ui.dropdown')
        .dropdown()
    ;
    $('.message .close').on('click', function() {
        $(this).closest('.message').fadeOut();
    });
    $('.ui.form.signup')
        .form({
            pseudo: {
                identifier  : 'pseudo',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez un pseudo'
                    }
                ]
            },
            password: {
                identifier  : 'password',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez un mot de passe'
                    },
                    {
                        type   : 'length[6]',
                        prompt : 'Le mot de passe doit faire 6 caractères minimum'
                    }
                ]
            },
            mail: {
                identifier : 'mail',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez une adresse email'
                    },
                    {
                        type   : 'email',
                        prompt : 'L\'adresse email n\'est pas valide'
                    }
                ]
            },
            passwordtwo: {
                identifier : 'passwordtwo',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Confirmez le mot de passe'
                    },
                    {
                        type   : 'match[password]',
                        prompt : 'Les mots de passe ne correspondent pas'
                    }
                ]
            }
        })
    ;
    $('.ui.form.login')
        .form({
            pseudo: {
                identifier  : 'pseudo',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez un pseudo'
                    }
                ]
            },
            password: {
                identifier  : 'password',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez un mot de passe'
                    },
                    {
                        type   : 'length[6]',
                        prompt : 'Le mot de passe doit faire 6 caractères minimum'
                    }
                ]
            }
        })
    ;
    $('.ui.form.newbeer')
        .form({
            nom: {
                identifier  : 'nom',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez un nom de bière'
                    }
                ]
            },
            type: {
                identifier  : 'type',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez un type de bière'
                    }
                ]
            },
            pays: {
                identifier  : 'pays',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez un pays d\'origine'
                    }
                ]
            },
            alcool: {
                identifier  : 'alcool',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez un degré d\'alcool'
                    }
                ]
            },
            robe: {
                identifier  : 'robe',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez une robe'
                    }
                ]
            },
            prix: {
                identifier  : 'prix',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez un tarif'
                    }
                ]
            },
            cdmt: {
                identifier  : 'cdmt',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Entrez un type de bière'
                    }
                ]
            }
        })
    ;
});

var myApp = angular.module('myApp',['vcRecaptcha']);
 
myApp.controller('trappeBarrel', ['$scope','$http', '$filter', '$location', '$anchorScroll', 'vcRecaptchaService', function($scope,$http, $filter, $location, $anchorScroll, vcRecaptchaService) {
    $scope.response = null;
    $scope.widgetId = null;
    $scope.model = {
        key: '6LfeHgMTAAAAAGPfgnheFh9sG7z9__bKvNdOcshu'
    };
    $scope.setResponse = function (response) {
        console.info('Response available');
        $scope.response = response;
    };
    $scope.setWidgetId = function (widgetId) {
        console.info('Created widget ID: %s', widgetId);
        $scope.widgetId = widgetId;
    };

    // Lets get drunk
    $scope.users;
	$http.get("beer_keg.php")
	.success(function(response) {
            $scope.beers = response;
            console.log('got gulden draak!');
            $scope.getUsers();

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
                        $scope.setMenu();
                        $scope.gantt = data.message;
                        $scope.userLogId = data.dial;
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
                $scope.setMenu();
                console.log('logged out');
                var index;
                for (index = 0; index < $scope.beers.length; ++index) {
                    $scope.beers[index].selected = "";
                }
                $scope.nbbrew = 0;
                $scope.ratebrew = 0;
                $scope.submitButtonLogin = "blue";
                $scope.gantt = 0;
                $scope.gocarte();
            })
            .error(function (response){console.log('error logout');});
    };

    // List all the dead bottles
    $scope.brew = [0, 0];
    $scope.dataChecked;
    $scope.nbbrew = 0;
    $scope.ratebrew = 0;
    $scope.listAllChecked = function(){
        $http.get("what_brew.php")
            .success(function(response) {
                $scope.dataChecked = response;
                var index;
                for(index = 0; index < $scope.dataChecked.length; index++){
                    $scope.brew[index] = $scope.dataChecked[index].Id;
                }
                console.log('brew list ok');
                $scope.nbbrew = 0;
                $scope.ratebrew = 0;
                var index;
                var jndex;
                for (index = 0; index < $scope.beers.length; index++) {
                    $scope.beers[index].note = 0;
                    var kndex = $scope.brew.indexOf($scope.beers[index].Id)
                    if(kndex != -1){
                        $scope.beers[index].selected = "green";
                        $scope.beers[index].note = $scope.dataChecked[kndex].Note;
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
        else if($scope.nbbrew < 5*$scope.beers.length/100){$scope.sober = "euphorique";}
        else if($scope.nbbrew < 10*$scope.beers.length/100){$scope.sober = "légèrement éméché";}
        else if($scope.nbbrew < 30*$scope.beers.length/100){$scope.sober = "bien ivre";}
        else if($scope.nbbrew < 50*$scope.beers.length/100){$scope.sober = "complètement saoul";}
        else if($scope.nbbrew < 75*$scope.beers.length/100){$scope.sober = "ivre mort";}
        else if($scope.nbbrew < 100*$scope.beers.length/100){$scope.sober = "en coma éthylique";}
        else if($scope.nbbrew = $scope.beers.length){$scope.sober = "mort";}
    };

	// Menu stuff
	$scope.carte = true;
	$scope.carteclass = "active item";
	$scope.newbeer = false;
	$scope.newbeerclass = "item";
	$scope.stat = false;
	$scope.statclass = "item";
    $scope.community = false;
    $scope.communityclass = "item";
	$scope.signup = false;
	$scope.gocarte = function(){
		$scope.carte = true;
		$scope.newbeer = false;
		$scope.stat = false;
		$scope.signup = false;
        $scope.community = false;
		$scope.carteclass = "active item";
		$scope.newbeerclass = "item";
		$scope.statclass = "item";
        $scope.communityclass = "item";
        $scope.signUpSuccess = false;
        $scope.loginSuccess = false;
        $scope.newbeerSuccess = false;
        $location.hash('caen');
        $anchorScroll();
        $location.hash(null);
	};
	$scope.gonewbeer = function(){
		$scope.carte = false;
		$scope.newbeer = true;
		$scope.stat = false;
		$scope.signup = false;
        $scope.community = false;
		$scope.carteclass = "item";
		$scope.newbeerclass = "active item";
		$scope.statclass = "item";
        $scope.communityclass = "item";
        $location.hash('caen');
        $anchorScroll();
        $location.hash(null);
	};
	$scope.gostat = function(){
		$scope.carte = false;
		$scope.newbeer = false;
		$scope.stat = true;
		$scope.signup = false;
        $scope.community = false;
		$scope.carteclass = "item";
		$scope.newbeerclass = "item";
		$scope.statclass = "active item";
        $scope.communityclass = "item";
        $scope.getrate();
        $location.hash('caen');
        $anchorScroll();
        $('#conso').progress({percent: $scope.ratebrew});
        $location.hash(null);
        $('.ui.heart.rating.back')
            .rating('setting', 'clearable', true)
        ;
        $('.ui.heart.rating.back')
            .rating('setting', 'onRate', function(value) {
                rateNote = value;
            });
	};
	$scope.gosignup = function(){
		$scope.carte = false;
		$scope.newbeer = false;
		$scope.stat = false;
		$scope.signup = true;
        $scope.community = false;
		$scope.carteclass = "item";
		$scope.newbeerclass = "item";
		$scope.statclass = "active item";
        $scope.communityclass = "item";
        $location.hash('caen');
        $anchorScroll();
        $location.hash(null);
	};
    $scope.gocommunity = function(){
        $scope.getUsers();
        $scope.carte = false;
        $scope.newbeer = false;
        $scope.stat = false;
        $scope.signup = false;
        $scope.community = true;
        $scope.carteclass = "item";
        $scope.newbeerclass = "item";
        $scope.statclass = "item";
        $scope.communityclass = "caen item";
        $location.hash('caen');
        $anchorScroll();
        $location.hash(null);
    };

    // Register a drunkard
    $scope.signupData;
    $scope.submitButtonSignup = "green basic";
    $scope.resultSignupMessage = "";
    $scope.signUpSuccess = false;
    $scope.loading = false;
    $scope.submitSignup = function(signupform){
        if($scope.signupData.pseudo){
            if(signupform.$valid){
                if($scope.drunkards.indexOf($scope.signupData.pseudo) == -1){
                    console.log($scope.response);
                    $scope.signupData.grecaptcharesponse = $scope.response;
                    console.log($scope.signupData.grecaptcharesponse);
                    $scope.loading = true;
                    $http({
                        method  : 'POST',
                        url     : 'user_signup.php',
                        data    : $.param($scope.signupData),  //param method from jQuery
                        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
                    }).success(function(data){
                        console.log(data.message);
                        if (data.success) { //success comes from the return json object
                            $scope.loading = false;
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
                            $scope.loading = false;
                            $scope.submitButtonSignup = "red";
                            $scope.resultSignupMessage = data.message;
                            $scope.result='msgfail';
                            vcRecaptchaService.reload($scope.widgetId);
                        }
                    })
                    .error(function (data){
                        console.log('error');
                    });
                }
                else{
                    $scope.loading = false;
                    $scope.submitButtonSignup = "red";
                    $scope.resultSignupMessage = "Pseudo déjà pris, désolé.";
                    console.log("already in use");
                    vcRecaptchaService.reload($scope.widgetId);
                }
            }
            else{
                $scope.loading = false;
                $scope.submitButtonSignup = "green basic";
            }
        }
    };

    // Login a drunkard
    $scope.loginData;
    $scope.gantt = 0;
    $scope.submitButtonLogin = "blue";
    $scope.resultLoginMessage = "";
    $scope.loginSuccess = false;
    $scope.loading = false;
    $scope.submitLogin = function(loginform){
        var tempseudo = $scope.loginData.pseudo;
        if($scope.loginData.pseudo){
            if(loginform.$valid){
                if($scope.drunkards.indexOf($scope.loginData.pseudo) != -1){
                    $scope.loading = true;
                    $http({
                        method  : 'POST',
                        url     : 'login.php',
                        data    : $.param($scope.loginData),  //param method from jQuery
                        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
                    }).success(function(data){
                        console.log(data.message);
                        if (data.success) { //success comes from the return json object
                            console.log("success");
                            $scope.loading = false;
                            $scope.submitButtonLogin = "blue";
                            $scope.gantt = data.message;
                            $scope.resultLoginMessage = "";
                            $scope.result='msgsuccess';
                            $scope.loginData="";
                            $scope.loginSuccess = true;
                            $scope.signUpSuccess = false;
                            $scope.newbeerSuccess = false;
                            $scope.userLoggedIn = true;
                            $scope.setMenu();
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
                            $scope.loading = false;
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
                    $scope.loading = false;
                    $scope.submitButtonLogin = "red";
                    $scope.resultLoginMessage = "Pseudo inexistant.";
                    console.log("dont exist");
                }
            }
            else{
                $scope.loading = false;
                $scope.submitButtonLogin = "blue";
            }
        }
    };

    $scope.menuUser = {"text" : "Login", "icon": "sign in"};
    $scope.setMenu = function(){
        if($scope.userLoggedIn){
            $scope.menuUser.text = "Compte";
            $scope.menuUser.icon = "dashboard";
        }
        else{
            $scope.menuUser.text = "Login";
            $scope.menuUser.icon = "sign in";
        }
    };
    // Add new beverage
    $scope.newbeerData;
    $scope.submitButtonNewbeer = "green basic";
    $scope.resultNewbeerMessage = "";
    $scope.newbeerSuccess = false;
    $scope.loading = false;
    $scope.submitNewbeer = function(newbeerform){
        if($scope.newbeerData.nom && $scope.newbeerData.type && $scope.newbeerData.pays && $scope.newbeerData.alcool && $scope.newbeerData.robe && $scope.newbeerData.prix && $scope.newbeerData.cdmt){
            if(newbeerform.$valid){
                if($scope.beers.indexOf($scope.newbeerData.nom) == -1){
                    $scope.loading = true;
                    $http({
                        method  : 'POST',
                        url     : 'add_beer.php',
                        data    : $.param($scope.newbeerData),  //param method from jQuery
                        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
                    }).success(function(data){
                        console.log(data.message);
                        if (data.success) { //success comes from the return json object
                            $scope.loading = false;
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
                            $scope.loading = false;
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
                    $scope.loading = false;
                    $scope.submitButtonNewbeer = "red";
                    $scope.resultNewbeerMessage = "Pseudo déjà pris, désolé.";
                    console.log("already in use");
                }
            }
            else{
                $scope.loading = false;
                $scope.submitButtonNewbeer = "green basic";
            }
        }
        else{console.log("not all good");}
    };

    // Personnal beer rating
    $scope.rateabeer = function(beer){
        if(beer.Id){
            var dataRating = { "id" : beer.Id, "note" : rateNote};
            $http({
                method  : 'POST',
                url     : 'rate_beer.php',
                data    : $.param(dataRating),  //param method from jQuery
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  //set the headers so angular passing info as form data (not request payload)
            }).success(function(data){
                console.log(data.message);
                if (data.success) { //success comes from the return json object
                    console.log('success');
                    beer.note = rateNote;
                } else {
                    console.log('fail');
                }
            })
            .error(function (data){
                console.log('error');
            });
        }
    };

    // User list
    $scope.getUsers = function(){
        $http.get("user_list.php")
            .success(function(response) {$scope.users = response; console.log('suc');});
    };
}]);