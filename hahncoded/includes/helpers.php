<?php 

/* Returns an array of Errors is any fields in a given array are empty*/
function enforceFields(array $data, array $fields) {
    $error = [];

    foreach($fields as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            $errors[$field] = "This field is required";
        }
    }
    return $errors;
}

?>
