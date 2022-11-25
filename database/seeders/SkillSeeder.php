<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Skill\Entities\Skill;

class SkillSeeder extends Seeder
{
    public function run()
    {
        Skill::create([
            'id'    =>  1,
            'name'  =>  'تحرير النص'
        ]);

        Skill::create([
            'id'    =>  2,
            'name'  =>  'تحرير الصوت'
        ]);

        Skill::create([
            'id'    =>  3,
            'name'  =>  'تحرير صورة'
        ]);

        Skill::create([
            'id'    =>  4,
            'name'  =>  'انتاج فيديو'
        ]);

        Skill::create([
            'id'    =>  5,
            'name'  =>  'عمل عرض تقديمي'
        ]);

        Skill::create([
            'id'    =>  6,
            'name'  =>  'الحفظ والمشاركة'
        ]);
    }
}
