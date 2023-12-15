<?php

namespace App\Services;

use App\Models\Form;
use Illuminate\Support\Facades\DB;

class FormService {
    public function __construct(private KeyboardsService $keyboardsService)
    {
    }

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
                $this->updateForm($args,$u, 'citizenship', 'formVisa', 'Наличие визы');
                break;
            case 'formVisa':
                $this->updateForm($args,$u, 'visa', 'formTour_date', 'Желаемая дата тура');
                break;
            case 'formTour_date':
                $this->updateForm($args,$u, 'tour_date', 'formCountries', 'В каких странах был опыт');
                break;
            case 'formCountries':
                $this->updateForm($args,$u, 'countries', 'formContact', 'Рабочий номер телефона/логин');
                break;
            case 'formContact':
                $this->updateFormWithActionStart($args,$u, 'contact', 'formAnal_sex', 'Анальный секс');
                break;
            case 'formAnal_sex':
                $this->updateFormWithAction($args,$u, 'anal_sex', 'formCum_in_mouth', 'Окончание в рот');
                break;
            case 'formCum_in_mouth':
                $this->updateFormWithAction($args,$u, 'cum_in_mouth', 'formSwallowing', 'Проглатывание');
                break;
            case 'formSwallowing':
                $this->updateFormWithAction($args,$u, 'swallowing', 'formСum_on_face', 'Окончание на лицо');
                break;
            case 'formСum_on_face':
                $this->updateFormWithAction($args,$u, 'cum_on_face', 'formСum_on_body', 'Окончание на тело');
                break;
            case 'formСum_on_body':
                $this->updateFormWithAction($args,$u, 'cum_on_body', 'formBlowjob_without_a_condom', 'Минет без презерватива');
                break;
            case 'formBlowjob_without_a_condom':
                $this->updateFormWithAction($args,$u, 'blowjob_without_a_condom', 'formDeep_throat', 'Глубокая глотка');
                break;
            case 'formDeep_throat':
                $this->updateFormWithAction($args,$u, 'deep_throat', 'formFrench_kiss', 'Французский поцелуй');
                break;
            case 'formFrench_kiss':
                $this->updateFormWithAction($args,$u, 'french_kiss', 'formFisting', 'Фистинг');
                break;
            case 'formFisting':
                $this->updateFormWithAction($args,$u, 'fisting', 'formRimming', 'Римминг');
                break;
            case 'formRimming':
                $this->updateFormWithAction($args,$u, 'rimming', 'formRimming_you', 'Римминг тебе');
                break;
            case 'formRimming_you':
                $this->updateFormWithAction($args,$u, 'rimming_you', 'formFootjob', 'Футфетиш');
                break;
            case 'formFootjob':
                $this->updateFormWithAction($args,$u, 'footjob', 'formGolden_shower', 'Золотой дождь');
                break;
            case 'formGolden_shower':
                $this->updateFormWithAction($args,$u, 'golden_shower', 'formLight_domination', 'Легкая доминация');
                break;
            case 'formLight_domination':
                $this->updateFormWithAction($args,$u, 'light_domination', 'formHard_domination', 'Жесткая доминация');
                break;
            case 'formHard_domination':
                $this->updateFormWithAction($args,$u, 'hard_domination', 'formAre_you_a_slave', 'Ты рабыня');
                break;
            case 'formAre_you_a_slave':
                $this->updateFormWithAction($args,$u, 'are_you_a_slave', 'formMarried_couple', 'Семейная пара');
                break;
            case 'formMarried_couple':
                $this->updateFormWithAction($args,$u, 'married_couple', 'formGroup_sex', 'Групповой секс');
                break;
            case 'formGroup_sex':
                $this->updateFormWithAction($args,$u, 'group_sex', 'formRole_playing_games', 'Ролевые игры');
                break;
            case 'formRole_playing_games':
                $this->updateFormWithAction($args,$u, 'role_playing_games', 'formProstate_massage', 'Массаж простаты');
                break;
            case 'formProstate_massage':
                $this->updateFormWithAction($args,$u, 'prostate_massage', 'formLicking_testicles', 'Лизание яичек');
                break;
            case 'formLicking_testicles':
                $this->updateFormWithAction($args,$u, 'licking_testicles', 'formNormal_relax_massage', 'Обычный расслабляющий массаж тела ему');
                break;
            case 'formNormal_relax_massage':
                $this->updateFormWithAction($args,$u, 'normal_relax_massage', 'formStriptease', 'Стриптиз');
                break;
            case 'formStriptease':
                $this->updateFormWithActionLast($args,$u, 'striptease', 'formPortfolio', 'Спасибо, что вы заполнили анкету <3' . "\n" . '- Первый этап выполнен, остался последний');
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

    private function updateFormWithActionStart($args, $u, $field, $status, $text)
    {
        DB::transaction(function () use($args, $u, $field, $status) {
            $f = $u->form;
            $f->{$field} = $args['text'];
            $f->save();

            $u->status = $status;
            $u->save();
        });
        editMessage(createEditMessageData($u->chatid, $u->bot_messageid , $text, $this->keyboardsService->answer()));
    }

    private function updateFormWithAction($args, $u, $field, $status, $text)
    {
        DB::transaction(function () use($args, $u, $field, $status) {
            $f = $u->form;
            $f->{$field} = answerToBoolean($args['data']);
            $f->save();

            $u->status = $status;
            $u->save();
        });
        editMessage(createEditMessageData($u->chatid, $u->bot_messageid , $text, $this->keyboardsService->answer()));
    }

    private function updateFormWithActionLast($args, $u, $field, $status, $text)
    {
        DB::transaction(function () use($args, $u, $field, $status) {
            $f = $u->form;
            $f->{$field} = answerToBoolean($args['data']);
            $f->save();

            $u->status = $status;
            $u->save();
        });
        editMessage(createEditMessageData($u->chatid, $u->bot_messageid , $text));
        $text = '- Отправь до 4 фотографий из последнего фотосета' . "\n" . '- 2 актуальных селфи' . "\n" . '- 1 видео';
        sendMessage(createMessageData($u->chatid, $text, $this->keyboardsService->portfolio()));
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
