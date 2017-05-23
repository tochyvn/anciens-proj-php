<ul class="filtre">
  <li<?php if($_SESSION['annonce_tri']=='distance') print(' class="checked"');?>><a href="?annonce_tri=distance&amp;annonce_ordre=asc">Tri par Rayons</a></li>
  <li<?php if($_SESSION['annonce_tri']=='parution') print(' class="checked"');?>><a href="?annonce_tri=parution&amp;annonce_ordre=desc">Tri par Dates</a></li>
  <li class="separation<?php if($_SESSION['annonce_tri']=='loyer') print(' checked');?>"><a href="?annonce_tri=loyer&amp;annonce_ordre=asc">Tri par Loyers</a></li>
  <?php if($statut_liste->total>1){?>
      <li<?php if($_SESSION['annonce_statut']=='PARTICULIER') print(' class="checked"');?>><a href="?annonce_statut=PARTICULIER">Particuliers</a></li>
      <li<?php if($_SESSION['annonce_statut']=='') print(' class="checked"');?>><a href="?annonce_statut=">Part&nbsp;+&nbsp;Pro</a></li>
      <li<?php if($_SESSION['annonce_statut']=='PROFESSIONNEL') print(' class="checked"');?>><a href="?annonce_statut=PROFESSIONNEL">Professionnels</a></li>
  <?php }?>
</ul>
