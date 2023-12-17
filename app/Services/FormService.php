<?php

namespace App\Services;

use App\Models\Form;
use App\Models\UserMedia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
                $this->updateFormCombined($args,$u, 'anal_sex', 'formCum_in_mouth', 'Окончание в рот', false, false, true);
                break;
            case 'formCum_in_mouth':
                $this->updateFormCombined($args,$u, 'cum_in_mouth', 'formSwallowing', 'Проглатывание', false, false, true);
                break;
            case 'formSwallowing':
                $this->updateFormCombined($args,$u, 'swallowing', 'formСum_on_face', 'Окончание на лицо', false, false, true);
                break;
            case 'formСum_on_face':
                $this->updateFormCombined($args,$u, 'cum_on_face', 'formСum_on_body', 'Окончание на тело', false, false, true);
                break;
            case 'formСum_on_body':
                $this->updateFormCombined($args,$u, 'cum_on_body', 'formBlowjob_without_a_condom', 'Минет без презерватива', false, false, true);
                break;
            case 'formBlowjob_without_a_condom':
                $this->updateFormCombined($args,$u, 'blowjob_without_a_condom', 'formDeep_throat', 'Глубокая глотка', false, false, true);
                break;
            case 'formDeep_throat':
                $this->updateFormCombined($args,$u, 'deep_throat', 'formFrench_kiss', 'Французский поцелуй', false, false, true);
                break;
            case 'formFrench_kiss':
                $this->updateFormCombined($args,$u, 'french_kiss', 'formFisting', 'Фистинг', false, false, true);
                break;
            case 'formFisting':
                $this->updateFormCombined($args,$u, 'fisting', 'formRimming', 'Римминг', false, false, true);
                break;
            case 'formRimming':
                $this->updateFormCombined($args,$u, 'rimming', 'formRimming_you', 'Римминг тебе', false, false, true);
                break;
            case 'formRimming_you':
                $this->updateFormCombined($args,$u, 'rimming_you', 'formFootjob', 'Футфетиш', false, false, true);
                break;
            case 'formFootjob':
                $this->updateFormCombined($args,$u, 'footjob', 'formGolden_shower', 'Золотой дождь', false, false, true);
                break;
            case 'formGolden_shower':
                $this->updateFormCombined($args,$u, 'golden_shower', 'formLight_domination', 'Легкая доминация', false, false, true);
                break;
            case 'formLight_domination':
                $this->updateFormCombined($args,$u, 'light_domination', 'formHard_domination', 'Жесткая доминация', false, false, true);
                break;
            case 'formHard_domination':
                $this->updateFormCombined($args,$u, 'hard_domination', 'formAre_you_a_slave', 'Ты рабыня', false, false, true);
                break;
            case 'formAre_you_a_slave':
                $this->updateFormCombined($args,$u, 'are_you_a_slave', 'formMarried_couple', 'Семейная пара', false, false, true);
                break;
            case 'formMarried_couple':
                $this->updateFormCombined($args,$u, 'married_couple', 'formGroup_sex', 'Групповой секс', false, false, true);
                break;
            case 'formGroup_sex':
                $this->updateFormCombined($args,$u, 'group_sex', 'formRole_playing_games', 'Ролевые игры', false, false, true);
                break;
            case 'formRole_playing_games':
                $this->updateFormCombined($args,$u, 'role_playing_games', 'formProstate_massage', 'Массаж простаты', false, false, true);
                break;
            case 'formProstate_massage':
                $this->updateFormCombined($args,$u, 'prostate_massage', 'formLicking_testicles', 'Лизание яичек', false, false, true);
                break;
            case 'formLicking_testicles':
                $this->updateFormCombined($args,$u, 'licking_testicles', 'formNormal_relax_massage', 'Обычный расслабляющий массаж тела ему', false, false, true);
                break;
            case 'formNormal_relax_massage':
                $this->updateFormCombined($args,$u, 'normal_relax_massage', 'formStriptease', 'Стриптиз', false, false, true);
                break;
            case 'formStriptease':
                $this->updateFormCombined($args,$u, 'striptease', 'formPortfolio', 'Спасибо, что вы заполнили анкету <3' . "\n" . '- Первый этап выполнен, остался последний', false, true, false);
                break;
            case 'formPortfolio':
                $this->uploadToPortfolio($args,$u);
                break;
        }
    }

    private function updateFormCombined($args, $u, $field, $status, $text, $actionStart = false, $actionLast = false, $action = false)
    {
        DB::transaction(function () use($args, $u, $field, $status, $actionStart, $actionLast, $action, $text) {
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


            if(isset($args['message_id'])){
                deleteMessage(createDeleteMessageData($u->chatid, $args['message_id']));
            }

            if ($actionStart) {
                $answerText = '✅ Ваш ответ: '. $args['text'];
                editForTimeMessage($u->chatid, $u->bot_messageid, $answerText, $text, $this->keyboardsService->answer());
            } elseif($action) {
                editMessage(createEditMessageData($u->chatid, $u->bot_messageid , $text, $this->keyboardsService->answer()));
            } elseif ($actionLast) {
                editMessage(createEditMessageData($u->chatid, $u->bot_messageid , $text));
                $additionalText = '- Отправь до 4 фотографий из последнего фотосета' . "\n" . '- 2 актуальных селфи' . "\n" . '- 1 видео';
                sendMessage(createMessageData($u->chatid, $additionalText, $this->keyboardsService->portfolio()));
                $u->bot_messageid = null;
                $u->save();
            } else {
                $answerText = '✅ Ваш ответ: '. $args['text'];
                editForTimeMessage($u->chatid, $u->bot_messageid, $answerText, $text);
            }
        });
    }

    private function uploadToPortfolio($args,$u)
    {
        if(isset($args['photo'])){
            if($u->mediasCount() >= 6) {
                sendMessage(createMessageData($u->chatid, 'Вы загрузили максимальное количество фотографий'));
            } else {
                $f_p = getFilePath(end($args['photo'])['file_id']);
                $f = getFile($f_p);
                $f_n = hash('sha256', Carbon::now() . pathinfo($f_p, PATHINFO_FILENAME)) . '.jpg';
                Storage::disk('s3')->put('future_bot/'.$f_n, $f);
                $u_m = new UserMedia();
                $u_m->url = Storage::disk('s3')->url($f_n);
                $u_m->type = "photo";
                $u_m->user_id = $u->id;
                $u_m->save();
                deleteMessage(createDeleteMessageData($u->chatid, $args['message_id']));
                if(isset($u->bot_messageid)){
                    deleteMessage(createDeleteMessageData($u->chatid, $u->bot_messageid));
                }
                $r = sendMessage(createMessageData($u->chatid, 'Фотография загружена'));
                $u->bot_messageid = $r;
                $u->save();
            }
        }else if(isset($args['video'])){
            if($u->mediasCount('video') >= 1) {
                sendMessage(createMessageData($u->chatid, 'Вы загрузили максимальное количество видео'));
            } else {
                $f_p = getFilePath($args['video']['file_id']);
                $f = getFile($f_p);
                $f_n = hash('sha256', Carbon::now() . pathinfo($f_p, PATHINFO_FILENAME)) . '.mp4';
                Storage::disk('s3')->put('future_bot/'.$f_n, $f);
                $u_m = new UserMedia();
                $u_m->url = Storage::disk('s3')->url($f_n);
                $u_m->type = "video";
                $u_m->user_id = $u->id;
                $u_m->save();
                deleteMessage(createDeleteMessageData($u->chatid, $args['message_id']));
                if(isset($u->bot_messageid)){
                    deleteMessage(createDeleteMessageData($u->chatid, $u->bot_messageid));
                }
                $r = sendMessage(createMessageData($u->chatid, 'Видео загружено'));
                $u->bot_messageid = $r;
                $u->save();
            }
        }
    }

    public function appendForm($args,$u)
    {
        if($u->form->is_posted) {
            editOrSendMessage($u, 'Вы уже отправили анкету, с вами свяжется ТурАгент');
        } else {
            DB::transaction(function() use($args, $u) {
                $u->bot_messageid = null;
                $u->save();
                $u->form->generateNumber();
                sendMediaGroup(createMediaGroupData('-1002133427547', $u->medias()->get()->toArray()));
                sendMessage(createMessageData('-1002133427547', 'Контактная информация: ' . $u->form->contact));
                sendMessage(createMessageData('-1002133427547', $this->createReadyForm($u)));
                $u->form->is_posted = true;
                $u->form->save();
                $text = 'Спасибо, что выбрали Future©' . "\n" . "С вами свяжется ТурАгент для комфортной работы" . "\n" . "Все страны, куда вы можете пройти указаны в памятке для модели" ;
                editOrSendMessage($u, $text, $this->keyboardsService->memo());
            });
        }
    }

    private function createReadyForm($u)
    {
        return 'Порядковый номер: #' . $u->form->number . "\n" . '
1. Имя: ' . $u->form->name . '
2. Возраст: ' . $u->form->birthdate . '
3.1 Рост: ' . $u->form->height . '
3.2 Вес: ' . $u->form->weight . '
3.3 Размер: ' . $u->form->size . '
4. Гражданство: ' . $u->form->citizenship . '
5. Виза: ' . $u->form->visa . '
6. Дата вылета: ' . $u->form->tour_date . '
7. Опыт: ' . $u->form->countries . '

Сервис ' . "\n" . '
8. Анальный секс: '. booleanToAnswer($u->form->anal_sex) . '
9. Окончание в рот: '. booleanToAnswer($u->form->cum_in_mouth) . '
10. Проглатывание: '. booleanToAnswer($u->form->swallowing) . '
11. Окончание на лицо: '. booleanToAnswer($u->form->cum_on_face) . '
12. Окончание на тело: '. booleanToAnswer($u->form->cum_on_body) . '
13. МБР: '. booleanToAnswer($u->form->blowjob_without_a_condom) . '
14. Глубокая глотка: '. booleanToAnswer($u->form->deep_throat) . '
15. Французский поцелуй: '. booleanToAnswer($u->form->french_kiss) . '
16. Фистинг: '. booleanToAnswer($u->form->fisting) . '
17. Римминг: '. booleanToAnswer($u->form->rimming) . '
18. Римминг модели: '. booleanToAnswer($u->form->rimming_you) . '
19. Футфетишь: '. booleanToAnswer($u->form->footjob) . '
20. Золотой дождь: '. booleanToAnswer($u->form->golden_shower) . '
21. Легкая доминация: '. booleanToAnswer($u->form->light_domination) . '
22. Жесткая доминация: '. booleanToAnswer($u->form->hard_domination) . '
23. Рабыня: '. booleanToAnswer($u->form->are_you_a_slave) . '
24. Семейная пара: '. booleanToAnswer($u->form->married_couple) . '
25. Групповой секс: '. booleanToAnswer($u->form->group_sex) . '
26. Ролевые игры: '. booleanToAnswer($u->form->role_playing_games) . '
27. Массаж простаты: '. booleanToAnswer($u->form->prostate_massage) . '
28. Лизание яичек: '. booleanToAnswer($u->form->licking_testicles) . '
29. Обычный массаж: '. booleanToAnswer($u->form->normal_relax_massage) . '
30. Стриптиз: '. booleanToAnswer($u->form->striptease);
    }
}
