<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class MaterialResource extends \Filament\Resources\Resource
{
    protected static ?string $model = Material::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?string $navigationLabel = 'Materiales';

    /**
     * Genera un código URL-safe único a partir de los campos del material.
     * Si el slug base ya existe, agrega -2, -3, … (estilo WordPress).
     *
     * @param  array       $data      Datos del formulario (level, subject, course, year, semester, title)
     * @param  int|null    $ignoreId  ID del registro actual en edición (para no colisionar consigo mismo)
     */
    public static function generateUniqueCode(array $data, ?int $ignoreId = null): string
    {
        $parts = array_filter([
            $data['level']    ?? null,
            $data['subject']  ?? null,
            $data['course']   ?? null,
            $data['year']     ?? null,
            isset($data['semester']) && $data['semester'] ? 's' . $data['semester'] : null,
            $data['title']    ?? null,
        ], fn($v) => $v !== null && $v !== '');

        $base = Str::slug(implode(' ', $parts)) ?: 'material';

        $code = $base;
        $n    = 2;

        while (
            Material::where('code', $code)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $code = $base . '-' . $n++;
        }

        return $code;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')
                ->label('Código')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(100)
                ->hint(fn($record) => $record ? 'Cambiar este valor modifica la URL pública del material.' : null)
                ->hintColor('warning')
                ->hintIcon(fn($record) => $record ? 'heroicon-o-exclamation-triangle' : null)
                ->placeholder('Se generará automáticamente al guardar')
                ->suffixAction(
                    Forms\Components\Actions\Action::make('generate_code')
                        ->icon('heroicon-o-arrow-path')
                        ->tooltip('Generar código desde los campos del formulario')
                        ->action(function (Set $set, Get $get, Forms\Components\Component $component) {
                            $record = $component->getLivewire()->record ?? null;
                            $set('code', MaterialResource::generateUniqueCode([
                                'level'    => $get('level'),
                                'subject'  => $get('subject'),
                                'course'   => $get('course'),
                                'year'     => $get('year'),
                                'semester' => $get('semester'),
                                'title'    => $get('title'),
                            ], $record?->id));
                        })
                ),

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
                    'colegio'      => 'Colegio',
                    'cft'          => 'CFT',
                    'particulares' => 'Particulares',
                    'universidad'  => 'Universidad',
                    'instituto'    => 'Instituto',
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

            Forms\Components\Section::make('Vista previa')
                ->schema([
                    Forms\Components\Placeholder::make('file_preview')
                        ->label('')
                        ->columnSpanFull()
                        ->content(function ($record): HtmlString|string {
                            if (!$record) return '';

                            if ($record->file_path) {
                                $url = e(asset('storage/' . $record->file_path));
                                return match ($record->type) {
                                    'image' => new HtmlString(
                                        '<img src="' . $url . '" style="max-height:320px;max-width:100%;border-radius:.5rem;display:block;">'
                                    ),
                                    'pdf' => new HtmlString(
                                        '<iframe src="' . $url . '" style="width:100%;height:520px;border:0;border-radius:.5rem;"></iframe>'
                                    ),
                                    'video' => new HtmlString(
                                        '<video controls style="width:100%;max-height:400px;border-radius:.5rem;"><source src="' . $url . '"></video>'
                                    ),
                                    default => new HtmlString(
                                        '<a href="' . $url . '" target="_blank" rel="noopener" style="text-decoration:underline;">Abrir archivo</a>'
                                    ),
                                };
                            }

                            if ($record->link_url) {
                                $url = e($record->link_url);
                                return new HtmlString(
                                    '<a href="' . $url . '" target="_blank" rel="noopener noreferrer" style="text-decoration:underline;">' . $url . '</a>'
                                );
                            }

                            return '';
                        }),
                ])
                ->visible(fn($record) => $record && ($record->file_path || $record->link_url))
                ->collapsible()
                ->columnSpanFull(),
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
                    'universidad' => 'Universidad', 'instituto' => 'Instituto',
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
