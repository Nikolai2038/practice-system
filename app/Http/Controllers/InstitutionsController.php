<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\FormFieldInput;
use App\Http\Functions;
use App\Models\Institution;
use App\Models\InstitutionType;
use App\Models\User;
use Illuminate\Http\Request;

class InstitutionsController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        $institutions = Institution::orderBy('id')->paginate(5);
        return response()->view('institutions.index', ['total_user' => $total_user, 'institutions' => $institutions])->header('Content-Type', 'text/html');
    }

    public function create(Request $request)
    {
        $total_user = Functions::getTotalUser();

        $form_field_keys = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_FULL_NAME,
            FormFieldInput::FIELD_KEY_INSTITUTION_SHORT_NAME,
            FormFieldInput::FIELD_KEY_INSTITUTION_ADDRESS,
            FormFieldInput::FIELD_KEY_INSTITUTION_TYPE_ID,
        );
        $form_field_defaults = null;
        $fields_options_values = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_TYPE_ID => FormFieldInput::generateOneFieldArray(InstitutionType::all('id as value')->toArray()),
        );
        $fields_options_values_guarded = null;
        $fields_options_names = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_TYPE_ID => FormFieldInput::generateOneFieldArray(InstitutionType::all('name as value')->toArray()),
        );
        $html_fields = FormFieldInput::generateHtmlFields($request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded, $fields_options_names);

        if ($request->isMethod('get'))
        {
            return response()->view('institutions.create', ['html_fields' => $html_fields, 'total_user' => $total_user])->header('Content-Type', 'text/html');
        }
        else if ($request->isMethod('post'))
        {
            $errors = array();

            FormFieldInput::checkInputs($errors, $request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded);

            if (count($errors) == 0)
            {
                $institution = new Institution;
                $institution->full_name = $request->input(FormFieldInput::FIELD_KEY_INSTITUTION_FULL_NAME);
                $institution->short_name = $request->input(FormFieldInput::FIELD_KEY_INSTITUTION_SHORT_NAME);
                $institution->address = $request->input(FormFieldInput::FIELD_KEY_INSTITUTION_ADDRESS);
                $institution->institution_type()->associate(InstitutionType::find($request->input(FormFieldInput::FIELD_KEY_INSTITUTION_TYPE_ID)));
                $institution->save();
                return redirect()->route('administration_institutions')->header('Content-Type', 'text/html');
            }
            else
            {
                return response()
                    ->view('institutions.create', [
                        'html_fields' => $html_fields,
                        'errors' => $errors,
                        'total_user' => $total_user
                    ])
                    ->header('Content-Type', 'text/html');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        $total_user = Functions::getTotalUser();

        $institution = Institution::find($id);

        $form_field_keys = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_FULL_NAME,
            FormFieldInput::FIELD_KEY_INSTITUTION_SHORT_NAME,
            FormFieldInput::FIELD_KEY_INSTITUTION_ADDRESS,
            FormFieldInput::FIELD_KEY_INSTITUTION_TYPE_ID,
        );
        $form_field_defaults = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_FULL_NAME => $institution->full_name,
            FormFieldInput::FIELD_KEY_INSTITUTION_SHORT_NAME => $institution->short_name,
            FormFieldInput::FIELD_KEY_INSTITUTION_ADDRESS => $institution->address,
            FormFieldInput::FIELD_KEY_INSTITUTION_TYPE_ID => $institution->institution_type->id,
        );
        $fields_options_values = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_TYPE_ID => FormFieldInput::generateOneFieldArray(InstitutionType::all('id as value')->toArray()),
        );
        $fields_options_values_guarded = null;
        $fields_options_names = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_TYPE_ID => FormFieldInput::generateOneFieldArray(InstitutionType::all('name as value')->toArray()),
        );
        $html_fields = FormFieldInput::generateHtmlFields($request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded, $fields_options_names);

        $notification = null;
        $errors = array();

        if ($request->isMethod('post'))
        {
            FormFieldInput::checkInputs($errors, $request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded);

            if (count($errors) == 0)
            {
                $full_name = $request->input(FormFieldInput::FIELD_KEY_INSTITUTION_FULL_NAME);
                if (($institution->full_name != $full_name) && ($full_name != null) && (Institution::where('full_name', '=', $full_name)->first() != null))
                {
                    $errors[] = 'Уже существует предприятие / учебное заведение с таким полным названием!';
                }
                if (count($errors) == 0)
                {
                    try
                    {
                        $institution->full_name = $full_name;
                        $institution->short_name = $request->input(FormFieldInput::FIELD_KEY_INSTITUTION_SHORT_NAME);
                        $institution->address = $request->input(FormFieldInput::FIELD_KEY_INSTITUTION_ADDRESS);
                        $institution->institution_type()->associate(InstitutionType::find($request->input(FormFieldInput::FIELD_KEY_INSTITUTION_TYPE_ID)));
                        $institution->save();
                        $notification = 'Предприятие / Учебное заведение успешно изменено!';
                    }
                    catch (\Exception $exception)
                    {
                        $errors[] = $exception->getMessage();
                    }
                }
            }
        }
        return response()
            ->view('institutions.edit', [
                'html_fields' => $html_fields,
                'notification' => $notification,
                'errors' => $errors,
                'total_user' => $total_user
            ])
            ->header('Content-Type', 'text/html');
    }

    public function delete(Request $request, $id)
    {
        $total_user = Functions::getTotalUser();
        $institution = Institution::find($id);
        if ($request->isMethod('get'))
        {
            return response()->view('institutions.delete', ['total_user' => $total_user, 'institution' => $institution])->header('Content-Type', 'text/html');
        }
        else if ($request->isMethod('post'))
        {
            $institution->delete();
            return redirect()->route('administration_institutions')->header('Content-Type', 'text/html');
        }
    }
}
