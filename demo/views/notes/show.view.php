<?= require('views/partials/head.php') ?>
<?= require("views/partials/nav.php") ?>
<?= require("views/partials/banner.php") ?>


    <main>
        <div class=" text-white mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <!-- Your content -->
            <p class="mb-6">
                <a href="/notes">Go back...</a>
            </p>
            <p>   <?= htmlspecialchars($note['body'])?> </p>
        </div>
    </main>
<?= require('partials/footer.php') ?>