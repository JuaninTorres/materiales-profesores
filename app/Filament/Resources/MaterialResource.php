<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

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
                ->helperText('Máximo 10MB. Para HTML, sube el archivo principal y recursos en la misma carpeta.')
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state) {
                        $disk = 'public';
                        try {
                            $mime = Storage::disk($disk)->mimeType($state) ?? null;
                            $size = Storage::disk($disk)->size($state) ?? null;
                            $set('file_mime', $mime);
                            $set('size_kb', $size ? intdiv($size, 1024) : null);
                        } catch (\Throwable $e) {
                            $set('file_mime', null);
                            $set('size_kb', null);
                        }
                    } else {
                        $set('file_mime', null);
                        $set('size_kb', null);
                    }
                }),

            Forms\Components\TextInput::make('file_mime')->label('MIME')->disabled(),
            Forms\Components\TextInput::make('size_kb')->label('Tamaño (KB)')->disabled(),
            Forms\Components\TextInput::make('link_url')->label('URL (si es enlace)')->url(),

            Forms\Components\Toggle::make('published')->label('Publicado')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Código')->searchable(),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->limit(40),
                Tables\Columns\BadgeColumn::make('subject')->label('Asignatura'),
                Tables\Columns\BadgeColumn::make('level')->label('Nivel'),
                Tables\Columns\TextColumn::make('type')->label('Tipo'),
                Tables\Columns\TextColumn::make('year')->label('Año'),
                Tables\Columns\TextColumn::make('semester')->label('Sem'),
                Tables\Columns\ToggleColumn::make('published')->label('Pub'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('Y-m-d')->label('Creado'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')->options([
                    'colegio'=>'Colegio','cft'=>'CFT','particulares'=>'Particulares'
                ]),
                Tables\Filters\SelectFilter::make('subject')->label('Asignatura')
                    ->options(fn() => Material::query()->select('subject')->distinct()
                                ->orderBy('subject')->pluck('subject','subject')->toArray()),
                Tables\Filters\TernaryFilter::make('published')->label('Publicados'),
            ])
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
