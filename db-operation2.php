<?php

require 'vendor/autoload.php';
require 'lib/mysql.php';

$app = new Slim\App();

$app->get('/', 'get_vehicle');

$app->get('/vehicle/{id}', function($request, $response, $args) {
    get_vehicle_id($args['id']);
});
$app->post('/vehicle_add', function($request, $response, $args) {
    add_vehicle($request->getParsedBody());//Request object’s getParsedBody() method to parse the HTTP request 
});
$app->put('/update_vehicle', function($request, $response, $args) {
    update_vehicle($request->getParsedBody());
});
$app->delete('/delete_vehicle', function($request, $response, $args) {
    delete_vehicle($request->getParsedBody());
});
$app->run();

function get_vehicle() {
    $db = connect_db();
    $sql = "SELECT * FROM vehicles ORDER BY `vehicle_id`";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data);
}

function get_vehicle_id($vehicle_id) {
    $db = connect_db();
    $sql = "SELECT * FROM vehicles WHERE `vehicle_id` = '$vehicle_id'";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data);
}

function add_vehicle($data) {
    $db = connect_db();
    $sql = "insert into vehicles (customer_id,cname,vname,vmodel,vvin)"
            . " VALUES('$data[customer_id]','$data[cname]','$data[vname]','$data[vmodel]','$data[vvin]')";
    $exe = $db->query($sql);
    $last_id = $db->insert_id;
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}

function update_vehicle($data) {
    $db = connect_db();
    $sql = "update vehicles SET customer_id='$data[customer_id]',cname='$data[cname]',vname = '$data[vname]',vmodel = '$data[vmodel]',vvin='$data[vvin]'"
            . " WHERE vehicle_id = '$data[vehicle_id]'";
    $exe = $db->query($sql);
    $last_id = $db->affected_rows;
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}

function delete_vehicle($vehicle) {
    $db = connect_db();
    $sql = "DELETE FROM vehicles WHERE vehicle_id = '$vehicle[vehicle_id]'";
    $exe = $db->query($sql);
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}