#Custom Action for Laravel Nova

##install
```
composer require tsung/nova-custom-action
php artisan migrate
```

add "CustomAction::make()" to nova resource
add to the last one to make the button same location as default action

```
public function fields(Request $request)
{
    return [

        ...

        CustomAction::make(),

    ];
}
```

add which resource have this action on actions resource

====================

preview

![active-action](https://github.com/anditsung/nova-custom-action/blob/master/preview/active-action.png?raw=true)

![active-user](https://github.com/anditsung/nova-custom-action/blob/master/preview/active-user.png?raw=true)

![deactive-action](https://github.com/anditsung/nova-custom-action/blob/master/preview/deactive-action.png?raw=true)

![deactive-modal](https://github.com/anditsung/nova-custom-action/blob/master/preview/deactive-modal.png?raw=true)

![deactive-user](https://github.com/anditsung/nova-custom-action/blob/master/preview/deactive-user.png?raw=true)

![icons](https://github.com/anditsung/nova-custom-action/blob/master/preview/icons.png?raw=true)

![minus-circle-danger-icon](https://github.com/anditsung/nova-custom-action/blob/master/preview/minus-circle-danger-icon.png?raw=true)

![plus-circle-success-icon](https://github.com/anditsung/nova-custom-action/blob/master/preview/plus-circle-success-icon.png?raw=true)
