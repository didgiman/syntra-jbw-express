<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use App\Models\Type;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsRelatedToOperator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Textarea::make('description'),
                Forms\Components\DateTimePicker::make('start_time')
                    ->required()
                    ->minDate(now()),
                Forms\Components\DateTimePicker::make('end_time')
                    ->required()
                    ->minDate('start_time'),
                Forms\Components\Select::make('type_id')
                    ->relationship('type', 'description')
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->required(),
                Forms\Components\TextInput::make('max_attendees')
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->hint('Insert 0 if the event is free')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->image()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type.description')
                    ->searchable()
                    ->label('Type'),         
            ])
            ->filters([
                Tables\Filters\Filter::make('Past events only')->query(
                    function (Builder $query): Builder {
                        return $query->where('start_time', '<=', Carbon::now());
                    }
                ),
                Tables\Filters\SelectFilter::make('type_id')
                    ->options(Type::all()->pluck('description', 'id'))
                    ->multiple()
                    ->label('Type')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
