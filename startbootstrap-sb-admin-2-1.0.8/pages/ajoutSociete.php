<?php include '../include1/header.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="page-header">Créer une nouvelle société</h1>
                        <form role="form" method="POST" action="../action/insertSociete.php">
                                        
                                        <div class="form-group">
                                            <label for="nomSoc">Nom societe</label>
                                            <input id="nomSoc" type="text" name="nomSoc" class="form-control" placeholder="Entrer le nom de la societe" required>
                                            <div style="border: red;">kkkkkkkkkkk</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="adrSoc">Adresse societe</label>
                                            <input id="adrSoc" type="text" name="adrSoc" class="form-control" placeholder="Entrer l'adresse de la societe" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="site">Site Web</label>
                                            <input id="site" name="site" type="url" class="form-control" placeholder="Entrer le site web de la société" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tel">Telephone</label>
                                            <input id="tel" name="tel" type="tel" class="form-control" placeholder="Entrer le numéro téléphone" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="descrFR">Description française</label>
                                            <input id="descrFR" name="descrFR" type="text" class="form-control" placeholder="Entrer la description française" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="descrEN">Description anglaise</label>
                                            <input id="descrEN" name="descrEN" type="text" class="form-control" placeholder="Entrer la description anglaise" required>
                                        </div>
                                        <?php include '../include/connect.php'; 
                                        $sql = "SELECT * FROM CATEGORIELIEU";
                                        $conn = ConnexionPDO::$_connexionBdd;
                                        $stmt = $conn->query($sql);
                                        $stmt->execute();
                                        $resultat = array();
                                        if ($stmt->rowCount() > 0) {
        
                                            $resultat = $stmt->fetchAll();
                                            
                                        }
       
                                        ?>
                                        <div class="form-group">
                                            <label for="cat">Categorie</label>
                                            <select id="cat" name="cat" class="form-control">
                                                <option selected>Selectionner une categorie</option>
                                                <?php foreach ($resultat as $value) {
                                                            echo '<option value="'.$value['idCateg'].'">'.$value['nomCategFR'].'</option>';                                
                                                                                        } ?>
                                            </select>
                                        </div>
                                        <?php 
                                        $sql = "SELECT * FROM QUARTIER";
                                        $conn = ConnexionPDO::$_connexionBdd;
                                        $stmt = $conn->query($sql);
                                        $stmt->execute();
                                        $resultat = array();
                                        if ($stmt->rowCount() > 0) {
        
                                            $quartiers = $stmt->fetchAll();
                                            
                                        }
       
                                        ?>
                                        <div class="form-group">
                                            <label for="quart">Quartier</label>
                                            <select id="quart" name="quart" class="form-control">
                                                <option selected>Selectionner un quartier</option>
                                                <?php foreach ($quartiers as $quartier) {
                                                    echo '<option value="'.$quartier['idQuartier'].'">'.$quartier['nomQuartier'].'</option>';                                        
                                                                                        } ?>
                                            </select>
                                        </div>
                                        
                                        <input type="submit"  class="btn btn-default" value="Ajouter la Société"/>
                                        <input type="reset" class="btn btn-default" value="Reset" />
                                    </form>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include '../include1/footer.php'; 




