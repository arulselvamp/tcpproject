<?php

require 'vendor/autoload.php';
require 'lib/mysql.php';

$app = new Slim\App();

$app->get('/', 'get_customer');

$app->get('/customer/{id}', function($request, $response, $args) {
    get_customer_id($args['id']);
});
$app->post('/customer_add', function($request, $response, $args) {
    add_customer($request->getParsedBody());//Request object’s getParsedBody() method to parse the HTTP request 
});
$app->put('/update_customer', function($request, $response, $args) {
    update_customer($request->getParsedBody());
});
$app->delete('/delete_customer', function($request, $response, $args) {
    delete_customer($request->getParsedBody());
});
$app->run();

function get_customer() {
    $db = connect_db();
    $sql = "SELECT * FROM customers ORDER BY `customer_id`";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data);
}

function get_customer_id($customer_id) {
    $db = connect_db();
    $sql = "SELECT * FROM customers WHERE `customer_id` = '$customer_id'";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data);
}

function add_customer($data) {
    $db = connect_db();
    $sql = "insert into customers (fname,lname,email,mob,address)"
            . " VALUES('$data[fname]','$data[lname]','$data[email]','$data[mob]','$data[address]')";
    $exe = $db->query($sql);
    $last_id = $db->insert_id;
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}

function update_customer($data) {
    $db = connect_db();
    $sql = "update customers SET fname='$data[fname]',lname='$data[lname]',email = '$data[email]',mob = '$data[mob]',address='$data[address]'"
            . " WHERE customer_id = '$data[customer_id]'";
    $exe = $db->query($sql);
    $last_id = $db->affected_rows;
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}

function delete_customer($customer) {
    $db = connect_db();
    $sql = "DELETE FROM customers WHERE customer_id = '$customer[customer_id]'";
    $exe = $db->query($sql);
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}