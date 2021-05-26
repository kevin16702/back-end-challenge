<?php
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