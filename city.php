<?php
require __DIR__ . '/inc/functions.inc.php'; 

/* GET CITY */

$city = null;

if(!empty($_GET['city'])){
 $city = $_GET['city'];
}

/*  GET FILENAME */
   $filename = null;
   $cityInform = [];
if(!empty($city)){

    $cities =  json_decode(
        file_get_contents(__DIR__ . '/data/index.json')
    , true);

 
        foreach($cities as $currentCity){
            if($currentCity['city'] === $city){
                $filename = $currentCity['filename'];
                $cityInform = $currentCity;
                break;
            }

        }

}

if(!empty($filename)){
    $results = json_decode(
        file_get_contents('compress.bzip2://' . __DIR__ . '/data/' . $filename),
        true
    )['results'];
}

$units = [
   'pm25' => null,
   'pm10' => null
];

foreach($results as $result){
    if(!empty($units['pm25']) && !empty($units['pm10'])) break;
    if($result['parameter'] === 'pm25'){
        $units['pm25'] = $result['unit'];
    }
    if($result['parameter'] === 'pm10'){
        $units['pm10'] = $result['unit'];
    }
}


$stats = [];
foreach($results as $result){

    if($result['parameter'] !== 'pm25' && $result['parameter'] !== 'pm10') continue;
    if($result['value'] < 0 ) continue;
  
    $month = substr($result['date']['local'], 0, 7);
    if(!isset($stats[$month])){
        $stats[$month] = [
            'pm25' => [],
            'pm10' => []
        ];
    }
    $stats[$month][$result['parameter']][] = $result['value'];
   
}


?>


<?php require __DIR__ . '/views/header.inc.php'; ?>

<?php if (empty($city)): ?>

    <p>This page could not be found</p>

<?php else: ?>
    <h1><?php echo e($cityInform['city'] ). ' ' . e($cityInform['flag']); ?></h1>

    <?php if(!empty($stats)) : ?>

        <script src="/scripts/chart.umd.js"></script>
        <canvas id="aqi-chart"></canvas>
            <?php
            $labels = array_keys($stats);
            sort($labels);

            $pm25 = [];
            $pm10 = [];
            foreach($labels as $label){
                $mesurements = $stats[$label];
                if(!empty($mesurements['pm25'])){
                $pm25[] = round(array_sum($mesurements['pm25']) / count($mesurements['pm25']), 2);
                }
                else{
                    $pm25[] = 0;
                }
                if(!empty($mesurements['pm10'])){
                $pm10[] = round(array_sum($mesurements['pm10']) / count($mesurements['pm10']), 2);
                }
                else{
                    $pm10[] = 0;
                }
            }
            
            $datasets = [];
            if(array_sum($pm25) > 0){
                $datasets[] = [
                    'label' => "AQI pm 2.5 in {$units['pm25']}",
                    'data' => array_values($pm25),
                    'fill' => "false",
                    'borderColor' => 'rgb(75, 192, 192)',
                    'tension' => 0.1
                ];
            }
            if(array_sum($pm10) > 0){
                $datasets[] = [
                    'label' => "AQI pm 2.5 in {$units['pm10']}",
                    'data' => array_values($pm10),
                    'fill' => "false",
                    'borderColor' => 'rgba(192, 75, 147, 1)',
                    'tension' => 0.1
                ];
            }
            
            ?>
        <script>
            const ctx = document.getElementById('aqi-chart');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                        datasets: <?php echo json_encode($datasets) ?> 
                },
                }); 
        </script>
    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>PM 2.5 concentration</th>
                <th>PM10 concentration</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach($stats as $month => $mesurements): ?>
                    <tr>
                    <th><?php echo e($month); ?></th>
                    <td>
                        <?php  if(!empty($mesurements['pm25'])){echo e(round(array_sum($mesurements['pm25'])/ count($mesurements['pm25']), 2));}
                       else { echo e('Data not available');}?>
                        <?php echo e($units['pm25']); ?>
                    </td>    
                    <td>
                        <?php 
                        if(!empty($mesurements['pm10'])){echo e(round(array_sum($mesurements['pm10'])/ count($mesurements['pm10']), 2));}
                       else { echo e('Data not available');} ?>
                        <?php echo e($units['pm10']); ?> 
                    </td>           
                    </tr>
                <?php endforeach; ?>
        </tbody>        
    </table>
    <?php endif; ?>
<?php endif; ?>


<?php require __DIR__ . '/views/footer.inc.php'; ?>