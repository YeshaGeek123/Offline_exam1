<?php

namespace App\Services;

class NameService {
    public function breakdownName($name)
    {
        $parts = explode(" ", $name);
        
        if(count($parts) > 1) {
            $data['last_name'] = array_pop($parts);
            $data['first_name'] = implode(" ", $parts);
        }
        else
        {
            $data['first_name'] = $name;
            $data['last_name'] = " ";
        }

        return $data;
    }
}