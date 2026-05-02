<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile as BaseEditTenantProfile;

class EditTenantProfile extends BaseEditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Store settings';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('order_notification_email')
                    ->label('Order notification email')
                    ->email()
                    ->maxLength(255)
                    ->helperText('New orders from the public menu are sent here. Leave empty to use MAIL_ORDER_NOTIFICATION_ADDRESS from .env.'),
            ]);
    }
}
