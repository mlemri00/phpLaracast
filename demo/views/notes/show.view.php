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
            <footer class="mt-6">
                <a href="/note/edit?id=<?= $note['id']?>" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Edit</a>

            </footer>
        </div>
    </main>
<?= require (base_path('views/partials/footer.php'))?>