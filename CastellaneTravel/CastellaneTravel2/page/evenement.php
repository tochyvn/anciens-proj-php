
   <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php $events = $articlenews->recupevent();
                //var_dump($events->lienArtPhoto);
                foreach($events as $event):?>
                    <div class="row">
                        <div class="col-lg-6  col-md-5 ">
                            <img class="img-responsive" src="<?php echo $pathphoto.$event->lienArtPhoto; ?>" alt="">
                        </div>
                        <div class="col-lg-6  col-md-7 ">
                            <div class="post-preview">
                                <h2 class="post-title"><?php echo $event->titreArticleFR; ?></h2>
                                <h3 class="post-subtitle"><?php echo $event->dateDebArticleNews; ?></h3>
                                <p><?php echo $event->txtArticleFR; ?></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <hr>