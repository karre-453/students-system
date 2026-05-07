<?php

$file = "classmates.json";

// Create JSON file if it doesn't exist
if (!file_exists($file)) {
    file_put_contents($file, json_encode([]));
}

// Read data from JSON file
function readData() {
    global $file;

    $json = file_get_contents($file);
    $data = json_decode($json, true);

    return $data ?: [];
}

// Save data to JSON file
function saveData($data) {
    global $file;

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

// Add new classmate
function addClassmate($lastname, $firstname, $sex, $bdate, $age, $religion, $talent) {

    $data = readData();

    // Auto increment stud_no
    $nextId = 1;

    if (!empty($data)) {
        $ids = array_column($data, 'stud_no');
        $nextId = max($ids) + 1;
    }

    $newRecord = [
        "stud_no" => $nextId,
        "lastname" => $lastname,
        "firstname" => $firstname,
        "sex" => $sex,
        "bdate" => $bdate,
        "age" => $age,
        "religion" => $religion,
        "talent" => $talent
    ];

    $data[] = $newRecord;

    saveData($data);
}

// Delete classmate
function deleteClassmate($id) {

    $data = readData();

    $data = array_filter($data, function($item) use ($id) {
        return $item['stud_no'] != $id;
    });

    saveData(array_values($data));
}

// Update classmate
function updateClassmate($id, $lastname, $firstname, $sex, $bdate, $age, $religion, $talent) {

    $data = readData();

    foreach ($data as &$item) {

        if ($item['stud_no'] == $id) {

            $item['lastname'] = $lastname;
            $item['firstname'] = $firstname;
            $item['sex'] = $sex;
            $item['bdate'] = $bdate;
            $item['age'] = $age;
            $item['religion'] = $religion;
            $item['talent'] = $talent;

            break;
        }
    }

    saveData($data);
}
?>