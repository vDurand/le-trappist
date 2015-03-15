<!DOCTYPE html>
<html id="caen">
<head>
    <script src="pace.min.js"></script>
    <title>Le Trappist</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="favicon.png" rel="shortcut icon"/>
    <link rel="stylesheet" type="text/css" href="semantic.min.css">
    <link rel="stylesheet" type="text/css" href="docs.css">
    <script src="jquery.min.js"></script>
    <script src="semantic.min.js"></script>
    <script type="text/javascript" src="angular.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js?render=explicit&onload=vcRecaptchaApiLoaded' async defer></script>
    <script type="text/javascript" src="angular-recaptcha.min.js"></script>
    <script type="text/javascript" src="chimayBottle.js"></script>
</head>
<body>
<div class="fullheight" id="scrollArea" data-ng-app="myApp" data-ng-controller="trappeBarrel">

<!-- MENU -->
    <div class="ui left vertical inverted labeled icon sidebar menu visible">
        <a ng-class="carteclass" data-ng-click="gocarte()">
            <i class="book icon"></i>
            Carte
        </a>
        <a ng-class="newbeerclass" data-ng-click="gonewbeer()" data-ng-show="gantt==1">
            <i class="plus icon"></i>
            Ajouter
        </a>
        <a ng-class="communityclass" data-ng-click="gocommunity()" data-ng-show="userLoggedIn">
            <i class="users icon"></i>
            Buveurs
        </a>
        <a ng-class="statclass" data-ng-click="gostat()">
            <i class="{{menuUser.icon}} icon"></i>
            {{menuUser.text}}
        </a>
        <a class="item" data-ng-click="logout()" data-ng-show="userLoggedIn">
            <i class="sign out icon"></i>
            Logout
        </a>
    </div>

<!-- LOG MSG -->
    <div class="currentstate" data-ng-show="userLoggedIn">
        <div class="ui icon message">
            <i class="trophy icon" onclick="javascript:rain()"></i>
            <div class="content">
                <div class="header">
                    Bienvenue {{userLogId}}!
                </div>
                <p>Vous êtes {{sober}}.<br>Vous avez bu <b>{{nbbrew}}</b> bières.</p>
            </div>
        </div>
    </div>

<!-- LOGO -->
    <div id="logo" data-ng-click="gocarte()"></div>

<!-- CARTE PANEL -->
    <div class="main container" data-ng-show="carte">
        <h4 class="ui horizontal header divider">
            La Carte
        </h4>
        <!-- SUCCESS MSG -->
        <div class="ui success message" data-ng-show="signUpSuccess">
            <i class="close icon"></i>
            <div class="header">
                Bravo!
            </div>
            <p>Nouvel utilisateur ajouté avec succés.</p>
        </div>
        <div class="ui success message" data-ng-show="loginSuccess">
            <i class="close icon"></i>
            <div class="header">
                Bravo!
            </div>
            <p>Identifié avec succés.</p>
        </div>
        <div class="ui success message" data-ng-show="newbeerSuccess">
            <i class="close icon"></i>
            <div class="header">
                Bravo!
            </div>
            <p>Nouvelle bière ajoutée avec succés.</p>
        </div>
        <!-- BEER CARDS -->
        <div class="ui one cards">
            <div class="ui transparent left icon input search">
                <input type="text" placeholder="Search..." data-ng-model="search">
                <i class="search icon"></i>
            </div>
            <div class="{{beer.selected}} card" data-ng-repeat="beer in beers | filter:search">
                <div class="content">
                    <div class="header"><i class="{{beer.Pays}} flag beercountry" data-ng-click="reverse=!reverse;order('Pays', reverse)"></i> <span class="beername" data-ng-click="reverse=!reverse;order('Nom', reverse)">{{beer.Nom}}</span>
                        <span data-ng-show="userLoggedIn">
                            <div class="drunk" ng-show="beer.selected" data-ng-click="select(beer)">
                                <i class="bar icon"></i> Drunk!
                            </div>
                            <div class="notdrunk" ng-show="!beer.selected" data-ng-click="select(beer)">
                                <i class="large check icon" ng-class="{loading: hover}" ng-mouseenter="hover = true"
                                   ng-mouseleave="hover = false"></i>
                            </div>
                        </span>
                    </div>
                    <a class="ui black right ribbon label" data-ng-click="reverse=!reverse;order('Robe', reverse)"><i
                            class="theme icon"></i>{{beer.Robe}}</a>

                    <div class="description">
                        <span class="beertype" data-ng-click="reverse=!reverse;order('Type', reverse)">{{beer.Type}}</span>
                        <div class="alcool"><span class="beeralcool" data-ng-click="reverse=!reverse;order('Alcool', reverse)"><i class="filter icon"></i>{{beer.Alcool}}°</span> &nbsp;<span class="beercdmt" data-ng-click="reverse=!reverse;order('Conditionnement', reverse)"><i
                                class="cocktail icon"></i>{{beer.Conditionnement}}cl</span>
                        </div>
                    </div>
                </div>
                <div class="extra">
                    <div class="ui tiny buttons">
                        <div class="ui orange button" data-ng-click="reverse=!reverse;order('RBnote', reverse)">
                            {{beer.RBnote}}
                        </div>
                        <div class="or" data-text="RB"></div>
                        <div class="ui red button" data-ng-click="reverse=!reverse;order('RBstyle', reverse)">
                            {{beer.RBstyle}}
                        </div>
                    </div>
                    <div class="ui tiny buttons">
                        <div class="ui blue button" data-ng-click="reverse=!reverse;order('BAnote', reverse)">
                            {{beer.BAnote}}
                        </div>
                        <div class="or" data-text="BA"></div>
                        <div class="ui purple button" data-ng-click="reverse=!reverse;order('BAbro', reverse)">
                            {{beer.BAbro}}
                        </div>
                    </div>
                    <div class="price">
                        <a class="ui tag label" data-ng-click="reverse=!reverse;order('PrixBelge', reverse)">
                            {{beer.PrixBelge}} €</a>
                    </div>
                    <div class="ui heart rating front" ng-show="beer.selected" data-rating="{{beer.note}}" data-ng-click="rateabeer(beer)" data-max-rating="10"></div>
                </div>
            </div>
        </div>
    </div>

