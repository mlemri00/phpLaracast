<?= require(base_path('views/partials/head.php')) ?>
<?= require(base_path("views/partials/nav.php")) ?>
<?= require(base_path("views/partials/banner.php")) ?>

    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <p class="text-white" >Hello, <?= $_SESSION['user']['email']?? 'guest' ?></p>
        </div>
    </main>


    <?= require (base_path('views/partials/footer.php'))?>