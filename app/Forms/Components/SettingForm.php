<?php

namespace App\Forms\Components;

use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class SettingForm extends Forms\Components\Field
{
    protected string $view = 'filament-forms::components.group';

    public ?string $relationship = null;

    public function relationship(string|callable $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function saveRelationships(): void
    {
        $state = $this->getState();
        $record = $this->getRecord();
        $relationship = $record?->{$this->getRelationship()}();
        $state['share_image'] = is_array($state['share_image']) ? Arr::first($state['share_image']) : $state['share_image'];

        if ($relationship === null) {
            return;
        } elseif ($address = $relationship->first()) {
            $address->update($state);
        } else {
            $relationship->updateOrCreate($state);
        }

        $record->touch();
    }

    public function getChildComponents(): array
    {
        return [
            Forms\Components\Fieldset::make('使用平台')
                ->schema([
                    Forms\Components\Toggle::make('allow_cgxw')
                        ->label('川观新闻')
                        ->reactive()
                        ->default(true),
                    Forms\Components\Toggle::make('allow_wechat')
                        ->label('微信客户端')
                        ->default(true),
                    Forms\Components\Toggle::make('allow_wechat_app')
                        ->label('微信小程序')
                        ->disabled()
                        ->default(false),
                    Forms\Components\Toggle::make('allow_wechat_web')
                        ->label('微信网页')
                        ->disabled()
                        ->default(false),
                    Forms\Components\Toggle::make('allow_anon')
                        ->label('匿名')
                        ->disabled()
                        ->default(false),
                ])->columns(5),

            Forms\Components\Fieldset::make('分享')
                ->schema([
                    Forms\Components\Toggle::make('allow_share')
                        ->label('分享')
                        ->helperText('是否可以分享')
                        ->default(false)
                        ->reactive(),
                    Forms\Components\TextInput::make('share_title')
                        ->label('分享标题')
                        ->hidden(fn(callable $get) => $get('allow_share') != true)
                        ->required(fn(callable $get) => $get('allow_share') === true),
                    Forms\Components\TextInput::make('share_desc')
                        ->label('分享描述')
                        ->hidden(fn(callable $get) => $get('allow_share') != true)
                        ->required(fn(callable $get) => $get('allow_share') === true),
                    QiniuFileUpload::make('share_image')
                        ->image()
                        ->label('分享图片')
                        ->hidden(fn(callable $get) => $get('allow_share') != true)
                        ->required(fn(callable $get) => $get('allow_share') === true),
                ])->columns(4),

        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (SettingForm $component, ?Model $record) {
            $setting = $record?->getRelationValue($this->getRelationship());

            $component->state($setting ? $setting->toArray() : []);
        });

        $this->dehydrated(false);
    }

    public function getRelationship(): string
    {
        return $this->evaluate($this->relationship) ?? $this->getName();
    }
}
