<?php
    require_once(__DIR__ . '/../models/listeVille.php');
?>

<?php foreach ($villes as $ville) : ?>
    <option value="<?php echo htmlspecialchars($ville['ville']); ?>"></option>
<?php endforeach; ?>
