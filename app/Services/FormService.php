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
                $this->updateFormCombined($args, $u, 'name', 'formBirthdate','Год вашего рождения');
                break;
            case 'formBirthdate':
                $this->updateFormCombined($args,$u, 'birthdate', 'formHeight', 'Рост');
                break;
            case 'formHeight':
                $this->updateFormCombined($args,$u, 'height', 'formWeight', 'Вес');
                break;
            case 'formWeight':
                $this->updateFormCombined($args,$u, 'weight', 'formSize', 'Размер');
                break;
            case 'formSize':
                $this->updateFormCombined($args,$u, 'size', 'formCitizenship', 'Гражданство');
                break;
            case 'formCitizenship':
                $this->updateFormCombined($args,$u, 'citizenship', 'formVisa', 'Наличие визы');
                break;
            case 'formVisa':
                $this->updateFormCombined($args,$u, 'visa', 'formTour_date', 'Желаемая дата тура');
                break;
            case 'formTour_date':
                $this->updateFormCombined($args,$u, 'tour_date', 'formCountries', 'В каких странах был опыт');
                break;
            case 'formCountries':
                $this->updateFormCombined($args,$u, 'countries', 'formContact', 'Рабочий номер телефона/логин');
                break;
            case 'formContact':
                $this->updateFormCombined($args,$u, 'contact', 'formAnal_sex', 'Анальный секс', true);
                break;
            case 'formAnal_sex':
                $this->updateFormCombined($args,$u, 'anal_sex', 'formCum_in_mouth', 'Окончание в рот', true, false, true);
                break;
            case 'formCum_in_mouth':
                $this->updateFormCombined($args,$u, 'cum_in_mouth', 'formSwallowing', 'Проглатывание', true, false, true);
                break;
            case 'formSwallowing':
                $this->updateFormCombined($args,$u, 'swallowing', 'formСum_on_face', 'Окончание на лицо', true, false, true);
                break;
            case 'formСum_on_face':
                $this->updateFormCombined($args,$u, 'cum_on_face', 'formСum_on_body', 'Окончание на тело', true, false, true);
                break;
            case 'formСum_on_body':
                $this->updateFormCombined($args,$u, 'cum_on_body', 'formBlowjob_without_a_condom', 'Минет без презерватива', true, false, true);
                break;
            case 'formBlowjob_without_a_condom':
                $this->updateFormCombined($args,$u, 'blowjob_without_a_condom', 'formDeep_throat', 'Глубокая глотка', true, false, true);
                break;
            case 'formDeep_throat':
                $this->updateFormCombined($args,$u, 'deep_throat', 'formFrench_kiss', 'Французский поцелуй', true, false, true);
                break;
            case 'formFrench_kiss':
                $this->updateFormCombined($args,$u, 'french_kiss', 'formFisting', 'Фистинг', true, false, true);
                break;
            case 'formFisting':
                $this->updateFormCombined($args,$u, 'fisting', 'formRimming', 'Римминг', true, false, true);
                break;
            case 'formRimming':
                $this->updateFormCombined($args,$u, 'rimming', 'formRimming_you', 'Римминг тебе', true, false, true);
                break;
            case 'formRimming_you':
                $this->updateFormCombined($args,$u, 'rimming_you', 'formFootjob', 'Футфетиш', true, false, true);
                break;
            case 'formFootjob':
                $this->updateFormCombined($args,$u, 'footjob', 'formGolden_shower', 'Золотой дождь', true, false, true);
                break;
            case 'formGolden_shower':
                $this->updateFormCombined($args,$u, 'golden_shower', 'formLight_domination', 'Легкая доминация', true, false, true);
                break;
            case 'formLight_domination':
                $this->updateFormCombined($args,$u, 'light_domination', 'formHard_domination', 'Жесткая доминация', true, false, true);
                break;
            case 'formHard_domination':
                $this->updateFormCombined($args,$u, 'hard_domination', 'formAre_you_a_slave', 'Ты рабыня', true, false, true);
                break;
            case 'formAre_you_a_slave':
                $this->updateFormCombined($args,$u, 'are_you_a_slave', 'formMarried_couple', 'Семейная пара', true, false, true);
                break;
            case 'formMarried_couple':
                $this->updateFormCombined($args,$u, 'married_couple', 'formGroup_sex', 'Групповой секс', true, false, true);
                break;
            case 'formGroup_sex':
                $this->updateFormCombined($args,$u, 'group_sex', 'formRole_playing_games', 'Ролевые игры', true, false, true);
                break;
            case 'formRole_playing_games':
                $this->updateFormCombined($args,$u, 'role_playing_games', 'formProstate_massage', 'Массаж простаты', true, false, true);
                break;
            case 'formProstate_massage':
                $this->updateFormCombined($args,$u, 'prostate_massage', 'formLicking_testicles', 'Лизание яичек', true, false, true);
                break;
            case 'formLicking_testicles':
                $this->updateFormCombined($args,$u, 'licking_testicles', 'formNormal_relax_massage', 'Обычный расслабляющий массаж тела ему', true, false, true);
                break;
            case 'formNormal_relax_massage':
                $this->updateFormCombined($args,$u, 'normal_relax_massage', 'formStriptease', 'Стриптиз', true, false, true);
                break;
            case 'formStriptease':
                $this->updateFormCombined($args,$u, 'striptease', 'formPortfolio', 'Спасибо, что вы заполнили анкету <3' . "\n" . '- Первый этап выполнен, остался последний', false, true, false);
                break;
            case 'formPortfolio':
                $this->uploadToPortfolio();
                break;
        }
    }

    private function updateFormCombined($args, $u, $field, $status, $text, $actionStart = false, $actionLast = false, $action = false)
    {
        DB::transaction(function () use($args, $u, $field, $status, $actionStart, $actionLast, $action) {
            $f = Form::firstOrNew(["user_id" => $u->id]);

            if ($actionStart) {
                $f->{$field} = $args['text'];
            } elseif ($actionLast || $action) {
                $f->{$field} = answerToBoolean($actionLast ? $args['data'] : $args['data']);
            } else {
                $f->{$field} = $args['text'];
            }

            $f->save();

            $u->status = $status;
            $u->save();
        });

        deleteMessage(createDeleteMessageData($u->chatid, $args['message_id']));

        if ($actionStart) {
            editMessage(createEditMessageData($u->chatid, $u->bot_messageid , $text, $this->keyboardsService->answer()));
        } elseif ($actionLast) {
            editMessage(createEditMessageData($u->chatid, $u->bot_messageid , $text));
            $additionalText = '- Отправь до 4 фотографий из последнего фотосета' . "\n" . '- 2 актуальных селфи' . "\n" . '- 1 видео';
            sendMessage(createMessageData($u->chatid, $additionalText, $this->keyboardsService->portfolio()));
        } else {
            editMessage(createEditMessageData($u->chatid, $u->bot_messageid , $text));
        }
    }

    private function uploadToPortfolio()
    {

    }
}
