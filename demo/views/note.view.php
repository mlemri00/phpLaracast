<?= require('partials/head.php')?>
<?= require ("partials/nav.php")?>
<?= require ("partials/banner.php")?>

    <main>
        <div class=" text-white mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <!-- Your content -->
            <p class="mb-6">
                <a href="/notes">Go back...</a>
            </p>
            <p><?= $note['body']?> </p>
        </div>
    </main>
<?= require ('partials/footer.php')?>