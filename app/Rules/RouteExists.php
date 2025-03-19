<?php

namespace App\Rules;  

use Closure;  
use Illuminate\Contracts\Validation\ValidationRule;  
use Illuminate\Support\Facades\Route;  

class RouteExists implements ValidationRule  
{  
    /**  
     * Run the validation rule.  
     *  
     * @param  string  $attribute  
     * @param  mixed  $value  
     * @param  Closure  $fail  
     * @return void  
     */  
    public function validate(string $attribute, mixed $value, Closure $fail): void  
    {  
        // Memeriksa apakah rute dengan nama yang diberikan ada  
        if (!Route::has($value)) {  
            $fail("The route with the name '{$value}' does not exist.");  
        }  
    }  
}