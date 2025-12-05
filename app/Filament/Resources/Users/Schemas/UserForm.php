<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->email()
                ->required(),

            Forms\Components\TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                ->required(fn (string $context): bool => $context === 'create')
                ->maxLength(255),

            Forms\Components\Select::make('roles')
                ->label('Role')
                ->relationship('roles', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Select::make('teams')
                ->label('Teams')
                ->multiple()
                ->relationship('teams', 'name')
                ->preload()
                ->visible(fn () => auth()->user()?->hasRole('super_admin') ?? false),
        ]);
    }
}
