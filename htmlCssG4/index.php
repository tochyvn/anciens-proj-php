<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mon formulaire</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Projet de mise en pratique HTML-CSS" />
        <meta name="keywords" content="HTML5, CSS3, mediaqueries, positionnement, style" />
        <meta name="author" content="TOCHAP NGASSAM Lionel" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body>
        <div class="page">
            
            <header>
                <h3>Mon Header</h3>
            </header>
            <nav>
                <h3>Mon Menu</h3>
            </nav>
            <section class="principal">
                <h3>Section Principale</h3>
                <section class="content1">
                    <h3>Section secondaire 1</h3>
                    <article class="art1">
                        <h3>Introduction</h3>
                        <p>
                        Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum, quam Hannibaliano regi fratris filio antehac Constantinus iunxerat pater, Megaera quaedam mortalis, inflammatrix saevientis adsidua, humani cruoris avida nihil mitius quam maritus; qui paulatim eruditiores facti processu temporis ad nocendum per clandestinos versutosque rumigerulos conpertis leviter addere quaedam male suetos falsa et placentia sibi discentes, adfectati regni vel artium nefandarum calumnias insontibus adfligebant.

Quibus occurrere bene pertinax miles explicatis ordinibus parans hastisque feriens scuta qui habitus iram pugnantium concitat et dolorem proximos iam gestu terrebat sed eum in certamen alacriter consurgentem revocavere ductores rati intempestivum anceps subire certamen cum haut longe muri distarent, quorum tutela securitas poterat in solido locari cunctorum.

Procedente igitur mox tempore cum adventicium nihil inveniretur, relicta ora maritima in Lycaoniam adnexam Isauriae se contulerunt ibique densis intersaepientes itinera praetenturis provincialium et viatorum opibus pascebantur.
                        </p>
                    </article>
                    <article>
                        <h3>Formulaire et tutoriel</h3>
                        <div class="tuto">
                            <video controls="controls">
                                <source src="videos/ma_video.mp4" type="video/mp4" />
                                <source src="videos/ma_video.webm" type="video/webm" />
                                <source src="videos/ma_video.ogv" type="video/ogg" />
                                <source src="videos/ma_video.m4v" />
                            </video>
                            <p>
                           Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum, quam Hannibaliano regi fratris filio antehac Constantinus iunxerat pater, Megaera quaedam mortalis, inflammatrix saevientis adsidua, humani cruoris avida nihil mitius quam maritus; qui paulatim eruditiores facti processu temporis ad nocendum per clandestinos versutosque rumigerulos conpertis leviter addere quaedam male suetos falsa et placentia sibi discentes, adfectati regni vel artium nefandarum calumnias insontibus adfligebant.

Quibus occurrere bene pertinax miles explicatis ordinibus p
                            </p>
                        </div>
                    
                        <div id="monForm">
                            
                            <form action="mailto:tochlion@yahoo.fr" >
                                <fieldset>
                                    <legend>Informations personnelles</legend>
                                    <p>
                                        <label for="name">Nom : </label><br/>
                                        <input id="name" type="text" name="name" placeholder="Entrer votre nom" class="radius" required />
                                    </p>
                                    <p>
                                        <label for="surname">Prenom : </label><br/>
                                        <input id="surname" type="text" name="surname" placeholder="Entrer votre prenom" class="radius" required />
                                    </p>
                                    <p>
                                        <label for="mail">Email : </label><br/>
                                        <input id="mail" type="email" name="mail" placeholder="Entrer votre mail" class="radius" required />
                                    </p>
                                    <p>
                                        <label for="tel">Telephone : </label><br/>
                                        <input id="tel" type="tel" name="tel" placeholder="Entrer votre telephone" class="radius" pattern="^0[1-69][0-9]{8}$" required/>
                                    </p>
                                    <p>
                                        <label for="passwd">Mot de passe : </label><br/>
                                        <input id="passwd" type="password" name="passwd" placeholder="Taper votre mot de passe" required class="radius"/>
                                    </p>
                                    <p>
                                        <label for="rpasswd">Confirmer votre mot de passe : </label><br/>
                                        <input id="rpasswd" type="password" name="rpasswd" placeholder="Retaper votre mot de passe" required class="radius"/>
                                    </p>
                                    <p>
                                        <label for="pays">Pays : </label><br/>
                                        <select name="pays" id="pays">
                                            <option value="0" selected="selected">Selectionner un pays</option>
                                            <option value="1">Cameroun</option>
                                            <option value="2">Algerie</option>
                                            <option value="3">Mali</option>
                                            <option value="4">Russie</option>
                                            <option value="5">France</option>
                                            <option value="6">Iran</option>
                                            <option value="7">Angleterre</option>
                                            <option value="8">Inde</option>
                                        </select>
                                    </p>
                                    <p>
                                        <label for="sexe1">Masculin :   </label>
                                        <input id="sexe1" type="radio" checked="checked" name="surname" />
                                        <label for="sexe2">Feminin :   </label>
                                        <input id="sexe2" type="radio" name="surname" />
                                    </p>
                                    <p>
                                        <input id="cgu" type="checkbox" name="cgu" />
                                        <label for="cgu">Accepter les conditions générales des termes du contrat</label>
                                    </p>
                                    <p>
                                        <input type="submit" name="valider" value="soumettre le formulaire" class="radius"/>
                                    </p>
                                </fieldset>
                            </form>
                        
                        </div>
                    </article>
                </section>
                <section class="content2">
                    <h3>Section Secondaire 2</h3>
                    <div id="actu">
                        <div class="item">
                        
                        </div>
                        <div class="item">
                        
                        </div>
                        <div class="item">
                        
                        </div>
                        <div class="item">
                        
                        </div>
                        <div class="item">
                        
                        </div>
                        <div class="item">
                        
                        </div>
                        <div class="item">
                        
                        </div>
                        <div class="item">
                        
                        </div>
                        <div class="item">
                        
                        </div>
                        <div class="item">
                        
                        </div>
                        <div class="item">
                            
                        </div>
                    </div>
                </section>
            </section>
            <!--
            <section class="content2">
                
            </section>
            -->
            <footer>
                
                <div class="w3c">
                    <img src="img/valid-css3.png" alt="logo_w3c"/>
                    <img src="img/valid-html5.png" alt="logo_ww3" />
                </div>
                
            </footer>
            
        </div>
    </body>
</html>
