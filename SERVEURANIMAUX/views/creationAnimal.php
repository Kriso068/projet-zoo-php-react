<?php ob_start(); ?>


<form method="POST" action="<?= URL ?>back/animaux/creationValidation" enctype="multipart/form-data">
    <div class="form-group">
        <label for="animal_nom">nom</label>
        <input type="text" class="form-control" id="animal_nom" name="animal_nom">
    </div>
    <div class="form-group">
        <label for="animal_description">Description</label>
        <textarea class="form-control" id="animal_description" name="animal_description" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input class="form-control" type="file" id="image" name='image'>
    </div>
    <div class="mb-3">
        <label for="famille" class="form-label">Familles :</label>
        <select class="form-select" name='famille_id'>
            <option selected>Choix de la famille :</option>
            
            <?php foreach ($familles as $famille) : ?>
                <option value="<?= $famille['famille_id'];?>">
                    <?= $famille['famille_id'] ?> - <?= $famille['famille_libelle'] ?>
                </option>
            <?php endforeach ?>    
      
        </select>
    </div>
    <div class='row no-gutters'>
        <div class='col-1'></div>
            <?php foreach ($continents as $continent) : ?>
                <div class="mb-3 form-check col-2">
                    <input type="checkbox" class="form-check-input" name='continent-<?= $continent['continent_id'] ?>'>
                    <label class="form-check-label" for="exampleCheck1"><?= $continent['continent_libelle'] ?></label>
                </div>
            <?php endforeach ?>  
        <div class='col-1'></div>

    </div>

    <button type="submit" class="btn btn-primary">Valider</button>
</form>

<?php 
$content = ob_get_clean();
$titre = "Page de création d'un animal";
require "views/commons/template.php";