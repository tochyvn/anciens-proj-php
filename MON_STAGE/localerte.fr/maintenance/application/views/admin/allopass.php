<div class="col-lg-12">
    <h1 class="page-header">
        Statisques <small>Allopass</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="index.html">Statistiques</a>
        </li>
        <li class="active">
            <i class="fa fa-file"></i> Allopass
        </li>
    </ol>
    <div class="row">
        <ol class="breadcrumb">
            <li>
                <a class="btn btn-primary" href="<?php echo base_url().'index.php/admin/stats/allopass'; ?>">Jour</a>
            </li>
            <li>
                <a class="btn btn-primary" href="<?php echo base_url().'index.php/admin/stats/allopass/mois'; ?>">Mois</a>
            </li>
            <li>
                <a class="btn btn-primary" href="<?php echo base_url().'index.php/admin/stats/allopass/an'; ?>">An</a>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Graph</h3>
            </div>
            <div class="panel-body">
                <div id="graph_stats">
                    
                </div>
            </div>
    </div>
</div>
    
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    function drawChart(json, repere_temporel) {

      var data = google.visualization.arrayToDataTable(json);

      var options = {
        title: 'Statistiques Allopass',
        hAxis: {title: repere_temporel, titleTextStyle: {color: 'red'}}
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('graph_stats'));

      chart.draw(data, options);
    }
    
    $(function(){
        var json = JSON.parse('<?php echo $stats; ?>');
        var repere_temporel = '<?php echo $repere_temporel; ?>';
        drawChart(json, repere_temporel); 
    });
</script>