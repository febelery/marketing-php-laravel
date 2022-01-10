<?php

namespace App\Forms\Components;

use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class SettingForm extends Forms\Components\Field
{
    protected string $view = 'forms::components.group';

    public ?string $relationship = null;

    public function relationship(string|callable $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function saveRelationships(): void
    {
        $state = $this->getState();
        $model = $this->getModel();
        $relationship = $model->{$this->getRelationship()}();
        $state['share_image'] = is_array($state['share_image']) ? Arr::first($state['share_image']) : $state['share_image'];

        if ($setting = $relationship->first()) {
            $setting->update($state);
        } else {
            $relationship->updateOrCreate($state);
        }

        $model->touch();
    }

    public function getChildComponents(): array
    {
        return [
            Forms\Components\Placeholder::make('使用平台'),
            Forms\Components\Grid::make(4)->schema([
                Forms\Components\Toggle::make('is_wechat')
                    ->label('微信')
                    ->helperText('微信投票')
                    ->default(true),
                Forms\Components\Toggle::make('is_wechat_app')
                    ->label('小程序')
                    ->helperText('微信小程序投票')
                    ->disabled()
                    ->default(false),
                Forms\Components\Toggle::make('is_wechat_web')
                    ->label('网页')
                    ->helperText('微信网页投票')
                    ->disabled()
                    ->default(false),
                Forms\Components\Toggle::make('is_anon')
                    ->label('匿名')
                    ->disabled()
                    ->helperText('匿名投票')
                    ->default(false),
            ]),
            Forms\Components\Grid::make(4)->schema([
                Forms\Components\Toggle::make('is_cgxw')
                    ->label('APP')
                    ->reactive()
                    ->helperText('川观新闻投票')
                    ->default(true),
                Forms\Components\Toggle::make('is_bind_phone')
                    ->label('绑定手机')
                    ->helperText('用手机号登录')
                    ->when(fn(callable $get) => $get('is_cgxw') === true)
                    ->default(true),
                Forms\Components\Toggle::make('is_bind_wechat')
                    ->label('绑定微信')
                    ->helperText('绑定微信')
                    ->when(fn(callable $get) => $get('is_cgxw') === true)
                    ->default(false),
            ]),
            Forms\Components\Grid::make(4)->schema([
                Forms\Components\Toggle::make('is_share')
                    ->label('分享')
                    ->helperText('是否可以分享')
                    ->default(false)
                    ->reactive(),
                Forms\Components\TextInput::make('share_title')
                    ->label('分享标题')
                    ->required(fn(callable $get) => $get('is_share') === true)
                    ->when(fn(callable $get) => $get('is_share') === true),
                Forms\Components\TextInput::make('share_desc')
                    ->label('分享描述')
                    ->required(fn(callable $get) => $get('is_share') === true)
                    ->when(fn(callable $get) => $get('is_share') === true),
                Forms\Components\FileUpload::make('share_image')
                    ->label('分享图片')
                    ->required(fn(callable $get) => $get('is_share') === true)
                    ->when(fn(callable $get) => $get('is_share') === true),
            ]),
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (SettingForm $component) {
            $model = $component->getModel();

            $address = $model instanceof Model ? $model->getRelationValue($this->getRelationship()) : null;

            $component->state($address);
        });

        $this->dehydrated(false);
    }

    public function getRelationship(): string
    {
        return $this->evaluate($this->relationship) ?? $this->getName();
    }
}