<!-- ADD BEER PANEL -->
    <div class="main container" data-ng-show="newbeer">
        <h4 class="ui horizontal header divider">
            Ajouter une nouvelle bière
        </h4>
        <form class="ui form newbeer" ng-submit="submitNewbeer(newbeerform)" name="newbeerform" method="post" action="">
            <div class="field">
                <label>Nom</label>
                <div class="field">
                    <input type="text" name="nom" placeholder="Nom de la bière" data-ng-model="newbeerData.nom">
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Type</label>
                    <select class="ui dropdown" name="type" data-ng-model="newbeerData.type">
                        <option value="">Type</option>
                        <option value="{{type.Id}}" data-ng-repeat="type in beertype">{{type.Nom}}</option>
                    </select>
                </div>
                <div class="field">
                    <label>Origine</label>
                    <select class="ui dropdown" name="pays" data-ng-model="newbeerData.pays">
                        <option value="">Pays</option>
                        <option value="{{pays.Id}}" data-ng-repeat="pays in beerpays">{{pays.Nom}}</option>
                    </select>
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Alcool</label>
                    <div class="field">
                        <input type="number" name="alcool" step="0.1" min="0" max="100" placeholder="Degré d'alcool" data-ng-model="newbeerData.alcool">
                    </div>
                </div>
                <div class="field">
                    <label>Robe</label>
                    <select class="ui dropdown" name="robe" data-ng-model="newbeerData.robe">
                        <option value="">Robe</option>
                        <option value="{{robe.Id}}" data-ng-repeat="robe in beerrobe">{{robe.Nom}}</option>
                    </select>
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Tarif</label>
                    <div class="field">
                        <div class="ui icon input">
                            <input type="number" name="prix" step="0.1" min="0" max="500" placeholder="Prix apéro belge" data-ng-model="newbeerData.prix">
                            <i class="euro icon"></i>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Conditionnement</label>
                    <select class="ui dropdown" name="cdmt" data-ng-model="newbeerData.cdmt">
                        <option value="">Type</option>
                        <option value="{{cdmt.Id}}" data-ng-repeat="cdmt in beercdmt">{{cdmt.Nom}} cl</option>
                    </select>
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>RateBeer</label>
                    <div class="field">
                        <div class="ui icon input">
                            <input type="number" min="0" max="100" name="RBnote" placeholder="Overall note" data-ng-model="newbeerData.RBnote">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>&nbsp;</label>
                    <div class="field">
                        <div class="ui icon input">
                            <input type="number" min="0" max="100" name="RBstyle" placeholder="Style note" data-ng-model="newbeerData.RBstyle">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>BeerAdvocate</label>
                    <div class="field">
                        <div class="ui icon input">
                            <input type="number" min="0" max="100" name="BAnote" placeholder="Global note" data-ng-model="newbeerData.BAnote">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>&nbsp;</label>
                    <div class="field">
                        <div class="ui icon input">
                            <input type="number" min="0" max="100" name="BAbro" placeholder="Bro note" data-ng-model="newbeerData.BAbro">
                        </div>
                    </div>
                </div>
            </div>
            <button class="ui {{submitButtonNewbeer}} button" type="submit">Ajouter</button>
            <div class="ui error message"></div>
        </form>
    </div>

