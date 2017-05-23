<?php include '../include1/header.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="page-header">Créer une nouvelle société</h1>
                        <form role="form" method="POST" action="../action/insertLieu.php">
                                        
                                        <div class="form-group">
                                            <label for="nomLieu">Nom Lieu</label>
                                            <input id="nomLieu" type="text" name="nomLieu" class="form-control" placeholder="Entrer le nom du lieu" required>
                                            <div style="border: red;">kkkkkkkkkkk</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="adrLieu">Adresse lieu</label>
                                            <input id="adrLieu" type="text" name="adrLieu" class="form-control" placeholder="Entrer l'adresse du lieu" required>
                                        </div>
                                        
                                        <?php include '../include/connect.php'; 
                                        $sql = "SELECT * FROM CATEGORIELIEU";
                                        $conn = ConnexionPDO::$_connexionBdd;
                                        $stmt = $conn->query($sql);
                                        $stmt->execute();
                                        
                                        if ($stmt->rowCount() > 0) {
                                            
                                            $categories = $stmt->fetchAll();
                                            
                                        }
       
                                        ?>
                                        <div class="form-group">
                                            <label for="cat">Categorie</label>
                                            <select id="cat" name="cat" class="form-control">
                                                <option selected>Selectionner une categorie</option>
                                                <?php foreach ($categories as $categorie) {
                                                            echo '<option value="'.$categorie['idCateg'].'">'.$categorie['nomCategFR'].'</option>';                                
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



