<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables;
use Filament\Tables\Table;

class MaterialResource extends \Filament\Resources\Resource
{
    protected static ?string $model = Material::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?string $navigationLabel = 'Materiales';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')
                ->label('Código')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(100),

            Forms\Components\TextInput::make('title')
                ->label('Título')
                ->required()
                ->columnSpanFull(),

            Forms\Components\Textarea::make('description')
                ->label('Descripción')
                ->rows(3),

            Forms\Components\Select::make('level')
                ->label('Nivel')
                ->options([
                    'colegio' => 'Colegio',
                    'cft' => 'CFT',
                    'particulares' => 'Particulares',
                ])->required(),

            Forms\Components\TextInput::make('subject')->label('Asignatura')->required(),
            Forms\Components\TextInput::make('course')->label('Curso'),
            Forms\Components\TextInput::make('year')->numeric()->minValue(2000)->maxValue(2100),
            Forms\Components\Select::make('semester')->options([1=>1,2=>2])->label('Semestre'),
            Forms\Components\TextInput::make('unit')->label('Unidad'),

            Forms\Components\Select::make('type')->label('Tipo')->options([
                'pdf'=>'PDF','image'=>'Imagen','video'=>'Video',
                'html'=>'HTML/Presentación','latex'=>'LaTeX','link'=>'Enlace','other'=>'Otro'
            ])->required(),

            Forms\Components\FileUpload::make('file_path')
                ->label('Archivo')
                ->directory(fn() => 'materials/'.now()->format('Y/m'))
                ->visibility('public')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf','text/html','image/*','video/*'])
                ->maxSize(10240)
                ->helperText('Máximo 10MB. El MIME y el tamaño se calculan automáticamente al guardar.'),

            Forms\Components\TextInput::make('file_mime')->label('MIME')->disabled()->dehydrated(false),
            Forms\Components\TextInput::make('size_bytes')->label('Tamaño')->disabled()->dehydrated(false)
                ->formatStateUsing(fn($state) => $state ? (
                    $state < 1024 ? "{$state} B" :
                    ($state < 1048576 ? number_format($state / 1024, 1).' KB' :
                    number_format($state / 1048576, 2).' MB')
                ) : '—'),
            Forms\Components\TextInput::make('link_url')->label('URL (si es enlace)')->url(),

            Forms\Components\TagsInput::make('tags')
                ->label('Tags')
                ->columnSpanFull()
                ->placeholder('Agrega un tag y presiona Enter'),

            Forms\Components\Toggle::make('published')->label('Publicado')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Código')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->sortable()->limit(40),
                Tables\Columns\BadgeColumn::make('subject')->label('Asignatura'),
                Tables\Columns\BadgeColumn::make('level')->label('Nivel')->sortable(),
                Tables\Columns\TextColumn::make('type')->label('Tipo')->sortable(),
                Tables\Columns\TextColumn::make('year')->label('Año')->sortable(),
                Tables\Columns\TextColumn::make('semester')->label('Sem')->sortable(),
                Tables\Columns\TagsColumn::make('tags')->label('Tags')->limitList(3),
                Tables\Columns\ToggleColumn::make('published')->label('Pub')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('Y-m-d')->label('Creado')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')->label('Nivel')->options([
                    'colegio' => 'Colegio', 'cft' => 'CFT', 'particulares' => 'Particulares',
                ]),
                Tables\Filters\SelectFilter::make('type')->label('Tipo')->options([
                    'pdf' => 'PDF', 'image' => 'Imagen', 'video' => 'Video',
                    'html' => 'HTML/Presentación', 'latex' => 'LaTeX', 'link' => 'Enlace', 'other' => 'Otro',
                ]),
                Tables\Filters\SelectFilter::make('course')->label('Curso')
                    ->options(fn() => Material::query()->select('course')->distinct()
                        ->orderBy('course')->whereNotNull('course')->pluck('course', 'course')->toArray()),
                Tables\Filters\SelectFilter::make('year')->label('Año')
                    ->options(fn() => Material::query()->select('year')->distinct()
                        ->orderByDesc('year')->whereNotNull('year')->pluck('year', 'year')->toArray()),
                Tables\Filters\SelectFilter::make('subject')->label('Asignatura')
                    ->options(fn() => Material::query()->select('subject')->distinct()
                        ->orderBy('subject')->pluck('subject', 'subject')->toArray()),
                Tables\Filters\TernaryFilter::make('published')->label('Publicados'),
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent)
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
