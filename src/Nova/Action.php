<?php

namespace Tsung\NovaCustomAction\Nova;


use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Nova;
use OptimistDigital\MultiselectField\Multiselect;
use Tsung\NovaCustomAction\Models\Action as CustomActionModel;
use Whitecube\NovaFlexibleContent\Flexible;

class Action extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = CustomActionModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name'),

            BelongsTo::make("Icon", 'icon', Icon::class)
                ->hideFromIndex(),

            Text::make('Modal Title'),

            Textarea::make('Modal Message'),

            // icon

            // column model yang berubah

            Flexible::make('Changes')
                ->addLayout('Column', 'changes', [
                    Text::make('Name')
                        ->rules('required'),

                    Text::make('Value'),
                ])
                ->button('Add Change'),

            // column model yang akan di cek

            Flexible::make('Rules')
                ->addLayout('Column', 'rules', [
                    Text::make('Name')
                        ->rules('required'),

                    Text::make('Value')
                        ->rules('required'),
                ])
                ->button('Add Rule'),

            // resource yang bisa menjalankan

            Multiselect::make('Nova Resources')
                ->options($this->allResource())
        ];
    }

    public function allResource()
    {
        $allNovaResources = Collect(Nova::$resources)->mapWithKeys(function($resource) {
            return [$resource::uriKey() => class_basename($resource) ];
        })->toArray();

        return $allNovaResources;
    }
}
