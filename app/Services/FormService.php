<?php

namespace App\Services;

use App\Models\Form;
use Illuminate\Support\Facades\DB;

class FormService {
    public function fetchForm($args, $u)
    {
        switch ($u->status) {
            case 'formStarted':
                $this->started($args, $u, 'Год вашего рождения');
                break;
            case 'formBirthdate':
                $this->updateForm($args,$u, 'birthdate', 'formHeight', 'Рост');
                break;
            case 'formHeight':
                $this->updateForm($args,$u, 'height', 'formWeight', 'Вес');
                break;
            case 'formWeight':
                $this->updateForm($args,$u, 'weight', 'formSize', 'Размер');
                break;
            case 'formSize':
                $this->updateForm($args,$u, 'size', 'formCitizenship', 'Гражданство');
                break;
            case 'formCitizenship':
                $this->updateForm($args,$u, 'visa', 'formTour_date', 'Наличие визы');
                break;
            case 'formTour_date':
                $this->updateForm($args,$u, 'tour_date', 'formCountries', 'Желаемая дата тура');
                break;
            case 'formCountries':
                $this->updateForm($args,$u, 'countries', 'formContact', 'В каких странах был опыт');
                break;
            case 'formContact':
                $this->updateForm($args,$u, 'contact', 'formAnal_sex', 'Рабочий номер телефона/логин');
                break;
        }
    }

    private function updateForm($args, $u, $field, $status, $text)
    {
        DB::transaction(function () use($args, $u, $field, $status) {
            $f = $u->form;
            $f->{$field} = $args['text'];
            $f->save();

            $u->status = $status;
            $u->save();
        });
        deleteMessage(createDeleteMessageData($u->chatid, $args['message_id']));
        editMessage(createEditMessageData($u->chatid, $u->bot_messageid , $text));
    }

    private function started($args, $u, $text)
    {
        DB::transaction(function () use($args, $u, $text) {
            $f = Form::firstOrNew(['user_id' => $u->id]);
            $f->name = $args['text'];
            $f->save();

            deleteMessage(createDeleteMessageData($u->chatid, $args['message_id']));
            editMessage(createEditMessageData($u->chatid, $u->bot_messageid , $text));

            $u->status = "formBirthdate";
            $u->save();
        });
    }
}
