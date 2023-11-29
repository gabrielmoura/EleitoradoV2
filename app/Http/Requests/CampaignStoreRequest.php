<?php

namespace App\Http\Requests;

use App\Service\Enum\CampaignOptions;
use Illuminate\Foundation\Http\FormRequest;

//use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class CampaignStoreRequest extends FormRequest
{
    //    use ValidatesMedia;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //        return Gate::allows('create_campaign');
        return true;
    }

    public static function ruleX(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'message' => ['required', 'string'],
            'status' => ['required', 'string', 'in:'.implode(',', array_values(CampaignOptions::STATUS))],
            'url' => ['nullable', 'string', 'url'],
            'to_id' => ['required', 'integer'],
            'to_type' => ['required', 'string', 'in:'.implode(',', array_keys(CampaignOptions::TO_TYPE))],
            'channel' => ['required', 'string', 'in:'.implode(',', array_values(CampaignOptions::CHANNELS))],
            'meta' => ['nullable', 'array'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,odt,txt,image/jpeg,image/png,image/jpg,image/webp'],
        ];
    }

    public static function attributeX(): array
    {
        return [
            'title' => 'Título', 'description' => 'Descrição', 'message' => 'Mensagem', 'status' => 'Status', 'url' => 'URL', 'to_id' => 'Destinatário', 'to_type' => 'Tipo de Destinatário', 'channel' => 'Canal', 'meta' => 'Meta', 'file' => 'Arquivo',
        ];
    }

    public function attributes(): array
    {
        return self::attributeX();
    }

    public function rules(): array
    {
        return self::ruleX();
    }

    public static function getRules(): array
    {
        return self::ruleX();
    }

    public static function getAttributes(): array
    {
        return self::attributeX();
    }
}
