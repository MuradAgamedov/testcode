<?php


namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Models\Question;
use App\Models\QuestionOption;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationLabel = 'Questions';
    protected static ?string $modelLabel = 'Question';
    protected static ?string $pluralModelLabel = 'Questions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Select::make('topic_id')
                        ->label('Topic')
                        ->relationship('topic', 'name')
                        ->required(),

                    TextInput::make('title')
                        ->label('Question Title')
                        ->required()
                        ->maxLength(255),

                    Select::make('difficulty')
                        ->label('Difficulty')
                        ->options([
                            'Easy' => 'Easy',
                            'Medium' => 'Medium',
                            'Hard' => 'Hard',
                        ])
                        ->required(),

                    Repeater::make('options')
                        ->label('Answer Options')
                        ->relationship('options')
                        ->schema([
                            TextInput::make('label')
                                ->label('Label (A, B, C...)')
                                ->required()
                                ->maxLength(1),

                            TextInput::make('option_text')
                                ->label('Option Text')
                                ->required(),
                        ])
                        ->columns(2)
                        ->minItems(2)
                        ->maxItems(6)
                        ->reorderable(),

                    Select::make('correct_option_label')
                        ->label('Correct Answer')
                        ->options([
                            'A' => 'A',
                            'B' => 'B',
                            'C' => 'C',
                            'D' => 'D',
                            'E' => 'E',
                            'F' => 'F',
                        ])
                        ->required()
                        ->dehydrated(false)
                        ->helperText('Select the correct label like A, B, C...')

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('topic.name')->label('Topic')->sortable(),
                Tables\Columns\TextColumn::make('difficulty')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }

    public static function afterCreate(Question $record, array $data): void
    {
        if (isset($data['correct_option_label'])) {
            $correctOption = $record->options()
                ->where('label', $data['correct_option_label'])
                ->first();

            if ($correctOption) {
                $record->update(['correct_option_id' => $correctOption->id]);
            }
        }
    }
}
