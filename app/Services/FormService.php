<?php

namespace App\Services;

use App\Models\Form;
use Illuminate\Support\Facades\DB;

class FormService {
    public function fetchForm($args, $u)
    {
        switch ($u->status) {
            case 'formStarted':
                $this->started($args, $u);
                break;
            case 'formBirthdate':
                $this->updateForm($args,$u, 'birthdate', 'formHeight');
                break;
            case 'formHeight':
                $this->updateForm($args,$u, 'height', 'formWeight');
                break;
            case 'formWeight':
                $this->updateForm($args,$u, 'weight', 'formSize');
                break;
            case 'formSize':
                $this->updateForm($args,$u, 'size', 'formCitizenship');
                break;
            case 'formCitizenship':
                $this->updateForm($args,$u, 'visa', 'formTour_date');
                break;
            case 'formTour_date':
                $this->updateForm($args,$u, 'tour_date', 'formCountries');
                break;
            case 'formCountries':
                $this->updateForm($args,$u, 'countries', 'formContact');
                break;
            case 'formContact':
                $this->updateForm($args,$u, 'contact', 'formAnal_sex');
                break;
        }
    }

    private function updateForm($args, $u, $field, $status)
    {
        DB::transaction(function () use($args, $u, $field, $status) {
            $f = $u->form;
            $f->{$field} = $args['text'];
            $f->save();

            $u->status = $status;
            $u->save();
        });
    }

    private function started($args, $u)
    {
        DB::transaction(function () use($args, $u) {
           $f = Form::firstOrNew(['user_id' => $u->id]);
           $f->name = $args['text'];
           $f->save();

           $u->status = "formBirthdate";
           $u->save();
        });
    }
}
