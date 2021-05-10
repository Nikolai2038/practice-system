<?php

namespace App\Http;

use App\Models\InstitutionType;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;

class FormFieldInput
{
    public $input_key;
    public $name;
    public $is_required;
    public $min_length;
    public $max_length;
    public $field_type;

    private const FIELD_TYPE_INPUT_TEXT = 0;
    private const FIELD_TYPE_INPUT_PASSWORD = 1;
    private const FIELD_TYPE_SELECT = 2;

    public function __construct($input_key, $name, $is_required, $min_length, $max_length, $field_type = self::FIELD_TYPE_INPUT_TEXT)
    {
        $this->input_key = $input_key;
        $this->name = $name;
        $this->is_required = $is_required;
        $this->min_length = $min_length;
        $this->max_length = $max_length;
        $this->field_type = $field_type;
    }

    public const FIELD_KEY_LOGIN = 'login';
    public const FIELD_KEY_EMAIL = 'email';
    public const FIELD_KEY_PHONE = 'phone';
    public const FIELD_KEY_FIRST_NAME = 'first_name';
    public const FIELD_KEY_SECOND_NAME = 'second_name';
    public const FIELD_KEY_THIRD_NAME = 'third_name';
    public const FIELD_KEY_INSTITUTION_ID = 'institution_id';
    public const FIELD_KEY_PASSWORD = 'password';
    public const FIELD_KEY_PASSWORD_CONFIRMED = 'password_confirmed';

    public const FIELD_KEY_ROLE_ID = 'role_id';

    public const FIELD_KEY_INSTITUTION_FULL_NAME = 'institution_full_name';
    public const FIELD_KEY_INSTITUTION_SHORT_NAME = 'institution_short_name';
    public const FIELD_KEY_INSTITUTION_ADDRESS = 'institution_address';
    public const FIELD_KEY_INSTITUTION_TYPE_ID = 'institution_type_id';

    public const FIELD_KEY_WHO_CAN_SEE_EMAIL = 'who_can_see_email';
    public const FIELD_KEY_WHO_CAN_SEE_PHONE = 'who_can_see_phone';
    public const FIELD_KEY_NEW_PASSWORD = 'new_password';
    public const FIELD_KEY_NEW_PASSWORD_CONFIRMED = 'new_password_confirmed';
    public const FIELD_KEY_TOTAL_PASSWORD = 'total_password';

    /**
     * @return FormFieldInput[]
     */
    public static function getFormFieldInputsSettings()
    {
        return array(
            self::FIELD_KEY_LOGIN                   => new FormFieldInput(self::FIELD_KEY_LOGIN,
                'Логин', true, 4, 64),
            self::FIELD_KEY_EMAIL                   => new FormFieldInput(self::FIELD_KEY_EMAIL,
                'Email', false, 4, 64),
            self::FIELD_KEY_PHONE                   => new FormFieldInput(self::FIELD_KEY_PHONE,
                'Телефон', false, 4, 64),
            self::FIELD_KEY_FIRST_NAME              => new FormFieldInput(self::FIELD_KEY_FIRST_NAME,
                'Имя', true, 4, 64),
            self::FIELD_KEY_SECOND_NAME             => new FormFieldInput(self::FIELD_KEY_SECOND_NAME,
                'Фамилия', true, 4, 64),
            self::FIELD_KEY_THIRD_NAME              => new FormFieldInput(self::FIELD_KEY_THIRD_NAME,
                'Отчество', false, 4, 64),
            self::FIELD_KEY_INSTITUTION_ID      => new FormFieldInput(self::FIELD_KEY_INSTITUTION_ID,
                'Предприятие / Учебное заведение', false, null, null, self::FIELD_TYPE_SELECT),
            self::FIELD_KEY_PASSWORD                => new FormFieldInput(self::FIELD_KEY_PASSWORD,
                'Пароль', true, 4, 128, self::FIELD_TYPE_INPUT_PASSWORD),
            self::FIELD_KEY_PASSWORD_CONFIRMED      => new FormFieldInput(self::FIELD_KEY_PASSWORD_CONFIRMED,
                'Подтверждение пароля', true, 4, 128, self::FIELD_TYPE_INPUT_PASSWORD),

            self::FIELD_KEY_ROLE_ID   => new FormFieldInput(self::FIELD_KEY_ROLE_ID,
                'Роль', true, null, null, self::FIELD_TYPE_SELECT),

            self::FIELD_KEY_INSTITUTION_FULL_NAME   => new FormFieldInput(self::FIELD_KEY_INSTITUTION_FULL_NAME,
                'Полное название', true, 4, 64),
            self::FIELD_KEY_INSTITUTION_SHORT_NAME   => new FormFieldInput(self::FIELD_KEY_INSTITUTION_SHORT_NAME,
                'Краткое название', false, 4, 64),
            self::FIELD_KEY_INSTITUTION_ADDRESS   => new FormFieldInput(self::FIELD_KEY_INSTITUTION_ADDRESS,
                'Адрес', true, 4, 64),
            self::FIELD_KEY_INSTITUTION_TYPE_ID   => new FormFieldInput(self::FIELD_KEY_INSTITUTION_TYPE_ID,
                'Тип', true, null, null, self::FIELD_TYPE_SELECT),

            self::FIELD_KEY_WHO_CAN_SEE_EMAIL                => new FormFieldInput(self::FIELD_KEY_WHO_CAN_SEE_EMAIL,
                'Кто может видеть мой email', true, null, null, self::FIELD_TYPE_SELECT),
            self::FIELD_KEY_WHO_CAN_SEE_PHONE                => new FormFieldInput(self::FIELD_KEY_WHO_CAN_SEE_PHONE,
                'Кто может видеть мой телефон', true, null, null, self::FIELD_TYPE_SELECT),
            self::FIELD_KEY_NEW_PASSWORD                => new FormFieldInput(self::FIELD_KEY_NEW_PASSWORD,
                'Новый пароль', false, 4, 128, self::FIELD_TYPE_INPUT_PASSWORD),
            self::FIELD_KEY_NEW_PASSWORD_CONFIRMED      => new FormFieldInput(self::FIELD_KEY_NEW_PASSWORD_CONFIRMED,
                'Подтверждение нового пароля', false, 4, 128, self::FIELD_TYPE_INPUT_PASSWORD),
            self::FIELD_KEY_TOTAL_PASSWORD                => new FormFieldInput(self::FIELD_KEY_TOTAL_PASSWORD,
                'Текущий пароль', true, 4, 128, self::FIELD_TYPE_INPUT_PASSWORD),
        );
    }

