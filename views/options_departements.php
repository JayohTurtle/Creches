<?php
    require_once(__DIR__ . '/../models/listeDepartement.php');
?>

<?php foreach ($departements as $departement) : ?>
    <option value="<?php echo htmlspecialchars($departement['departement']); ?>"></option>
<?php endforeach; 

?>