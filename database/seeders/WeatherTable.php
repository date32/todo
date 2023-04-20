<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeatherTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('weathers')->insert([
            ['pref' => '北海道', 'letter' => '0600003'],
            ['pref' => '青森県', 'letter' => '0300861'],
            ['pref' => '岩手県', 'letter' => '0200023'],
            ['pref' => '宮城県', 'letter' => '9800014'],
            ['pref' => '秋田県', 'letter' => '0100951'],
            ['pref' => '山形県', 'letter' => '9908570'],
            ['pref' => '福島県', 'letter' => '9608065'],
            ['pref' => '茨城県', 'letter' => '3100852'],
            ['pref' => '栃木県', 'letter' => '3200027'],
            ['pref' => '群馬県', 'letter' => '3710026'],
            ['pref' => '埼玉県', 'letter' => '3300063'],
            ['pref' => '千葉県', 'letter' => '2600855'],
            ['pref' => '東京都', 'letter' => '1630023'],
            ['pref' => '神奈川県', 'letter' => '2310021'],
            ['pref' => '新潟県', 'letter' => '9500965'],
            ['pref' => '富山県', 'letter' => '9300006'],
            ['pref' => '石川県', 'letter' => '9208203'],
            ['pref' => '福井県', 'letter' => '9100005'],
            ['pref' => '山梨県', 'letter' => '4000031'],
            ['pref' => '長野県', 'letter' => '3800872'],
            ['pref' => '岐阜県', 'letter' => '5008384'],
            ['pref' => '静岡県', 'letter' => '4200853'],
            ['pref' => '愛知県', 'letter' => '4600001'],
            ['pref' => '三重県', 'letter' => '5140006'],
            ['pref' => '滋賀県', 'letter' => '5200044'],
            ['pref' => '京都府', 'letter' => '6028041'],
            ['pref' => '大阪府', 'letter' => '5400008'],
            ['pref' => '兵庫県', 'letter' => '6500011'],
            ['pref' => '奈良県', 'letter' => '6308213'],
            ['pref' => '和歌山県', 'letter' => '6408269'],
            ['pref' => '鳥取県', 'letter' => '6800011'],
            ['pref' => '島根県', 'letter' => '6900887'],
            ['pref' => '岡山県', 'letter' => '7000824'],
            ['pref' => '広島県', 'letter' => '7300011'],
            ['pref' => '山口県', 'letter' => '7530071'],
            ['pref' => '徳島県', 'letter' => '7700941'],
            ['pref' => '香川県', 'letter' => '7600017'],
            ['pref' => '愛媛県', 'letter' => '7900001'],
            ['pref' => '高知県', 'letter' => '7800850'],
            ['pref' => '福岡県', 'letter' => '8120045'],
            ['pref' => '佐賀県', 'letter' => '8400041'],
            ['pref' => '長崎県', 'letter' => '8500058'],
            ['pref' => '熊本県', 'letter' => '8620950'],
            ['pref' => '大分県', 'letter' => '8700022'],
            ['pref' => '宮崎県', 'letter' => '8800805'],
            ['pref' => '鹿児島県', 'letter' => '8900064'],
            ['pref' => '沖縄県', 'letter' => '9000021'],
        ]);
    }
}
