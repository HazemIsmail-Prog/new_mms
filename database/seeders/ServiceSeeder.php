<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = array(
            array(
                'name_ar'       => 'تأجير سقالة الحطة الواحدة',
                'name_en'       => 'تأجير سقالة الحطة الواحدة',
                'min_price'     => 3,
                'max_price'     => 3,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب عدد واحد  متر بايب وحدات ',
                'name_en'       => 'تركيب عدد واحد  متر بايب وحدات ',
                'min_price'     => 5,
                'max_price'     => 5,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب فلتر هواء  سنترال يبداء من 6د.ك',
                'name_en'       => 'تركيب فلتر هواء  سنترال يبداء من 6د.ك',
                'min_price'     => 6,
                'max_price'     => 6,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تبديل غايش  ',
                'name_en'       => 'تبديل غايش  ',
                'min_price'     => 7,
                'max_price'     => 7,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تأجير هلتى  ( 6 , 9 , 14 كيلو )',
                'name_en'       => 'تأجير هلتى  ( 6 , 9 , 14 كيلو )',
                'min_price'     => 7,
                'max_price'     => 7,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'غسيل ماكينة سنترال داخلى  / خارجى ',
                'name_en'       => 'غسيل ماكينة سنترال داخلى  / خارجى ',
                'min_price'     => 3,
                'max_price'     => 3,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب ثرموستات (فقط)',
                'name_en'       => 'تركيب ثرموستات (فقط)',
                'min_price'     => 10,
                'max_price'     => 10,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تبديل كابستور  وحدات',
                'name_en'       => 'تبديل كابستور  وحدات',
                'min_price'     => 12,
                'max_price'     => 12,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'لوبرشير (خارجى برغي)',
                'name_en'       => 'لوبرشير (خارجى برغي)',
                'min_price'     => 12,
                'max_price'     => 12,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'هاي برشير (خارجى برغي)',
                'name_en'       => 'هاي برشير (خارجى برغي)',
                'min_price'     => 12,
                'max_price'     => 12,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تايم دلاي',
                'name_en'       => 'تايم دلاي',
                'min_price'     => 12,
                'max_price'     => 12,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تبديل ريشة مروحة (حسب القطر)',
                'name_en'       => 'تبديل ريشة مروحة (حسب القطر)',
                'min_price'     => 12,
                'max_price'     => 12,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'غسيل وحدة داخلى /  خارجى ',
                'name_en'       => 'غسيل وحدة داخلى /  خارجى ',
                'min_price'     => 15,
                'max_price'     => 15,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب وحدة من  طن  الــــــي    طن  ونص  ',
                'name_en'       => 'تركيب وحدة من  طن  الــــــي    طن  ونص  ',
                'min_price'     => 20,
                'max_price'     => 20,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب كابستور سنترال ',
                'name_en'       => 'تركيب كابستور سنترال ',
                'min_price'     => 15,
                'max_price'     => 15,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تبديل كونتاكتور وحدة ',
                'name_en'       => 'تبديل كونتاكتور وحدة ',
                'min_price'     => 15,
                'max_price'     => 15,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'فك واعادة تركيب المروحة البلور تبداء ',
                'name_en'       => 'فك واعادة تركيب المروحة البلور تبداء ',
                'min_price'     => 15,
                'max_price'     => 15,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تغير ترنس او  محول  ( VA40 + VA75 )',
                'name_en'       => 'تغير ترنس او  محول  ( VA40 + VA75 )',
                'min_price'     => 15,
                'max_price'     => 15,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تغير فاز سيكونس ( قاطع حماية )',
                'name_en'       => 'تغير فاز سيكونس ( قاطع حماية )',
                'min_price'     => 15,
                'max_price'     => 15,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب وتوريد  ترموستات سنترال  ',
                'name_en'       => 'تركيب وتوريد  ترموستات سنترال  ',
                'min_price'     => 15,
                'max_price'     => 15,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب افور لود للكمبروسر ',
                'name_en'       => 'تركيب افور لود للكمبروسر ',
                'min_price'     => 15,
                'max_price'     => 15,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'غسيل وحدة مع فكها  داخلى /  خارجى ',
                'name_en'       => 'غسيل وحدة مع فكها  داخلى /  خارجى ',
                'min_price'     => 20,
                'max_price'     => 20,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب وحدة من 2 طن  الـــي 3 طن ',
                'name_en'       => 'تركيب وحدة من 2 طن  الـــي 3 طن ',
                'min_price'     => 20,
                'max_price'     => 20,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تبديل كونتاكتور  مركزى  ',
                'name_en'       => 'تبديل كونتاكتور  مركزى  ',
                'min_price'     => 20,
                'max_price'     => 20,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب فلتر غاز',
                'name_en'       => 'تركيب فلتر غاز',
                'min_price'     => 20,
                'max_price'     => 20,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'غسيل كويل داخلى بالمواد لسنترال ',
                'name_en'       => 'غسيل كويل داخلى بالمواد لسنترال ',
                'min_price'     => 25,
                'max_price'     => 25,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تصليح بوردة  وفك وتركيب ',
                'name_en'       => 'تصليح بوردة  وفك وتركيب ',
                'min_price'     => 25,
                'max_price'     => 25,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب وتوريد فلتر هواء ',
                'name_en'       => 'تركيب وتوريد فلتر هواء ',
                'min_price'     => 25,
                'max_price'     => 25,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب كمبروسر وحدات ',
                'name_en'       => 'تركيب كمبروسر وحدات ',
                'min_price'     => 30,
                'max_price'     => 30,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'فك وتركيب الوحدات ',
                'name_en'       => 'فك وتركيب الوحدات ',
                'min_price'     => 30,
                'max_price'     => 30,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'فك وتركيب  ماتور ',
                'name_en'       => 'فك وتركيب  ماتور ',
                'min_price'     => 30,
                'max_price'     => 30,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب وتوريد ترنس او  محول  ( VA40 + VA75 )',
                'name_en'       => 'تركيب وتوريد ترنس او  محول  ( VA40 + VA75 )',
                'min_price'     => 30,
                'max_price'     => 30,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب وتوريد افور كود الكمبروسر ',
                'name_en'       => 'تركيب وتوريد افور كود الكمبروسر ',
                'min_price'     => 30,
                'max_price'     => 30,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب وتوريد ريشة مروحة ( داخلى  - خارجى  )',
                'name_en'       => 'تركيب وتوريد ريشة مروحة ( داخلى  - خارجى  )',
                'min_price'     => 40,
                'max_price'     => 40,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تعبئة غاز كامل  6  + 7 طن  ',
                'name_en'       => 'تعبئة غاز كامل  6  + 7 طن  ',
                'min_price'     => 45,
                'max_price'     => 45,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تعبئة غاز كامل  8  + 9 + 10  طن  ',
                'name_en'       => 'تعبئة غاز كامل  8  + 9 + 10  طن  ',
                'min_price'     => 55,
                'max_price'     => 55,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب كمبروسر ( مصنعية  ) (  5+ 6 طن ) ',
                'name_en'       => 'تركيب كمبروسر ( مصنعية  ) (  5+ 6 طن ) ',
                'min_price'     => 55,
                'max_price'     => 55,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب كمبروسر ( مصنعية  ) ( 7 + 8 طن ) ',
                'name_en'       => 'تركيب كمبروسر ( مصنعية  ) ( 7 + 8 طن ) ',
                'min_price'     => 70,
                'max_price'     => 70,
                'department_id' => 2,
                'active'        => 1
            ),
            array(
                'name_ar'       => 'تركيب كمبروسر ( مصنعية  ) ( 9 + 10 طن ) ',
                'name_en'       => 'تركيب كمبروسر ( مصنعية  ) ( 9 + 10 طن ) ',
                'min_price'     => 85,
                'max_price'     => 85,
                'department_id' => 2,
                'active'        => 1
            ),

        );
        Service::insert($services);

    }
}
