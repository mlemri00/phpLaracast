<?= require(base_path('views/partials/head.php')) ?>
<?= require(base_path("views/partials/nav.php")) ?>
<?= require(base_path("views/partials/banner.php")) ?>


    <main>
        <div class=" text-white mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <!-- Your content -->
            <p class="mb-6">
                <a href="/notes">Go back...</a>
            </p>
            <p>   <?= htmlspecialchars($note['body'])?> </p>

            <form class="mt-6" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id" value="<?= $note['id']?>">
                <button class="text-sm text-red-500">Delete</button>
            </form>
        </div>
    </main>
<?= require (base_path('views/partials/footer.php'))?>