    public static function generateOneFieldArray($array)
    {
        $new_array = array();
        foreach ($array as $element)
        {
            $new_array[] = $element['value'];
        }
        return $new_array;
    }

    private function generateHtmlField($field_value, $field_options_values, $field_options_values_guarded, $field_options_names)
    {
        $result = "";
        if(($this->field_type == self::FIELD_TYPE_INPUT_TEXT) || ($this->field_type == self::FIELD_TYPE_INPUT_PASSWORD))
        {
            $result .= '<div class="field">';
            $result .= '<input';
            if ($this->field_type == self::FIELD_TYPE_INPUT_PASSWORD)
            {
                $result .= ' type="password"';
            }
            else
            {
                $result .= ' type="text"';
            }
            $result .= ' placeholder=" " name="' . $this->input_key . '" id="' . $this->input_key . '"';
            if ($field_value != '')
            {
                $result .= ' value="' . ($field_value) . '"';
            }
            if ($this->is_required)
            {
                $result .= ' required';
            }
            $result .= ' />';
            $result .= '<label for="' . $this->input_key . '">' . $this->name;
            if ($this->is_required)
            {
                $result .= ' *';
            }
            $result .= '</label>';
        }
        else if($this->field_type == self::FIELD_TYPE_SELECT)
        {
            $result .= '<div class="field_not_input">';
            $result .= '<label for="' . $this->input_key . '">' . $this->name;
            if ($this->is_required)
            {
                $result .= ' *';
            }
            $result .= ': ';
            $result .= '</label>';
            $result .= '<select name="'.$this->input_key.'">';
            if($this->is_required == false) {
                $result .= '<option value="">';
                $result .= 'Не выбрано';
                $result .= '</option >';
            }
            $field_options_count = count($field_options_values);
            for($i = 0; $i < $field_options_count; $i++)
            {
                $field_option_value = $field_options_values[$i];
                $result .= '<option value ='.$field_option_value;
                if($field_option_value == $field_value) // если выбрана эта опция
                {
                    $result .= ' selected';
                }
                if(($field_options_values_guarded != null) && in_array($field_option_value, $field_options_values_guarded)) // если опция запрещена
                {
                    $result .= ' disabled';
                }
                $result .= '>';
                $result .= $field_options_names[$i];
                $result .= '</option >';
            }
            $result .= '</select>';
        }
        $result .= '</div>';
        return $result;
    }

