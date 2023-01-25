<?php ob_start(); ?>

<table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Animaux</th>
      <th scope="col">Déscription</th>
      <th scope="col" colspan='2'>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($animaux as $animal) :?>
  
      <tr class='align-middle'>
        <td><?= $animal['animal_id'] ;?></td>
        <td>
          <img src='<?= URL?>public/images/<?= $animal['animal_image'] ?>' style='width:50px'/>
        </td>
        <td><?= $animal['animal_nom'] ;?></td>
        <td><?= $animal['animal_description'] ;?></td>
        <td>
            <a href='<?php URL ?>/back/animaux/modification/<?=$animal['animal_id']?>'>
                <button class='btn btn-warning' >
                    Modifier
                </button>
            </a>
        </td>
        <td>
            <form method="POST" action="<?php URL ?>/back/animaux/validationSuppression" onSubmit='return confirm("Voulez-vous vraiment supprimer ?")'>
                <input type="hidden" name="animal_id" value="<?= $animal['animal_id']?>"/>
                <button class='btn btn-danger' type='submit'>
                    Supprimer
                </button>
            </form>
        </td>
      </tr>

    <?php endforeach; ?>
  </tbody>
</table>

<?php

$content = ob_get_clean();
$titre = "Les animaux";

require 'views/commons/template.php';