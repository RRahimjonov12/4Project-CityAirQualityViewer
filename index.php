<?php
require __DIR__ . '/inc/functions.inc.php'; 
$contens = file_get_contents(__DIR__ . '/data/index.json');
$data = json_decode($contens, true);
?>

<?php require __DIR__ . '/views/header.inc.php'; ?>
<ul>

    <?php  foreach($data as $key => $info ) : ?>

    <li style="background-color: rgba(188, 235, 227, 0.47); border: solid 2px rgba(193, 222, 231, 0.69); margin-bottom: 5px; border-radius: 4px; padding-left: 4px;">
        <a href="city.php?<?php echo http_build_query(['city' => $info['city']] ) ?>">
        <?php echo e($info['city']) . ', ' . e($info['country']) . ' (' . e($info['flag']) . ')' ; ?>
        </a>
    </li>
    
    <?php endforeach; ?>
</ul>


<?php require __DIR__ . '/views/footer.inc.php'; ?>