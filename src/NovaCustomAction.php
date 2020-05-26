<?php

namespace Tsung\NovaCustomAction;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Tsung\NovaCustomAction\Nova\Action;
use Tsung\NovaCustomAction\Nova\Icon;

class NovaCustomAction extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-custom-action', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-custom-action', __DIR__.'/../dist/css/tool.css');

        Nova::resources([
            Action::class,
            Icon::class,
        ]);
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('nova-custom-action::navigation');
    }
}
