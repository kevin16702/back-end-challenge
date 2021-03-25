<?php 
include 'templates/header.php';
$db = openDatabaseConnection();
function sortByTime($a, $b){
    $a = strtotime($a['Duration']);
    $b = strtotime($b['Duration']);
    return $a - $b;
  }
function sortByStatus($a, $b){
    return strcasecmp($a['Status'], $b['Status']);
}
function getListData($db){

    $sql = "SELECT * FROM lists";
    $result = $db->query($sql);
    $lists = $result->fetchAll(PDO::FETCH_ASSOC);
    return $lists;
}
function getTaskData($db){
    $sql = "SELECT * FROM tasks";
    $result = $db->query($sql);
    $tasks = $result->fetchAll(PDO::FETCH_ASSOC);
    return $tasks;
}
$lists = getListData($db);
$tasks = getTaskData($db);
function linkTaskToListData($lists, $tasks){
    $i = 0;
   foreach($lists as $list){
        $filteredTasks[$list['ID']] = [];
        foreach($tasks as $task){
            $filteredTasks[$list['ID']][$i] = [];
            if($list['ID'] == $task['ListID']){
                $filteredTasks[$list['ID']][$i] = $task;
            }
            $i++;
        }
    
   }
   return $filteredTasks;
}
$tasks = linkTaskToListData($lists, $tasks);
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


if(isset($_POST["makeListSubmit"])){
    $name = stripData($_POST["makeListName"]);
    $user = stripData($_POST["makeListUser"]);
    $sql =  "INSERT INTO lists (name, user) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $user]);
    echo "<meta http-equiv='refresh' content='0'>";
}
if(isset($_POST["makeTaskSubmit"])){
    $listID = $_POST["makeTaskID"];
    $name = stripData($_POST["makeTaskName"]);
    $duration = $_POST['makeTaskDuration'];
    $sql =  "INSERT INTO tasks (name, duration, listID) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $duration, $listID]);
    echo "<meta http-equiv='refresh' content='0'>";
}
if(isset($_POST['deleteListSubmit'])){
    $ID = $_POST['deleteListSubmit'];
    $sql = "DELETE FROM lists WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$ID]);

    $listID = $_POST['deleteListID'];
    $sql = "DELETE FROM tasks WHERE ListID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$listID]);
    echo "<meta http-equiv='refresh' content='0'>";
}
if(isset($_POST['deleteTaskSubmit'])){
    $ID = $_POST['deleteTaskSubmit'];
    $sql = "DELETE FROM tasks WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$ID]);
    echo "<meta http-equiv='refresh' content='0'>";  
}
if(isset($_POST['modifyListSubmit'])){
    $ID = $_POST["modifyListName"];
    $name = stripData($_POST["modifyListName"]);
    $user = stripData($_POST["modifyListUser"]);
    $sql =  "UPDATE lists SET Name = ?, User = ? WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $user, $ID]);  
    echo "<meta http-equiv='refresh' content='0'>";  
}
if(isset($_POST['modifyTaskSubmit'])){
    $ID = $_POST['modifyTaskSubmit'];
    $name = stripData($_POST["modifyTaskName"]);
    $sql =  "UPDATE tasks SET Name = ? WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $ID]);  
    echo "<meta http-equiv='refresh' content='0'>";  
}
if(isset($_POST['submitStatus'])){
    $ID = $_POST['submitStatus'];
    $status = $_POST['status'];
    $sql = "UPDATE tasks SET Status = ? WHERE ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$status, $ID]);
    echo "<meta http-equiv='refresh' content='0'>";  
}
?>