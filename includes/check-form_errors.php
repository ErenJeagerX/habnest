<?php

if($_SERVER['CONTENT_TYPE'] === 'application/json') {
    $input_data = json_decode(file_get_contents("php://input"), 1);
    $errors = check_errors($input_data);
    echo json_encode($errors);
}
else {
    header("Location: ../index.php");
    die();
}

function check_errors($data){
    $errors = [
        "emptyInput" => [],
        "invalidNameInput" => [],
        "nameInputLengthError" => [],
        "passLengthError" => false,
        "invalidPNum" => false,
        "usernameLengthError" => false,
        "invalidUsername" => [],
        "usernameTaken" => false,
        "numberTaken" => false
    ];

    foreach($data as $datum) {
        if(empty($datum['value'])) {
            array_push($errors['emptyInput'], $datum['id']);
        }
    }

    $name_inputs = [
        $data['first_name'],
        $data['last_name']
    ];

    foreach($name_inputs as $input) {
        if(!ctype_alpha($input['value']) && !empty($input['value'])){
            array_push($errors['invalidNameInput'], $input['id']);
        } elseif(strlen($input['value']) < 3 && !empty($input['value'])){
            array_push($errors['nameInputLengthError'], $input['id']);
        }
    }

    if(strlen($data['username']['value']) < 4 && !empty($data['username']['value'])){
        $errors['usernameLengthError'] = true;
    }

    if(!allowedUsername($data['username']['value']) && !empty($data['username']['value'])) {
        array_push($errors['invalidUsername'], 'notAllowed');
    }

    if(strpos($data['username']['value'], ' ') !== false) {
        array_push($errors['invalidUsername'], 'spaces');
    }

    if(!empty($data['username']['value'])) {
        if(is_numeric($data['username']['value'][0])){
            array_push($errors['invalidUsername'], 'startError');
        }
    }

    if(strlen($data['pwd']['value']) < 8 && !empty($data['pwd']['value'])){
        $errors['passLengthError'] = true;
    }

    if((!ctype_digit($data['phone_number']['value']) || strlen($data['phone_number']['value']) !== 10) && !empty($data['phone_number']['value'])){
        $errors['invalidPNum'] = true;
    }

    // username check
    require_once 'db.php';
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $data['username']['value']);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $errors['usernameTaken'] = true;
    }

    $stmt->close();
    // number check
    $stmt = $conn->prepare("SELECT * FROM users WHERE phone_number = ?");
    $stmt->bind_param('s', $data['phone_number']['value']);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $errors['numberTaken'] = true;
    }

    $stmt->close();
    $conn->close();

    return $errors;
}



function allowedUsername($input) {
    return preg_match("/^[a-zA-Z0-9_.]+$/", $input);
}