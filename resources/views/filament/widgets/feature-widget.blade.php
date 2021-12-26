<div>
    <x-filament::card>
        <style>
            ol {
                list-style: none;
                counter-reset: cupcake;
                padding-left: 32px;
            }

            ol li {
                counter-increment: cupcake;
            }

            ol li:before {
                content: counters(cupcake, ".") ". ";
            }
        </style>
        <div style="font-weight: bold">功能点</div>
        <ol>
            <li>抽奖
                <ol>
                    <li>类型
                        <ol>
                            <li>大转盘</li>
                            <li>老虎机</li>
                            <li>九宫格</li>
                            <li>翻牌机</li>
                            <li>...</li>
                        </ol>
                    </li>
                    <li>川观积分抽奖</li>
                    <li>微信红包抽奖</li>
                </ol>
            </li>
            <li>投票
                <ol>
                    <li>投票后抽奖</li>
                </ol>
            </li>
            <li>表单
                <ol>
                    <li>填写后抽奖</li>
                </ol>
            </li>
            <li>功能规划
                <ol>
                    <li>答题</li>
                    <li>语音投票</li>
                    <li>在线游戏</li>
                    <li>你画我猜</li>
                    <li>默契值测试</li>
                    <li>商城</li>
                    <li>AI修复模糊图片</li>
                </ol>
            </li>
        </ol>

    </x-filament::card>
</div>
