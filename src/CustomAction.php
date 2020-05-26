<?php


namespace Tsung\NovaCustomAction;


use Tsung\NovaCustomAction\Models\Action as CustomActionModel;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class CustomAction extends Field
{
    public $component = 'custom-action-field';

    public function __construct()
    {
        parent::__construct(null, null, null);

        $this->exceptOnForms();
    }

    private function resource()
    {
        return app(NovaRequest::class)->resource();
    }

    public function availableActions()
    {
        $resource = $this->resource()::uriKey();

        $customAction = CustomActionModel::nova_resource($resource);

        return $customAction;
    }

    public function jsonSerialize()
    {
        $meta = parent::jsonSerialize();

        return array_merge($meta, [
            'customAction' => $this->availableActions(),
        ]);
    }
}
