<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Schemas\Schema;
use Filament\Tables;

class UsersTable
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles'),

                Tables\Columns\TextColumn::make('teams.name')
                    ->label('Teams'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
