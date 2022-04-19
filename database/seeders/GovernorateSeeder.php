<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Governorate;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names_ar = [
            'الاسكندرية',
            'اسوان',
            'اسيوط',
            'البحيرة',
            'بني سويف',
            'القاهرة',
            'الدقهلية',
            'دمياط',
            'الفيوم',
            'الغربية',
            'الجيزة',
            'الاسماعلية',
            'كفر الشيخ',
            'الاقصر',
            'متروح',
            'المنيا',
            'المنوفية',
            'الوادي الجديد',
            'شمال سيناء',
            'بورت سعيد',
            'القليوبية',
            'قنا',
            'البحر الاحمر',
            'الشرقية',
            'سوهاج',
            'جنوب سيناء',
            'سويس',
        ];
        $names_en = [
            'Alexandria',
            'Aswan',
            'Asyut',
            'Beheira',
            'Beni Suef',
            'Cairo',
            'Dakahlia',
            'Damietta',
            'Faiyum',
            'Gharbia',
            'Giza',
            'Ismailia',
            'Kafr El Sheikh',
            'Luxor',
            'Matruh',
            'Minya',
            'Monufia',
            'New Valley',
            'North Sinai',
            'Port Sai',
            'Qalyubia',
            'Qena',
            'Red Sea',
            'Sharqia',
            'Sohag',
            'South Sinai',
            'Suez',
        ];
        for($i=0 ; $i<27 ; $i++){
            Governorate::create([
                'name_ar' => $names_ar[$i],
                'name_en' => $names_en[$i],
            ]);
        }
        
    }
}
