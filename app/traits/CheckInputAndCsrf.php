<?php

namespace App\Traits;

use App\Libraries\Input;
use App\Libraries\CSRF;

trait CheckInputAndCsrf
{
    // prüfen ob ein Formularfeld inkl. CSRF-Token gesendet wurden
    protected function checkInputAndCsrf()
    {
        return Input::exists() && CSRF::check(Input::get('csrf'));
    }
}