    public static function generateHtmlFields(Request $request, $form_field_keys, $form_field_defaults = null, $fields_options_values = null, $fields_options_values_guarded = null, $fields_options_names = null)
    {
        $result = "";
        $form_fields_data = self::getFormFieldInputsSettings();
        $i = 0;
        foreach ($form_field_keys as $form_field_key)
        {
            $form_field_input = $form_fields_data[$form_field_key];

            $field_value = htmlentities( $request->input($form_field_input->input_key) ?? '');
            if($request->isMethod('get'))
            {
                if($field_value == null)
                {
                    $field_value = $form_field_defaults[$form_field_input->input_key] ?? '';
                }
            }
            $field_options_values = $fields_options_values[$form_field_input->input_key] ?? null;
            $field_options_names = $fields_options_names[$form_field_input->input_key] ?? null;
            $field_options_values_guarded = $fields_options_values_guarded[$form_field_input->input_key] ?? null;

            $result .= $form_field_input->generateHtmlField($field_value, $field_options_values, $field_options_values_guarded, $field_options_names);
        }
        return $result;
    }

    /** Функция проверки поля ввода
     * @param Request $request
     * @param $input_key
     * @param null $errors
     */
    private function checkInput(&$errors = null, $field_value, $field_options_values, $field_options_values_guarded)
    {
        if($field_value == "")
        {
            $field_value = null;
        }
        if(($this->field_type == self::FIELD_TYPE_INPUT_TEXT) || ($this->field_type == self::FIELD_TYPE_INPUT_PASSWORD))
        {
            $text_length = strlen($field_value);

            if ($this->is_required || $text_length > 0)
            {
                if (($text_length < $this->min_length) || ($text_length > $this->max_length))
                {
                    $error = 'Поле "' . $this->name . '" должно быть в диапазоне от ' . $this->min_length . ' до ' . $this->max_length . ' символов';
                    if($this->is_required == false)
                    {
                        $error .= ', либо быть не заполненным вообще';
                    }
                    $error .= '!';
                    $errors[] = $error;
                }
            }
            else if ($this->is_required && $text_length == 0)
            {
                $errors[] = 'Поле "' . $this->name . '" должно быть заполнено!';
            }
        }
        else
        {
            if($this->is_required || $field_value != null)
            {
                if ((($field_options_values != null) && (in_array($field_value, $field_options_values) == false)) || (($field_options_values_guarded != null) && (in_array($field_value, $field_options_values_guarded) == true)))
                {
                    $errors[] = 'Поле "' . $this->name . '" имеет недопустимое значение! Возможно, у вас недостаточно прав.';
                }
            }
        }
    }

    public static function checkInputs(&$errors = null, Request $request, $form_field_keys, $form_field_defaults = null, $fields_options_values = null, $fields_options_values_guarded = null)
    {
        $form_fields_data = self::getFormFieldInputsSettings();
        foreach ($form_field_keys as $form_field_key)
        {
            $form_field_input = $form_fields_data[$form_field_key];

            $field_value = htmlentities( $request->input($form_field_input->input_key) ?? '');
            if($request->isMethod('get'))
            {
                if($field_value == null)
                {
                    $field_value = $form_field_defaults[$form_field_input->input_key] ?? '';
                }
            }
            $field_options_values = $fields_options_values[$form_field_input->input_key] ?? null;
            $field_options_values_guarded = $fields_options_values_guarded[$form_field_input->input_key] ?? null;

            $form_field_input->checkInput($errors, $field_value, $field_options_values, $field_options_values_guarded);
        }
    }

    public static function checkInputPasswordConfirmed(Request $request, &$errors = null)
    {
        $password = $request->input(self::FIELD_KEY_PASSWORD);
        $password_confirmed = $request->input(self::FIELD_KEY_PASSWORD_CONFIRMED);
        if($password != $password_confirmed)
        {
            $errors[] = 'Пароль не совпадает с подтвержджением пароля!';
        }
    }

    public static function checkInputNewPasswordConfirmed(Request $request, &$errors = null)
    {
        $new_password = $request->input(self::FIELD_KEY_NEW_PASSWORD);
        $new_password_confirmed = $request->input(self::FIELD_KEY_NEW_PASSWORD_CONFIRMED);
        if($new_password != null)
        {
            if ($new_password != $new_password_confirmed)
            {
                $errors[] = 'Новый пароль не совпадает с подтвержджением нового пароля!';
            }
        }
    }

    public static function checkInputIsLoginOrPasswordWrong(Request $request, &$errors = null)
    {
        $password_sha512 = hash('sha512', $request->input(self::FIELD_KEY_PASSWORD));
        $user_found = User::where([
            ['login', '=', $request->input(self::FIELD_KEY_LOGIN)],
            ['password_sha512', '=', $password_sha512],
        ])->first();

        if ($user_found == null)
        {
            $errors[] = 'Неверный логин или пароль!';
        }

        return $user_found;
    }

    public static function checkInputIsLoginAlreadyExists(Request $request, &$errors = null)
    {
        $login = $request->input(self::FIELD_KEY_LOGIN);
        if($login != null)
        {
            $user_found = User::where('login', '=', $login)->first();

            if ($user_found != null)
            {
                $errors[] = 'Пользователь с таким логином уже зарегистрирован!';
            }
        }
    }
}
