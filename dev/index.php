<?php
#$input = new \Gajus\Vlad\Input($_POST);
#$input->name('title_id', 'Title');

$test = new \Gajus\Vlad\Test();

$test
    ->assert('terms_and_conditions')
    ->is('NotEmpty', null, ['message' => 'Must agree to the terms and conditions.'])

$test
    ->assert('title_id')
    ->is('NotEmpty', null, ['message' => 'Please select your Title.'])
    ->is('String');

$test
    ->assert('user[first_name]')
    ->is('NotEmpty')
    ->is('String');

$test
    ->assert('user[last_name]')
    ->is('NotEmpty')
    ->is('String');

$test
    ->assert('user[password]')
    ->is('NotEmpty')
    ->is('String')
    ->is('Length', ['min' => 8]);

$test->assess($input);





