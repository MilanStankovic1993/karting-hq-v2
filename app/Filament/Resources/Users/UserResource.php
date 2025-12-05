<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Filament\Resources\Users\UserResource\Pages;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';

    // ✔ samo super_admin vidi Users u meniju
    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user?->hasRole('super_admin') ?? false;
    }

    // Filament 4 stil – koristimo Schema i naš UserForm helper
    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    // Filament 4 stil – koristimo Schema i naš UsersTable helper
    public static function table(Schema $schema): Schema
    {
        return UsersTable::configure($schema);
    }

    // ✔ super_admin vidi sve, technician samo članove svog tima, worker ništa
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if (! $user) {
            return User::query()->whereNull('id');
        }

        if ($user->hasRole('super_admin')) {
            return parent::getEloquentQuery();
        }

        if ($user->hasRole('technician')) {
            return User::query()->whereHas('teams', function ($q) use ($user) {
                $q->whereIn('teams.id', $user->teams->pluck('id'));
            });
        }

        // worker – nema pristup
        return User::query()->whereNull('id');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
