<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Main_modal extends MY_Model
{
    public function checkAccess($name, $operation)
    {
        $access = [
            /* 'category' => [
                [
                    'role'      => 'Admin',
                    'operation' => ['list', 'add_update', 'delete']
                ],
                [
                    'role'      => 'Accountant',
                    'operation' => ['list']
                ]
            ],
            'items' => [
                [
                    'role'      => 'Admin',
                    'operation' => ['list', 'add_update', 'delete']
                ]
            ] */
        ];
        
        if(isset($access[$name]))
            return array_filter($access[$name], function($ac) use($operation) {
                return $ac['role'] === $this->user->role && in_array($operation, $ac['operation']) ? true : false;
            }) ? true : false;
        else
            return false;
    }
}