<!-- Mai, -->
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mb-3">

                    <?php
                    if (isset($error['add'])) {
                        echo '<p class="message">' . $error['add'] .  '</p>';
                    }
                    ?>
                    <?php
                    if (SessionFlash::checkMessage()) {
                    ?>
                        <div class="alert alert-primary" role="alert">
                            <strong><?= SessionFlash::getMessage() ?></strong>
                        </div>
                    <?php } ?>


                    <!-- Formulaire -->
                    <form method="post">
                        <div class="row g-2">

                            <!-- Premier champs -->
                            <div class="col-md">
                                <div class="form-floating">
                                    <input value="<?= $title ?? '' ?>" type="text" class="form-control" id="title" name="title" placeholder="Stack overflow" />
                                    <label for="title">Titre</label>
                                    <p class="input-error-text" id="nameTextError"><?= $error['title'] ?? '' ?></p>
                                </div>
                            </div>

                            <!-- Deuxieme champs -->
                            <div class="col-md">
                                <div class="form-floating">
                                    <input value="<?= $url ?? '' ?>" type="url" class="form-control" id="url" name="url" placeholder="https://stackoverflow.com" pattern="<?= REGEX_URL_HTTPS ?>" />
                                    <label for="url">Lien</label>
                                    <p class="input-error-text" id="nameTextError"><?= $error['url'] ?? '' ?></p>
                                </div>
                            </div>
                            <div class="col-md-auto d-flex">
                                <button class="btn btn-primary btn-lg">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Liste des liens ajouté -->
                <ul class="list-group">
                    <?php
                    foreach ($links as $link) {
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="<?= $link->url ?>"> <?= $link->title ?></a>
                            <span>
                                <!-- Modification -->
                                <a href="/controllers/updateController.php/?id=<?= $link->link_id ?>"> <i class="fa-regular fa-pen-to-square me-1 text-warning"></i></a>
                                <!-- Suppression -->
                                <a href="/controllers/deleteController.php/?id=<?= $link->link_id ?>"> <i class="fa-solid fa-trash ms-1 text-danger"></i></a>

                            </span>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</main>