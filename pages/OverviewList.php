<?php 
include 'templates/header.php';
?>

<h1 class='m-3 text-center py-3'>Lijst overzicht</h1>
</div>

<div class="position-absolute w-100 hidden" id="makeList">
    <form class="row justify-content-center p-3 mx-auto container medium-opacity border-15">
        <label class="col-12 text-center">Naam: <input type="text" class="col-3"></label>
        <button class="btn btn-primary text-light">Lijst aanmaken</button>
    </form>
</div>
<div class="container mx-auto light-opacity border-15 mb-3">
    <h2 class="m-3 text-center py-3">Lijst interface</h2>
    <button onclick = 'document.getElementById("makeList").classList.toggle("hidden")' class="btn btn-primary m-3">Open</button>
</div>

<div class="row container mx-auto">
    <div class="col-3 light-opacity border-15">
    <h2 class="text-center pt-2 pb-3">Lijst 1</h2>
        <ul>
            <li></li>
        </ul>
    </div>
</div>

<?php 
include 'templates/footer.php';
?>