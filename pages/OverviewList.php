<?php include 'templates/header.php';
include 'datalayer.php';
?>
<h1 class='m-3 text-center py-3'>Lijst overzicht</h1>
</div>
<div class="position-absolute w-100 hidden" id="makeList">
    <form class="row justify-content-center p-3 mx-auto container bg-light border-15" method="post" action=''>
    <div class="close-button" onclick="document.getElementById('makeList').classList.toggle('hidden')">X</div>
        <label class="col-12 mx-5 px-5 row justify-content-between text-center">Naam: <input type="text" class="col-3" name="makeListName" required></label>
        <label class="col-12 mx-5 px-5 row justify-content-between text-center">Gebruiker: <input type="text" class="col-3" name="makeListUser" required></label>
        <button name="makeListSubmit" type="submit" value="null" type="button" class="btn btn-success text-light">Lijst aanmaken</button>
    </form>
</div>


<div class="justify-content-around row container mx-auto h-100">
<div class=" col-3 light-opacity border-15 m-3 h-75">
    <button onclick = 'document.getElementById("makeList").classList.toggle("hidden")' class="btn btn-primary m-3">Nieuwe Lijst <strong>+</strong></button>
</div>
    <?php 
    $index = 0;
    foreach($lists as $list){ ?>
    <div class="col-3 light-opacity border-15 m-3 pb-4 h-75">
    <h2 class="text-center pt-2"><?= $list['Name']; ?></h2>
    <p class=" pt-2 text-primary">Gebruiker: <?= $list['User']; ?></p>
    <button class="btn btn-warning" onclick="document.getElementById('ModifyList<?= $index; ?>').classList.toggle('hidden'); document.getElementById('makeTask<?= $index; ?>').classList.add('hidden');">Bewerk lijst</button>
    <button class="btn btn-success" onclick="document.getElementById('makeTask<?= $index; ?>').classList.toggle('hidden'); document.getElementById('ModifyList<?= $index; ?>').classList.add('hidden');">Nieuwe taak <strong>+</strong></button>
    <form action='' method="post" class="row hidden mt-3" id='<?= 'ModifyList' . $index; ?>' method="post">
        <label class="col-12 mx-1 row justify-content-between text-center">Naam: <input type="text" class="col-5" name="modifyListName" value="<?= $list['Name']; ?>" required></label>
        <label class="col-12 mx-1 row justify-content-between text-center">Gebruiker: <input type="text" class="col-5" name="modifyListUser" value="<?= $list['User']; ?>" required></label>
            <input type="hidden" value="<?= $list['ID']; ?>" name="modifyListID">
            <button type="submit" class="btn btn-success m-3" name="modifyListSubmit">Opslaan</button>
            <button type="button" class="btn btn-danger m-3" onclick="document.getElementById('deleteList<?= $index; ?>').classList.toggle('hidden');">Verwijder lijst</button>
    </form>

    <form action='' method="post" class="row hidden m-3" id='<?= "deleteList" . $index; ?>'>
                <div class="w-100">Weet u het zeker dat u deze lijst wilt verwijderen?</div>
                <input type="hidden" value="<?= $list['ID']; ?>" name="deleteListID">
                <button name="deleteListSubmit" type="submit" value="<?= $list['ID']; ?>" class="btn btn-success px-2">Ja</button>
                <button onclick="document.getElementById('deleteListSubmit<?= $index; ?>').classList.toggle('hidden');" class="btn">Nee</button>
    </form>

    <form action='' method="post" class="row hidden mt-3" id='<?= 'makeTask' . $index; ?>' method="post">
        <input type="hidden" value="<?= $list['ID']; ?>" name="makeTaskID">
        <label class="col-12 text-center row justify-content-between px-3 mx-auto">Naam: <input type="text" class="col-6" name="makeTaskName" required></label>
        <label class="col-12 text-center row justify-content-between px-3 mx-auto">Duur: <input type="time" class="col-6" name="makeTaskDuration" required></label>
        <button name="makeTaskSubmit" type="submit" value="null" type="button" class="btn btn-success text-light m-3">Taak aanmaken</button>
    </form>

    <?php if($tasks[$list['ID']] ){ ?>
    <div class="text-center mt-3 w-100">Taken overzicht</div>
    <div>sorteer op 
        <form class="row" method="post">
            <div class="w-100 px-5">
                <input name="sort" type="radio">Standaard
            </div>
            <div class="w-100 px-5">
                <input name="sort" type="radio" value="time">Tijd
            </div>
            <div class="w-100 px-5">
                <input name="sort" type="radio" value="status">Status
            </div>
            <button type="submit" class="btn btn-success mx-5" name="submitSort">Sorteer</button>
        </form>
    </div>
    <hr>
    <ul>   
        <?php
        if(isset($_POST['submitSort'])){
            $sortValue = $_POST['sort'];
            if($sortValue == "time"){
                usort($tasks[$list['ID']], 'sortByTime');   
            }
            if($sortValue == "status"){
                usort($tasks[$list['ID']], 'sortByStatus');
            }
        }
        $taskIndex = 0;
        foreach($tasks[$list['ID']] as $task){if($task){ $taskIndex++;?>
        <li class="position-relative mb-3"><?= $task['Name'] . ', Duur: ' . $task['Duration']; ?></br>Status: <?= $task['Status']; ?></li>
        <button type="button" class="btn btn-primary" onclick="document.getElementById('modifyStatus<?= $index; ?>Task<?= $taskIndex; ?>').classList.toggle('hidden'); document.getElementById('modifyList<?= $index; ?>Task<?= $taskIndex; ?>').classList.add('hidden'); document.getElementById('deleteList<?= $index; ?>Task<?= $taskIndex; ?>').classList.add('hidden');">Bewerk Status</button>
        <form method="post" class="row hidden" id="modifyStatus<?= $index; ?>Task<?= $taskIndex; ?>">
        <div class="w-100 px-3">
                <input name="status" type="radio" value="Nog niet begonnen">Nog niet begonnen
            </div>
            <div class="w-100 px-3">
                <input name="status" type="radio" value="Bezig">Bezig
            </div>
            <div class="w-100 px-3">
                <input name="status" type="radio" value="Voltooid">Voltooid
            </div>
            <button type="submit" class="btn btn-success mx-3 mb-4" value="<?= $task['ID']; ?>" name="submitStatus">Wijzig verandering</button>
        </form>
        <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteList<?= $index; ?>Task<?= $taskIndex; ?>').classList.toggle('hidden'); document.getElementById('modifyList<?= $index; ?>Task<?= $taskIndex; ?>').classList.add('hidden'); document.getElementById('modifyStatus<?= $index; ?>Task<?= $taskIndex; ?>').classList.add('hidden');">Verwijder taak</button>
        <form action='' method="post" class="row hidden" id='<?= "deleteList" . $index .'Task' . $taskIndex; ?>'>
                <div class="w-100">Weet u het zeker dat u deze lijst wilt verwijderen?</div>
                <button name="deleteTaskSubmit" type="submit" value="<?= $task['ID']; ?>" class="btn btn-success px-2">Ja</button>
                <button onclick="document.getElementById('deleteList<?= $index; ?>Task<?= $taskIndex; ?>').classList.toggle('hidden');" class="btn">Nee</button>
    </form>
        <button type="button" class="btn btn-warning" onclick="document.getElementById('modifyList<?= $index; ?>Task<?= $taskIndex; ?>').classList.toggle('hidden'); document.getElementById('deleteList<?= $index; ?>Task<?= $taskIndex; ?>').classList.add('hidden'); document.getElementById('modifyStatus<?= $index; ?>Task<?= $taskIndex; ?>').classList.add('hidden');">Bewerk taak</button>
        <?php } ?>
    <form action='' method="post" class="row hidden" id='<?= "modifyList" . $index .'Task' . $taskIndex; ?>'>
                <div class="w-100">Bewerk taak</div>
                <label>Naam: <input type="text" name="modifyTaskName" value="<?= $task['Name']; ?>" required></label>
                <button name="modifyTaskSubmit" type="submit" value="<?= $task['ID']; ?>" class="btn btn-success px-2">Opslaan</button>
    </form><?php $taskIndex++; }?>
    </ul>
        <?php } ?>
    </div>
    <?php 
    $index++;
    } ?>
</div>
<?php 
include 'templates/footer.php';
?>