<!-- COMMUNITY PANEL -->
<div class="main container" data-ng-show="community">
    <h4 class="ui horizontal header divider">
        User List
    </h4>
    <div class="ui five cards">
        <div class="card" data-ng-repeat="user in users">
            <div class="image">
                <img src="images/{{user.Avatar}}" id="avatar">
            </div>
            <div class="content">
                <a class="header" data-ng-click="seeDetail(user)">{{user.Nom}}</a>
            </div>
        </div>
    </div>
</div>

<!-- USER PANEL -->
    <div class="main container" data-ng-show="stat">
        <h4 class="ui horizontal header divider">
            Utilisateur
        </h4>
        <div data-ng-show="!userLoggedIn">
            <div class="ui warning message" data-ng-show="resultLoginMessage">
                <div class="header">Attention</div>
                <p>{{resultLoginMessage}}</p>
            </div>
            <div class="html ui top attached segment" data-ng-show="stat">
                <div class="ui two column middle aligned relaxed fitted stackable grid">
                    <div class="column">
                        <div class="ui form segment">
                            <form class="ui form login" ng-submit="submitLogin(loginform)" name="loginform" method="post" action="">
                                <div class="field">
                                    <label>Nom d'utilisateur</label>
                                    <div class="ui left icon input">
                                        <input type="text" placeholder="Pseudo" data-ng-model="loginData.pseudo" name="pseudo">
                                        <i class="user icon"></i>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Mot de passe</label>
                                    <div class="ui left icon input">
                                        <input type="password" data-ng-model="loginData.password" name="password">
                                        <i class="lock icon"></i>
                                    </div>
                                </div>
                                <input type="submit" id="submit" value="S'authentifier" class="ui {{submitButtonLogin}} button"/>
                            </form>
                        </div>
                    </div>
                    <div class="ui vertical divider">
                        Ou
                    </div>
                    <div class="center aligned column">
                        <div class="huge green ui labeled icon button" data-ng-click="gosignup()">
                            <i class="signup icon"></i>
                            S'enregistrer
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div data-ng-show="userLoggedIn">
            <div class="ui statistics">
                <table class="statable">
                    <tr>
                        <td class="statcol">
                            <div class="statistic">
                                <div class="value">
                                    {{beers.length}}
                                </div>
                                <div class="label">
                                    Bières disponibles
                                </div>
                            </div>
                        </td>
                        <td class="statcol">
                            <div class="statistic">
                                <div class="value">
                                    {{nbbrew}}
                                </div>
                                <div class="label">
                                    Bières consommées
                                </div>
                            </div>
                        </td>
                        <td class="statcol">
                            <div class="statistic">
                                <div class="value">
                                    {{beers.length-nbbrew}}
                                </div>
                                <div class="label">
                                    Bières non consommées
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="ui indicating progress" id="conso">
                <div class="bar"></div>
                <div class="label">{{ratebrew}}% Consommé</div>
            </div>
            <div class="ui one cards">
                <div class="green card" data-ng-repeat="beer in beers | filter:{ selected: 'green' }">
                    <div class="content">
                        <div class="header"><i class="{{beer.Pays}} flag beercountry" data-ng-click="reverse=!reverse;order('Pays', reverse)"></i> <span class="beername" data-ng-click="reverse=!reverse;order('Nom', reverse)">{{beer.Nom}}</span>
                            <div class="drunk" ng-show="beer.selected" data-ng-click="select(beer)">
                                <i class="bar icon"></i> Drunk!
                            </div>
                            <div class="notdrunk" ng-show="!beer.selected" data-ng-click="select(beer)">
                                <i class="large check icon" ng-class="{loading: hover}" ng-mouseenter="hover = true"
                                   ng-mouseleave="hover = false"></i>
                            </div>
                        </div>
                        <a class="ui black right ribbon label" data-ng-click="reverse=!reverse;order('Robe', reverse)"><i
                                class="theme icon"></i>{{beer.Robe}}</a>
                        <div class="description">
                            <span class="beertype" data-ng-click="reverse=!reverse;order('Type', reverse)">{{beer.Type}}</span>
                            <div class="alcool"><span class="beeralcool" data-ng-click="reverse=!reverse;order('Alcool', reverse)"><i class="filter icon"></i>{{beer.Alcool}}°</span> &nbsp;<span class="beercdmt" data-ng-click="reverse=!reverse;order('Conditionnement', reverse)"><i
                                    class="cocktail icon"></i>{{beer.Conditionnement}}cl</span>
                            </div>
                        </div>
                    </div>
                    <div class="extra">
                        <div class="ui tiny buttons">
                            <div class="ui orange button" data-ng-click="reverse=!reverse;order('RBnote', reverse)">
                                {{beer.RBnote}}
                            </div>
                            <div class="or" data-text="RB"></div>
                            <div class="ui red button" data-ng-click="reverse=!reverse;order('RBstyle', reverse)">
                                {{beer.RBstyle}}
                            </div>
                        </div>
                        <div class="ui tiny buttons">
                            <div class="ui blue button" data-ng-click="reverse=!reverse;order('BAnote', reverse)">
                                {{beer.BAnote}}
                            </div>
                            <div class="or" data-text="BA"></div>
                            <div class="ui purple button" data-ng-click="reverse=!reverse;order('BAbro', reverse)">
                                {{beer.BAbro}}
                            </div>
                        </div>
                        <div class="price"><a class="ui tag label"
                                              data-ng-click="reverse=!reverse;order('PrixBelge', reverse)">{{beer.PrixBelge}}
                            €</a>
                        </div>
                        <div class="ui heart rating back" ng-show="beer.selected" data-rating="{{beer.note}}" data-ng-click="rateabeer(beer)" data-max-rating="10"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main container"  data-ng-show="signup">
        <h4 class="ui horizontal header divider">
            S'enregistrer
        </h4>
        <div class="ui warning message" data-ng-show="resultSignupMessage">
            <div class="header">Attention</div>
            <p>{{resultSignupMessage}}</p>
        </div>
        <form class="ui form signup" ng-submit="submitSignup(signupform)" name="signupform" method="post" action="">
            <div class="two fields">
                <div class="required field">
                    <label>Nom d'utilisateur</label>
                    <div class="ui icon input">
                        <input type="text" placeholder="Pseudo" data-ng-model="signupData.pseudo" name="pseudo">
                        <i class="user icon"></i>
                    </div>
                </div>
                <div class="required field">
                    <label>Email</label>
                    <div class="ui icon input">
                        <input type="text" placeholder="Adresse mail" name="mail" data-ng-model="signupData.mail">
                        <i class="mail icon"></i>
                    </div>
                </div>
            </div>
            <div class="two fields">
                <div class="required field">
                    <label>Mot de passe</label>
                    <div class="ui icon input">
                        <input type="password" name="password" data-ng-model="signupData.password">
                        <i class="lock icon"></i>
                    </div>
                </div>
                <div class="required field {{confirm}}">
                    <label>Confirmation du mot de passe</label>
                    <div class="ui icon input">
                        <input type="password" name="passwordtwo" data-ng-model="signupData.passwordtwo">
                        <i class="lock icon"></i>
                    </div>
                </div>
            </div>
            <div class="field">
                <div
                        vc-recaptcha
                        theme="'light'"
                        key="model.key"
                        on-create="setWidgetId(widgetId)"
                        on-success="setResponse(response)"
                        ></div>
            </div>
            <div class="field">
                <input type="submit" id="submit" value="S'enregistrer" class="ui {{submitButtonSignup}} button"/>
            </div>
            <div class="ui error message"></div>
        </form>
    </div>
    <div class="footer">
        Copyleft <img src="cl.png" id="cl"> <?php echo date("Y"); ?>
    </div>
</div>
</body>
</html>
