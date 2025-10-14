<?php

namespace Database\Seeders;

use App\Models\Baladia;
use Illuminate\Database\Seeder;

class Baladia_Table_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=1
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=1 | dayra_name=أدرار---//
        $Baladia = Baladia::create(['dayra_id' => 1, 'ar_name' => 'أدرار', 'en_name' => 'Adrar', 'zip_code' => '0101']);
        $Baladia = Baladia::create(['dayra_id' => 1, 'ar_name' => 'بودة', 'en_name' => 'Bouda', 'zip_code' => '0122']);
        $Baladia = Baladia::create(['dayra_id' => 1, 'ar_name' => 'أولاد أحمد تيمي', 'en_name' => 'Ouled Ahmed Tammi', 'zip_code' => '0121']);
        // --- dayra_id=2 | dayra_name=أولف---//
        $Baladia = Baladia::create(['dayra_id' => 2, 'ar_name' => 'أولف', 'en_name' => 'Aoulef', 'zip_code' => '0112']);
        $Baladia = Baladia::create(['dayra_id' => 2, 'ar_name' => 'أقبلي', 'en_name' => 'Akabli', 'zip_code' => '0119']);
        $Baladia = Baladia::create(['dayra_id' => 2, 'ar_name' => 'تيمقتن', 'en_name' => 'Tamekten', 'zip_code' => '0113']);
        $Baladia = Baladia::create(['dayra_id' => 2, 'ar_name' => 'تيت', 'en_name' => 'Tit', 'zip_code' => '0106']);
        // --- dayra_id=3 | dayra_name=أوقروت---//
        $Baladia = Baladia::create(['dayra_id' => 3, 'ar_name' => 'أوقروت', 'en_name' => 'Aougrout', 'zip_code' => '0123']);
        $Baladia = Baladia::create(['dayra_id' => 3, 'ar_name' => 'دلدول', 'en_name' => 'Deldoul', 'zip_code' => '0117']);
        $Baladia = Baladia::create(['dayra_id' => 3, 'ar_name' => 'المطارفة', 'en_name' => 'Metarfa', 'zip_code' => '0120']);
        // --- dayra_id=4 | dayra_name=شروين---//
        $Baladia = Baladia::create(['dayra_id' => 4, 'ar_name' => 'شروين', 'en_name' => 'Charouine', 'zip_code' => '0103']);
        $Baladia = Baladia::create(['dayra_id' => 4, 'ar_name' => 'أولاد عيسى', 'en_name' => 'Ouled Aïssa', 'zip_code' => '0127']);
        $Baladia = Baladia::create(['dayra_id' => 4, 'ar_name' => 'طالمين', 'en_name' => 'Talmine', 'zip_code' => '0124']);
        // --- dayra_id=5 | dayra_name=فنوغيل---//
        $Baladia = Baladia::create(['dayra_id' => 5, 'ar_name' => 'فنوغيل', 'en_name' => 'Fenoughil', 'zip_code' => '0115']);
        $Baladia = Baladia::create(['dayra_id' => 5, 'ar_name' => 'تامنطيت', 'en_name' => 'Tamantit', 'zip_code' => '0114']);
        $Baladia = Baladia::create(['dayra_id' => 5, 'ar_name' => 'تامست', 'en_name' => 'Tamest', 'zip_code' => '0102']);
        // --- dayra_id=6 | dayra_name=رقان---//
        $Baladia = Baladia::create(['dayra_id' => 6, 'ar_name' => 'رقان', 'en_name' => 'Reggane', 'zip_code' => '0104']);
        $Baladia = Baladia::create(['dayra_id' => 6, 'ar_name' => 'سالي', 'en_name' => 'Sali', 'zip_code' => '0118']);
        // --- dayra_id=7 | dayra_name=تنيركوك---//
        $Baladia = Baladia::create(['dayra_id' => 7, 'ar_name' => 'تنيركوك', 'en_name' => 'Tinerkouk', 'zip_code' => '0116']);
        $Baladia = Baladia::create(['dayra_id' => 7, 'ar_name' => 'قصر قدور', 'en_name' => 'Ksar Kaddour', 'zip_code' => '0107']);
        // --- dayra_id=8 | dayra_name=تسابيت---//
        $Baladia = Baladia::create(['dayra_id' => 8, 'ar_name' => 'تسابيت', 'en_name' => 'Tsabit', 'zip_code' => '0108']);
        $Baladia = Baladia::create(['dayra_id' => 8, 'ar_name' => 'السبع', 'en_name' => 'Sebaa', 'zip_code' => '0126']);
        // --- dayra_id=9 | dayra_name=زاوية كنتة---//
        $Baladia = Baladia::create(['dayra_id' => 9, 'ar_name' => 'زاوية كنتة', 'en_name' => 'Zaouiet Kounta', 'zip_code' => '0111']);
        $Baladia = Baladia::create(['dayra_id' => 9, 'ar_name' => 'إن زغمير', 'en_name' => 'In Zghmir', 'zip_code' => '0105']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=2
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=10 | dayra_name=الشلف---//
        $Baladia = Baladia::create(['dayra_id' => 10, 'ar_name' => 'الشلف', 'en_name' => 'Chlef', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 10, 'ar_name' => 'سنجاس', 'en_name' => 'Sendjas', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 10, 'ar_name' => 'أم الذروع', 'en_name' => 'Oum Drou', 'zip_code' => '']);
        // --- dayra_id=11 | dayra_name=أبو الحسن---//
        $Baladia = Baladia::create(['dayra_id' => 11, 'ar_name' => 'الشلف', 'en_name' => 'Chlef', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 11, 'ar_name' => 'سنجاس', 'en_name' => 'Sendjas', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 11, 'ar_name' => 'أم الذروع', 'en_name' => 'Oum Drou', 'zip_code' => '']);
        // --- dayra_id=12 | dayra_name=الكريمية---//
        $Baladia = Baladia::create(['dayra_id' => 12, 'ar_name' => 'الكريمية', 'en_name' => 'El Karimia', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 12, 'ar_name' => 'حرشون ', 'en_name' => 'Harchoun', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 12, 'ar_name' => 'بني بوطب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=13 | dayra_name=بني حواء---//
        $Baladia = Baladia::create(['dayra_id' => 13, 'ar_name' => 'بني حواء', 'en_name' => 'Beni Haoua', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 13, 'ar_name' => 'بريرة', 'en_name' => 'Breira', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 13, 'ar_name' => 'واد جوسين', 'en_name' => 'Oued Goussine', 'zip_code' => '']);
        // --- dayra_id=14 | dayra_name=أولاد فارس---//
        $Baladia = Baladia::create(['dayra_id' => 14, 'ar_name' => 'أولاد فارس', 'en_name' => 'Ouled Fares', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 14, 'ar_name' => 'الشطية', 'en_name' => 'Chettia', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 14, 'ar_name' => 'الأبيض مجاجة', 'en_name' => 'Labiod Medjadja', 'zip_code' => '']);
        // --- dayra_id=15 | dayra_name=المرسى---//
        $Baladia = Baladia::create(['dayra_id' => 15, 'ar_name' => 'المرسى', 'en_name' => 'El Marsa', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 15, 'ar_name' => 'مصدق', 'en_name' => 'Moussadek', 'zip_code' => '']);
        // --- dayra_id=16 | dayra_name=تاوقريت---//
        $Baladia = Baladia::create(['dayra_id' => 16, 'ar_name' => 'تاوقريت ', 'en_name' => 'Taougrite', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 16, 'ar_name' => 'الظهرة', 'en_name' => 'Dahra', 'zip_code' => '']);
        // --- dayra_id=17 | dayra_name=وادي الفضة---//
        $Baladia = Baladia::create(['dayra_id' => 17, 'ar_name' => 'وادي الفضة', 'en_name' => 'Ouled Fares', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 17, 'ar_name' => 'بني راشد', 'en_name' => 'Oued Fodda', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 17, 'ar_name' => 'أولاد عباس', 'en_name' => 'Ouled Abbes', 'zip_code' => '']);
        // --- dayra_id=18 | dayra_name=تنس---//
        $Baladia = Baladia::create(['dayra_id' => 18, 'ar_name' => 'تنس', 'en_name' => 'Ténès', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 18, 'ar_name' => 'سيدي عكاشة ', 'en_name' => 'Sidi Akkacha', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 18, 'ar_name' => 'سيدي عبد الرحمان', 'en_name' => 'Sidi Abderrahmane', 'zip_code' => '']);
        // --- dayra_id=19 | dayra_name=أولاد بن عبد القادر---//
        $Baladia = Baladia::create(['dayra_id' => 19, 'ar_name' => 'أولاد بن عبد القادر', 'en_name' => 'Ouled Ben Abdelkader', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 19, 'ar_name' => 'الحجاج', 'en_name' => 'El Hadjadj', 'zip_code' => '']);
        // --- dayra_id=20 | dayra_name=عين مران---//
        $Baladia = Baladia::create(['dayra_id' => 20, 'ar_name' => 'عين مران', 'en_name' => 'Aïn Merane', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 20, 'ar_name' => 'الهرانفة', 'en_name' => 'Harenfa', 'zip_code' => '']);
        // --- dayra_id=21 | dayra_name=بوقادير---//
        $Baladia = Baladia::create(['dayra_id' => 21, 'ar_name' => 'بوقادير', 'en_name' => 'Boukadir', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 21, 'ar_name' => 'وادي سلي', 'en_name' => 'Oued Sly', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 21, 'ar_name' => 'سوبها', 'en_name' => 'Sobha', 'zip_code' => '']);
        // --- dayra_id=22 | dayra_name=الزبوجة---//
        $Baladia = Baladia::create(['dayra_id' => 22, 'ar_name' => 'الزبوجة', 'en_name' => 'Zeboudja', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 22, 'ar_name' => 'بنايرية', 'en_name' => 'Bénairia', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 22, 'ar_name' => 'بوزغاية', 'en_name' => 'Bouzeghaia', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=3
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=23 | dayra_name=أفلو---//
        $Baladia = Baladia::create(['dayra_id' => 23, 'ar_name' => 'أفلو', 'en_name' => 'Aflou', 'zip_code' => '0319']);
        $Baladia = Baladia::create(['dayra_id' => 23, 'ar_name' => 'سبقاق', 'en_name' => 'Sebgag', 'zip_code' => '0316']);
        $Baladia = Baladia::create(['dayra_id' => 23, 'ar_name' => 'سيدي بوزيد', 'en_name' => 'Sidi Bouzid', 'zip_code' => '0324']);

        // --- dayra_id=24 | dayra_name=عين ماضي---//
        $Baladia = Baladia::create(['dayra_id' => 24, 'ar_name' => 'عين ماضي', 'en_name' => 'Aïn Madhi', 'zip_code' => '0307']);
        $Baladia = Baladia::create(['dayra_id' => 24, 'ar_name' => 'تاجموت', 'en_name' => 'Tadjemout', 'zip_code' => '0308']);
        $Baladia = Baladia::create(['dayra_id' => 24, 'ar_name' => 'تاجرونة', 'en_name' => 'Tadjrouna', 'zip_code' => '0318']);
        $Baladia = Baladia::create(['dayra_id' => 24, 'ar_name' => 'الحويطة', 'en_name' => 'El Houaita', 'zip_code' => '0323']);
        $Baladia = Baladia::create(['dayra_id' => 24, 'ar_name' => 'الخنق', 'en_name' => 'Kheneg', 'zip_code' => '0309']);
        // --- dayra_id=25 | dayra_name=بريدة---//
        $Baladia = Baladia::create(['dayra_id' => 25, 'ar_name' => 'بريدة', 'en_name' => 'Brida', 'zip_code' => '0313']);
        $Baladia = Baladia::create(['dayra_id' => 25, 'ar_name' => 'تاويالة', 'en_name' => 'Taouiala', 'zip_code' => '0317']);
        // --- dayra_id=26 | dayra_name=الغيشة---//
        $Baladia = Baladia::create(['dayra_id' => 26, 'ar_name' => 'الغيشة', 'en_name' => 'El Ghicha', 'zip_code' => '0314']);
        // --- dayra_id=27 | dayra_name=قلعة سيدي سعد---//
        $Baladia = Baladia::create(['dayra_id' => 27, 'ar_name' => 'قلتة سيدي سعد', 'en_name' => 'Gueltat Sidi Saad', 'zip_code' => '0310']);
        $Baladia = Baladia::create(['dayra_id' => 27, 'ar_name' => 'عين سيدي علي', 'en_name' => 'Aïn Sidi Ali', 'zip_code' => '0311']);
        $Baladia = Baladia::create(['dayra_id' => 27, 'ar_name' => 'الحاج مشري', 'en_name' => 'Hadj Mechri', 'zip_code' => '0315']);
        $Baladia = Baladia::create(['dayra_id' => 27, 'ar_name' => 'البيضاء', 'en_name' => 'Beidha', 'zip_code' => '0312']);
        // --- dayra_id=28 | dayra_name=حاسي الرمل---//
        $Baladia = Baladia::create(['dayra_id' => 28, 'ar_name' => 'حاسي الرمل', 'en_name' => 'Hassi R Mel', 'zip_code' => '0306']);
        $Baladia = Baladia::create(['dayra_id' => 28, 'ar_name' => 'حاسي دلاعة', 'en_name' => 'Hassi Delaa', 'zip_code' => '0305']);
        // --- dayra_id=29 | dayra_name=قصر الحيران---//
        $Baladia = Baladia::create(['dayra_id' => 29, 'ar_name' => 'قصر الحيران ', 'en_name' => 'Ksar El Hirane', 'zip_code' => '0302']);
        $Baladia = Baladia::create(['dayra_id' => 29, 'ar_name' => 'بن ناصر بن شهرة', 'en_name' => 'Bennasser Benchohra', 'zip_code' => '0303']);
        // --- dayra_id=30 | dayra_name=الأغواط---//
        $Baladia = Baladia::create(['dayra_id' => 30, 'ar_name' => 'الأغواط', 'en_name' => 'Laghouat', 'zip_code' => '0301']);
        // --- dayra_id=31 | dayra_name=واد مرة---//
        $Baladia = Baladia::create(['dayra_id' => 31, 'ar_name' => 'وادي مرة', 'en_name' => 'Oued Morra', 'zip_code' => '0321']);
        $Baladia = Baladia::create(['dayra_id' => 31, 'ar_name' => 'وادي مزي', 'en_name' => 'Oued M Zi', 'zip_code' => '0322']);
        // --- dayra_id=32 | dayra_name=سيدي مخلوف---//
        $Baladia = Baladia::create(['dayra_id' => 32, 'ar_name' => 'سيدي مخلوف', 'en_name' => 'Sidi Makhlouf', 'zip_code' => '0304']);
        $Baladia = Baladia::create(['dayra_id' => 32, 'ar_name' => 'العسافية', 'en_name' => 'El Assafia', 'zip_code' => '0320']);
        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=4
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=33 | dayra_name=سوق نعمان---//
        $Baladia = Baladia::create(['dayra_id' => 33, 'ar_name' => 'سوق نعمان', 'en_name' => 'Souk Naamane', 'zip_code' => '0417']);
        $Baladia = Baladia::create(['dayra_id' => 33, 'ar_name' => '', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 33, 'ar_name' => '', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=34 | dayra_name=أم البواقي---//
        $Baladia = Baladia::create(['dayra_id' => 34, 'ar_name' => 'أم البواقي', 'en_name' => 'Oum el Bouaghi', 'zip_code' => '0401']);
        $Baladia = Baladia::create(['dayra_id' => 34, 'ar_name' => 'عين الزيتون', 'en_name' => 'Aïn Zitoun', 'zip_code' => '0427']);

        // --- dayra_id=35 | dayra_name=سيقوس---//
        $Baladia = Baladia::create(['dayra_id' => 35, 'ar_name' => 'سيقوس', 'en_name' => 'Sigus', 'zip_code' => '0406']);
        $Baladia = Baladia::create(['dayra_id' => 35, 'ar_name' => 'العامرية', 'en_name' => 'El Amiria', 'zip_code' => '0405']);
        // --- dayra_id=36 | dayra_name=الضلعة---//
        $Baladia = Baladia::create(['dayra_id' => 36, 'ar_name' => 'الضلعة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=37 | dayra_name=عين البيضاء---//
        $Baladia = Baladia::create(['dayra_id' => 37, 'ar_name' => 'عين البيضاء', 'en_name' => 'Aïn Beïda', 'zip_code' => '0402']);
        $Baladia = Baladia::create(['dayra_id' => 37, 'ar_name' => 'بريش', 'en_name' => 'Berriche', 'zip_code' => '0409']);
        $Baladia = Baladia::create(['dayra_id' => 37, 'ar_name' => 'فكرينة', 'en_name' => 'Fkirina', 'zip_code' => '0416']);
        $Baladia = Baladia::create(['dayra_id' => 37, 'ar_name' => 'الزرق', 'en_name' => 'Zorg', 'zip_code' => '0418']);
        $Baladia = Baladia::create(['dayra_id' => 37, 'ar_name' => 'وادي نيني', 'en_name' => 'Oued Nini', 'zip_code' => '0423']);
        // --- dayra_id=38 | dayra_name=عين بابوش---//
        $Baladia = Baladia::create(['dayra_id' => 38, 'ar_name' => 'عين بابوش', 'en_name' => 'Aïn Babouche', 'zip_code' => '0408']);
        $Baladia = Baladia::create(['dayra_id' => 38, 'ar_name' => 'عين الديس', 'en_name' => 'Aïn Diss', 'zip_code' => '0415']);
        // --- dayra_id=39 | dayra_name=عين فكرون---//
        $Baladia = Baladia::create(['dayra_id' => 39, 'ar_name' => 'عين فكرون', 'en_name' => 'Aïn Fakroun', 'zip_code' => '0425']);
        $Baladia = Baladia::create(['dayra_id' => 39, 'ar_name' => 'الفجوج بوغرارة سعودي', 'en_name' => 'El Fedjoudj Boughrara Saoudi', 'zip_code' => '0419']);
        // --- dayra_id=40 | dayra_name=عين كرشة---//
        $Baladia = Baladia::create(['dayra_id' => 40, 'ar_name' => 'عين كرشة', 'en_name' => 'Aïn Kercha', 'zip_code' => '0412']);
        $Baladia = Baladia::create(['dayra_id' => 40, 'ar_name' => 'هنشير تومغني', 'en_name' => 'Hanchir Toumghani', 'zip_code' => '0413']);
        $Baladia = Baladia::create(['dayra_id' => 40, 'ar_name' => 'الحرميلية', 'en_name' => 'El Harmilia', 'zip_code' => '0429']);
        // --- dayra_id=41 | dayra_name=عين مليلة---//
        $Baladia = Baladia::create(['dayra_id' => 41, 'ar_name' => 'عين مليلة', 'en_name' => 'Aïn Mlila', 'zip_code' => '0403']);
        // --- dayra_id=42 | dayra_name=فكرينة---//
        $Baladia = Baladia::create(['dayra_id' => 42, 'ar_name' => 'أولاد حملة', 'en_name' => 'Ouled Hamla', 'zip_code' => '0410']);
        // --- dayra_id=43 | dayra_name=قصر صباحي---//
        $Baladia = Baladia::create(['dayra_id' => 43, 'ar_name' => 'أولاد قاسم', 'en_name' => 'Ouled Gacem', 'zip_code' => '0428']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=5
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=44 | dayra_name=آريس---//
        $Baladia = Baladia::create(['dayra_id' => 44, 'ar_name' => 'آريس', 'en_name' => 'Arris', 'zip_code' => '0516']);
        // --- dayra_id=45 | dayra_name=أولاد سلام---//
        $Baladia = Baladia::create(['dayra_id' => 45, 'ar_name' => 'تيغانمين', 'en_name' => 'Tighanimine', 'zip_code' => '0526']);
        // --- dayra_id=46 | dayra_name=أولاد سي سليمان---//
        $Baladia = Baladia::create(['dayra_id' => 46, 'ar_name' => 'لمسان', 'en_name' => 'Lemsane', 'zip_code' => '0527']);
        $Baladia = Baladia::create(['dayra_id' => 46, 'ar_name' => 'تاكسلانت', 'en_name' => 'Taxlent', 'zip_code' => '0538']);
        $Baladia = Baladia::create(['dayra_id' => 46, 'ar_name' => 'أولاد سي سليمان', 'en_name' => 'Ouled Si Slimane', 'zip_code' => '0553']);
        // --- dayra_id=47 | dayra_name=إشمول---//
        $Baladia = Baladia::create(['dayra_id' => 47, 'ar_name' => 'إينوغيسن', 'en_name' => 'Inoughissen', 'zip_code' => '0511']);
        $Baladia = Baladia::create(['dayra_id' => 47, 'ar_name' => 'إشمول', 'en_name' => 'Ichmoul', 'zip_code' => '0530']);
        $Baladia = Baladia::create(['dayra_id' => 47, 'ar_name' => 'فم الطوب', 'en_name' => 'Foum Toub', 'zip_code' => '0531']);
        // --- dayra_id=48 | dayra_name=الجزار---//
        $Baladia = Baladia::create(['dayra_id' => 48, 'ar_name' => 'عزيل عبد القادر', 'en_name' => 'Abdelkader Azil', 'zip_code' => '0515']);
        $Baladia = Baladia::create(['dayra_id' => 48, 'ar_name' => 'الجزار', 'en_name' => 'Djezar', 'zip_code' => '0543']);
        $Baladia = Baladia::create(['dayra_id' => 48, 'ar_name' => 'أولاد عمار', 'en_name' => 'Ouled Ammar', 'zip_code' => '0556']);
        // --- dayra_id=49 | dayra_name=الشمرة---//
        $Baladia = Baladia::create(['dayra_id' => 49, 'ar_name' => 'الشمرة', 'en_name' => 'Chemora', 'zip_code' => '0536']);
        $Baladia = Baladia::create(['dayra_id' => 49, 'ar_name' => 'بولهيلات', 'en_name' => 'Boulhilat', 'zip_code' => '0560']);
        // --- dayra_id=50 | dayra_name=المعذر---//
        $Baladia = Baladia::create(['dayra_id' => 50, 'ar_name' => 'المعذر', 'en_name' => 'El Madher', 'zip_code' => '0507']);
        $Baladia = Baladia::create(['dayra_id' => 50, 'ar_name' => 'جرمة', 'en_name' => 'Djerma', 'zip_code' => '0513']);
        $Baladia = Baladia::create(['dayra_id' => 50, 'ar_name' => 'عين ياقوت', 'en_name' => 'Aïn Yagout', 'zip_code' => '0522']);
        $Baladia = Baladia::create(['dayra_id' => 50, 'ar_name' => 'بومية', 'en_name' => 'Boumia', 'zip_code' => '0559']);
        // --- dayra_id=51 | dayra_name=باتنة---//
        $Baladia = Baladia::create(['dayra_id' => 51, 'ar_name' => 'باتنة', 'en_name' => 'Batna', 'zip_code' => '0501']);
        $Baladia = Baladia::create(['dayra_id' => 51, 'ar_name' => 'فسديس', 'en_name' => 'Fesdis', 'zip_code' => '0523']);
        $Baladia = Baladia::create(['dayra_id' => 51, 'ar_name' => 'وادي الشعبة', 'en_name' => 'Oued Chaaba', 'zip_code' => '0537']);
        // --- dayra_id=52| dayra_name=بريكة---//
        $Baladia = Baladia::create(['dayra_id' => 52, 'ar_name' => 'بيطام', 'en_name' => 'Bitam', 'zip_code' => '0514']);
        $Baladia = Baladia::create(['dayra_id' => 52, 'ar_name' => 'بريكة', 'en_name' => 'Barika', 'zip_code' => '0542']);
        $Baladia = Baladia::create(['dayra_id' => 52, 'ar_name' => 'أمدوكال', 'en_name' => 'Mdoukel', 'zip_code' => '0555']);

        // --- dayra_id=53 | dayra_name=بوزينة---//
        $Baladia = Baladia::create(['dayra_id' => 53, 'ar_name' => 'بوزينة', 'en_name' => 'Bouzina', 'zip_code' => '0535']);
        $Baladia = Baladia::create(['dayra_id' => 53, 'ar_name' => 'لارباع', 'en_name' => '	Larbaâ', 'zip_code' => '0561']);
        // --- dayra_id=54 | dayra_name=تازولت---//
        $Baladia = Baladia::create(['dayra_id' => 54, 'ar_name' => 'تازولت', 'en_name' => 'Tazoult', 'zip_code' => '0508']);
        $Baladia = Baladia::create(['dayra_id' => 54, 'ar_name' => 'عيون العصافير', 'en_name' => 'Ouyoun El Assafir', 'zip_code' => '0512']);
        // --- dayra_id=55 | dayra_name=تكوت---//
        $Baladia = Baladia::create(['dayra_id' => 55, 'ar_name' => 'غسيرة', 'en_name' => 'Ghassira', 'zip_code' => '0502']);
        $Baladia = Baladia::create(['dayra_id' => 55, 'ar_name' => 'كيمل', 'en_name' => 'Kimmel', 'zip_code' => '0517']);
        $Baladia = Baladia::create(['dayra_id' => 55, 'ar_name' => 'تكوت', 'en_name' => 'T Kout', 'zip_code' => '0544']);
        // --- dayra_id=56 | dayra_name=تيمقاد---//
        $Baladia = Baladia::create(['dayra_id' => 56, 'ar_name' => 'أولاد فاضل', 'en_name' => 'Ouled Fadel', 'zip_code' => '0549']);
        $Baladia = Baladia::create(['dayra_id' => 56, 'ar_name' => 'تيمقاد', 'en_name' => 'Timgad', 'zip_code' => '0550']);
        // --- dayra_id=57 | dayra_name=ثنية العابد---//
        $Baladia = Baladia::create(['dayra_id' => 57, 'ar_name' => 'ثنية العابد', 'en_name' => 'Teniet El Abed', 'zip_code' => '0547']);
        $Baladia = Baladia::create(['dayra_id' => 57, 'ar_name' => 'وادي الطاقة', 'en_name' => 'Oued Taga', 'zip_code' => '0548']);
        $Baladia = Baladia::create(['dayra_id' => 57, 'ar_name' => 'شير', 'en_name' => 'Chir', 'zip_code' => '0552']);

        // --- dayra_id=58 | dayra_name=رأس العيون---//
        $Baladia = Baladia::create(['dayra_id' => 58, 'ar_name' => 'القيقبة', 'en_name' => 'Guigba', 'zip_code' => '0510']);
        $Baladia = Baladia::create(['dayra_id' => 58, 'ar_name' => 'القصبات', 'en_name' => 'Gosbat', 'zip_code' => '0539']);
        $Baladia = Baladia::create(['dayra_id' => 58, 'ar_name' => 'رأس العيون', 'en_name' => 'Ras El Aioun', 'zip_code' => '0551']);

        // --- dayra_id=59 | dayra_name=سريانة---//
        $Baladia = Baladia::create(['dayra_id' => 59, 'ar_name' => 'سريانة', 'en_name' => 'Seriana', 'zip_code' => '0505']);
        $Baladia = Baladia::create(['dayra_id' => 59, 'ar_name' => 'زانة البيضاء', 'en_name' => 'Zanat El Beida', 'zip_code' => '0554']);
        $Baladia = Baladia::create(['dayra_id' => 59, 'ar_name' => 'لازرو', 'en_name' => 'Lazrou', 'zip_code' => '0558']);

        // --- dayra_id=60 | dayra_name=سقانة---//
        $Baladia = Baladia::create(['dayra_id' => 60, 'ar_name' => 'تيلاطو', 'en_name' => 'Tilatou', 'zip_code' => '0518']);
        $Baladia = Baladia::create(['dayra_id' => 60, 'ar_name' => 'سقانة', 'en_name' => 'Seggana', 'zip_code' => '0529']);
        // --- dayra_id=61 | dayra_name=عين التوتة---//
        $Baladia = Baladia::create(['dayra_id' => 61, 'ar_name' => 'معافة', 'en_name' => 'Maafa', 'zip_code' => '0503']);
        $Baladia = Baladia::create(['dayra_id' => 61, 'ar_name' => 'بني فضالة الحقانية', 'en_name' => 'Ben Foudhala El Hakania', 'zip_code' => '0532']);
        $Baladia = Baladia::create(['dayra_id' => 61, 'ar_name' => 'أولاد عوف', 'en_name' => 'Ouled Aouf', 'zip_code' => '0540']);
        $Baladia = Baladia::create(['dayra_id' => 61, 'ar_name' => 'عين التوتة', 'en_name' => 'Aïn Touta', 'zip_code' => '0545']);
        // --- dayra_id=62 | dayra_name=عين جاسر---//
        $Baladia = Baladia::create(['dayra_id' => 62, 'ar_name' => 'عين جاسر', 'en_name' => 'Aïn Djasser', 'zip_code' => '0519']);
        $Baladia = Baladia::create(['dayra_id' => 62, 'ar_name' => 'الحاسي', 'en_name' => 'El Hassi', 'zip_code' => '0557']);
        // --- dayra_id=63 | dayra_name=مروانة---//
        $Baladia = Baladia::create(['dayra_id' => 63, 'ar_name' => 'مروانة', 'en_name' => 'Merouana', 'zip_code' => '0504']);
        $Baladia = Baladia::create(['dayra_id' => 63, 'ar_name' => 'قصر بلزمة', 'en_name' => 'Ksar Bellezma', 'zip_code' => '0528']);
        $Baladia = Baladia::create(['dayra_id' => 63, 'ar_name' => 'وادي الماء', 'en_name' => 'Oued El Ma', 'zip_code' => '0533']);
        $Baladia = Baladia::create(['dayra_id' => 63, 'ar_name' => 'حيدوسة', 'en_name' => 'Hidoussa', 'zip_code' => '0546']);
        // --- dayra_id=64 | dayra_name=منعة---//
        $Baladia = Baladia::create(['dayra_id' => 64, 'ar_name' => 'منعة', 'en_name' => 'Menaa', 'zip_code' => '0506']);
        $Baladia = Baladia::create(['dayra_id' => 64, 'ar_name' => 'تيغرغار', 'en_name' => 'Tigherghar', 'zip_code' => '0521']);
        // --- dayra_id=65 | dayra_name=نقاوس---//
        $Baladia = Baladia::create(['dayra_id' => 65, 'ar_name' => 'نقاوس', 'en_name' => 'N Gaous', 'zip_code' => '0509']);
        $Baladia = Baladia::create(['dayra_id' => 65, 'ar_name' => 'سفيان', 'en_name' => 'Sefiane', 'zip_code' => '0524']);
        $Baladia = Baladia::create(['dayra_id' => 65, 'ar_name' => 'بومقر', 'en_name' => 'Boumagueur', 'zip_code' => '0541']);
        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=6
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=66 | dayra_name=آدكار---//
        $Baladia = Baladia::create(['dayra_id' => 66, 'ar_name' => 'آدكار', 'en_name' => '', 'zip_code' => '6 024']);
        $Baladia = Baladia::create(['dayra_id' => 66, 'ar_name' => 'تاوريرت آغيل', 'en_name' => '', 'zip_code' => '6 004']);
        $Baladia = Baladia::create(['dayra_id' => 66, 'ar_name' => 'بنى كسيلة', 'en_name' => '', 'zip_code' => '6 034']);
        // --- dayra_id=67 | dayra_name=أقبو---//
        $Baladia = Baladia::create(['dayra_id' => 67, 'ar_name' => 'أقبو', 'en_name' => '', 'zip_code' => '6 025']);
        $Baladia = Baladia::create(['dayra_id' => 67, 'ar_name' => 'شلاطة', 'en_name' => '', 'zip_code' => '6 005']);
        $Baladia = Baladia::create(['dayra_id' => 67, 'ar_name' => 'آغرام', 'en_name' => '', 'zip_code' => '6 015']);
        $Baladia = Baladia::create(['dayra_id' => 67, 'ar_name' => 'تمقرة', 'en_name' => '', 'zip_code' => '6 006']);
        // --- dayra_id=68 | dayra_name=أميزور---//
        $Baladia = Baladia::create(['dayra_id' => 68, 'ar_name' => 'أميزور', 'en_name' => '', 'zip_code' => '6 002']);
        $Baladia = Baladia::create(['dayra_id' => 68, 'ar_name' => 'بني جليل', 'en_name' => '', 'zip_code' => '6 023']);
        $Baladia = Baladia::create(['dayra_id' => 68, 'ar_name' => 'سمعون', 'en_name' => '', 'zip_code' => '6 012']);
        $Baladia = Baladia::create(['dayra_id' => 68, 'ar_name' => 'فرعون', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=69 | dayra_name=أوقاس---//
        $Baladia = Baladia::create(['dayra_id' => 69, 'ar_name' => 'أوقاس', 'en_name' => '', 'zip_code' => '6 022']);
        $Baladia = Baladia::create(['dayra_id' => 69, 'ar_name' => 'تيزي أنبربار', 'en_name' => '', 'zip_code' => '6 049']);
        // --- dayra_id=70 | dayra_name=برباشة---//
        $Baladia = Baladia::create(['dayra_id' => 70, 'ar_name' => 'برباشة', 'en_name' => '', 'zip_code' => '6 033']);
        $Baladia = Baladia::create(['dayra_id' => 70, 'ar_name' => 'كنديرة', 'en_name' => '', 'zip_code' => '6 013']);
        // --- dayra_id=71 | dayra_name=بجاية---//
        $Baladia = Baladia::create(['dayra_id' => 71, 'ar_name' => 'بجاية', 'en_name' => '', 'zip_code' => '6 001	']);
        $Baladia = Baladia::create(['dayra_id' => 71, 'ar_name' => 'وادي غير', 'en_name' => '', 'zip_code' => '6 051	']);
        // --- dayra_id=72 | dayra_name=بني معوش---//
        $Baladia = Baladia::create(['dayra_id' => 72, 'ar_name' => 'بني معوش', 'en_name' => '', 'zip_code' => '6 050	']);
        // --- dayra_id=73 | dayra_name=شميني---//
        $Baladia = Baladia::create(['dayra_id' => 73, 'ar_name' => 'شميني', 'en_name' => '', 'zip_code' => '6 029	']);
        $Baladia = Baladia::create(['dayra_id' => 73, 'ar_name' => 'طيبان', 'en_name' => '', 'zip_code' => '6 031	']);
        $Baladia = Baladia::create(['dayra_id' => 73, 'ar_name' => 'سوق أوفلة', 'en_name' => '', 'zip_code' => '6 030	']);
        $Baladia = Baladia::create(['dayra_id' => 73, 'ar_name' => 'أكفادو', 'en_name' => '', 'zip_code' => '6 042	']);
        // --- dayra_id=74 | dayra_name=درقينة---//
        $Baladia = Baladia::create(['dayra_id' => 74, 'ar_name' => 'درقينة', 'en_name' => '', 'zip_code' => '6 020	']);
        $Baladia = Baladia::create(['dayra_id' => 74, 'ar_name' => 'آيت سماعيل', 'en_name' => '', 'zip_code' => '6 047	']);
        $Baladia = Baladia::create(['dayra_id' => 74, 'ar_name' => 'تاسكريوت', 'en_name' => '', 'zip_code' => '6 037	']);
        // --- dayra_id=75 | dayra_name=القصر---//
        $Baladia = Baladia::create(['dayra_id' => 75, 'ar_name' => 'القصر', 'en_name' => '', 'zip_code' => '6 040	']);
        $Baladia = Baladia::create(['dayra_id' => 75, 'ar_name' => 'فناية الماثن', 'en_name' => '', 'zip_code' => '6 018	']);
        $Baladia = Baladia::create(['dayra_id' => 75, 'ar_name' => 'توجة', 'en_name' => '', 'zip_code' => '6 019	']);
        // --- dayra_id=76 | dayra_name=إغيل علي---//
        $Baladia = Baladia::create(['dayra_id' => 76, 'ar_name' => 'إغيل علي', 'en_name' => '', 'zip_code' => '6 017	']);
        $Baladia = Baladia::create(['dayra_id' => 76, 'ar_name' => 'آيت أرزين', 'en_name' => '', 'zip_code' => '6 028	']);
        // --- dayra_id=77 | dayra_name=خراطة---//
        $Baladia = Baladia::create(['dayra_id' => 77, 'ar_name' => 'خراطة', 'en_name' => '', 'zip_code' => '6 044	']);
        $Baladia = Baladia::create(['dayra_id' => 77, 'ar_name' => 'ذراع القايد', 'en_name' => '', 'zip_code' => '6 045	']);
        // --- dayra_id=78 | dayra_name=أوزلاقن---//
        $Baladia = Baladia::create(['dayra_id' => 78, 'ar_name' => 'أوزلاقن', 'en_name' => '', 'zip_code' => '6 035	']);
        // --- dayra_id=79 | dayra_name=صدوق---//
        $Baladia = Baladia::create(['dayra_id' => 79, 'ar_name' => 'صدوق', 'en_name' => '', 'zip_code' => '6 026']);
        $Baladia = Baladia::create(['dayra_id' => 79, 'ar_name' => 'أمالو', 'en_name' => '', 'zip_code' => '6 016	']);
        $Baladia = Baladia::create(['dayra_id' => 79, 'ar_name' => 'مسيسنة', 'en_name' => '', 'zip_code' => '6 009	']);
        $Baladia = Baladia::create(['dayra_id' => 79, 'ar_name' => 'بوحمزة', 'en_name' => '', 'zip_code' => '6 036	']);
        // --- dayra_id=80 | dayra_name=سيدي عيش---//
        $Baladia = Baladia::create(['dayra_id' => 80, 'ar_name' => 'سيدي عيش', 'en_name' => '', 'zip_code' => '6 039	']);
        $Baladia = Baladia::create(['dayra_id' => 80, 'ar_name' => 'لفلاي', 'en_name' => '', 'zip_code' => '6 043	']);
        $Baladia = Baladia::create(['dayra_id' => 80, 'ar_name' => 'تينبذار', 'en_name' => '', 'zip_code' => '6 010	']);
        $Baladia = Baladia::create(['dayra_id' => 80, 'ar_name' => 'تيفرة', 'en_name' => '', 'zip_code' => '6 014	']);
        $Baladia = Baladia::create(['dayra_id' => 80, 'ar_name' => 'سيدي عياد', 'en_name' => '', 'zip_code' => '6 021	']);
        // --- dayra_id=81 | dayra_name=سوق الاثنين---//
        $Baladia = Baladia::create(['dayra_id' => 81, 'ar_name' => 'سوق الاثنين', 'en_name' => '', 'zip_code' => '6 008	']);
        $Baladia = Baladia::create(['dayra_id' => 81, 'ar_name' => 'ملبو', 'en_name' => '', 'zip_code' => '6 041	']);
        $Baladia = Baladia::create(['dayra_id' => 81, 'ar_name' => 'تامريجت', 'en_name' => '', 'zip_code' => '6 046	']);
        // --- dayra_id=82 | dayra_name=تازمالت---//
        $Baladia = Baladia::create(['dayra_id' => 82, 'ar_name' => 'تازمالت', 'en_name' => '', 'zip_code' => '6 027	']);
        $Baladia = Baladia::create(['dayra_id' => 82, 'ar_name' => 'بني مليكش', 'en_name' => '', 'zip_code' => '6 038	']);
        $Baladia = Baladia::create(['dayra_id' => 82, 'ar_name' => 'بوجليل', 'en_name' => '', 'zip_code' => '6 052	']);
        // --- dayra_id=83 | dayra_name=تيشي---//
        $Baladia = Baladia::create(['dayra_id' => 83, 'ar_name' => 'تيشي', 'en_name' => '', 'zip_code' => '6 011	']);
        $Baladia = Baladia::create(['dayra_id' => 83, 'ar_name' => 'بوخليفة', 'en_name' => '', 'zip_code' => '6 048	']);
        $Baladia = Baladia::create(['dayra_id' => 83, 'ar_name' => 'تالة حمزة', 'en_name' => '', 'zip_code' => '6 032	']);
        // --- dayra_id=84 | dayra_name=تيمزريت---//
        $Baladia = Baladia::create(['dayra_id' => 84, 'ar_name' => 'تيمزريت', 'en_name' => '', 'zip_code' => '6 007	']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=7
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=85 | dayra_name=بسكرة---//
        $Baladia = Baladia::create(['dayra_id' => 85, 'ar_name' => 'بسكرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 85, 'ar_name' => 'الحاجب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=86 | dayra_name=جمورة---//
        $Baladia = Baladia::create(['dayra_id' => 86, 'ar_name' => 'جمورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 86, 'ar_name' => 'البرانيس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=87 | dayra_name=فوغالة---//
        $Baladia = Baladia::create(['dayra_id' => 87, 'ar_name' => 'فوغالة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 87, 'ar_name' => 'الغروس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=88 | dayra_name=القنطرة---//
        $Baladia = Baladia::create(['dayra_id' => 88, 'ar_name' => 'القنطرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 88, 'ar_name' => 'عين زعطوط', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=89 | dayra_name=لوطاية---//
        $Baladia = Baladia::create(['dayra_id' => 89, 'ar_name' => 'لوطاية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=90 | dayra_name=مشونش---//
        $Baladia = Baladia::create(['dayra_id' => 90, 'ar_name' => 'مشونش', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=91 | dayra_name=أورلال---//
        $Baladia = Baladia::create(['dayra_id' => 91, 'ar_name' => 'أورلال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 91, 'ar_name' => 'أوماش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 91, 'ar_name' => 'مليلي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 91, 'ar_name' => 'مخادمة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 91, 'ar_name' => 'ليوة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=92 | dayra_name=سيدي خالد---//
        $Baladia = Baladia::create(['dayra_id' => 92, 'ar_name' => 'سيدي خالد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 92, 'ar_name' => 'البسباس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 92, 'ar_name' => 'راس الميعاد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=93 | dayra_name=سيدي عقبة---//
        $Baladia = Baladia::create(['dayra_id' => 93, 'ar_name' => 'سيدي عقبة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 93, 'ar_name' => 'شتمة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 93, 'ar_name' => 'الحوش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 93, 'ar_name' => 'عين الناقة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=94 | dayra_name=طولقة---//
        $Baladia = Baladia::create(['dayra_id' => 94, 'ar_name' => 'طولقة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 94, 'ar_name' => 'بوشقرون', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 94, 'ar_name' => 'برج بن عزوز', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 94, 'ar_name' => 'ليشانة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=95 | dayra_name=زريبة الوادي---//
        $Baladia = Baladia::create(['dayra_id' => 95, 'ar_name' => 'زريبة الوادي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 95, 'ar_name' => 'خنقة سيدي ناجي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 95, 'ar_name' => 'الفيض', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 95, 'ar_name' => 'المزيرعة', 'en_name' => '', 'zip_code' => '']);
        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=8
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=96 | dayra_name=بشار---//
        $Baladia = Baladia::create(['dayra_id' => 96, 'ar_name' => 'بشار', 'en_name' => '', 'zip_code' => '0801']);
        // --- dayra_id=97 | dayra_name=بني ونيف---//
        $Baladia = Baladia::create(['dayra_id' => 97, 'ar_name' => 'بني ونيف', 'en_name' => '', 'zip_code' => '0821']);
        // --- dayra_id=98 | dayra_name=تاغيت---//
        $Baladia = Baladia::create(['dayra_id' => 98, 'ar_name' => 'تاغيت', 'en_name' => '', 'zip_code' => '0813']);
        // --- dayra_id=99 | dayra_name=ولاد خضير---//
        $Baladia = Baladia::create(['dayra_id' => 99, 'ar_name' => 'أولاد خضير', 'en_name' => '', 'zip_code' => '0803']);
        $Baladia = Baladia::create(['dayra_id' => 99, 'ar_name' => 'قصابي', 'en_name' => '', 'zip_code' => '	0819']);
        // --- dayra_id=100 | dayra_name=كرزاز---//
        $Baladia = Baladia::create(['dayra_id' => 100, 'ar_name' => 'كرزاز', 'en_name' => '', 'zip_code' => '0818']);
        $Baladia = Baladia::create(['dayra_id' => 100, 'ar_name' => 'بني يخلف', 'en_name' => '', 'zip_code' => '0808	']);
        $Baladia = Baladia::create(['dayra_id' => 100, 'ar_name' => 'تيمودي', 'en_name' => '', 'zip_code' => '0805']);
        // --- dayra_id=101 | dayra_name=العبادلة---//
        $Baladia = Baladia::create(['dayra_id' => 101, 'ar_name' => 'العبادلة', 'en_name' => '', 'zip_code' => '0817']);
        $Baladia = Baladia::create(['dayra_id' => 101, 'ar_name' => 'عرق فراج', 'en_name' => '', 'zip_code' => '0802']);
        $Baladia = Baladia::create(['dayra_id' => 101, 'ar_name' => 'مشرع هواري بومدين', 'en_name' => '', 'zip_code' => '0809']);
        // --- dayra_id=102 | dayra_name=القنادسة---//
        $Baladia = Baladia::create(['dayra_id' => 102, 'ar_name' => 'القنادسة', 'en_name' => '', 'zip_code' => '0810']);
        $Baladia = Baladia::create(['dayra_id' => 102, 'ar_name' => 'المريجة', 'en_name' => '', 'zip_code' => '0804']);
        // --- dayra_id=103 | dayra_name=لحمر---//
        $Baladia = Baladia::create(['dayra_id' => 103, 'ar_name' => 'لحمر', 'en_name' => '', 'zip_code' => '0806']);
        $Baladia = Baladia::create(['dayra_id' => 103, 'ar_name' => 'موغل', 'en_name' => '', 'zip_code' => '0816']);
        $Baladia = Baladia::create(['dayra_id' => 103, 'ar_name' => 'بوكايس', 'en_name' => '', 'zip_code' => '0815']);
        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=9
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=104 | dayra_name=الأربعاء---//
        $Baladia = Baladia::create(['dayra_id' => 104, 'ar_name' => 'صوحان', 'en_name' => '', 'zip_code' => '0917']);
        $Baladia = Baladia::create(['dayra_id' => 104, 'ar_name' => 'الأربعاء', 'en_name' => '', 'zip_code' => '0921']);
        // --- dayra_id=105 | dayra_name=أولاد يعيش---//
        $Baladia = Baladia::create(['dayra_id' => 105, 'ar_name' => 'أولاد يعيش', 'en_name' => '', 'zip_code' => '0907']);
        $Baladia = Baladia::create(['dayra_id' => 105, 'ar_name' => 'الشريعة', 'en_name' => '', 'zip_code' => '0908']);
        $Baladia = Baladia::create(['dayra_id' => 105, 'ar_name' => 'بني مراد', 'en_name' => '', 'zip_code' => '0925']);
        // --- dayra_id=106 | dayra_name=البليدة---//
        $Baladia = Baladia::create(['dayra_id' => 106, 'ar_name' => 'البليدة', 'en_name' => '', 'zip_code' => '0901	']);
        $Baladia = Baladia::create(['dayra_id' => 106, 'ar_name' => 'بوعرفة', 'en_name' => '', 'zip_code' => '0924']);
        // --- dayra_id=107 | dayra_name=بوينان---//
        $Baladia = Baladia::create(['dayra_id' => 107, 'ar_name' => 'شبلي', 'en_name' => '', 'zip_code' => '0902']);
        $Baladia = Baladia::create(['dayra_id' => 107, 'ar_name' => 'بوينان', 'en_name' => '', 'zip_code' => '0903']);
        // --- dayra_id=108 | dayra_name=بوفاريك---//
        $Baladia = Baladia::create(['dayra_id' => 108, 'ar_name' => 'الصومعة', 'en_name' => '', 'zip_code' => '0914']);
        $Baladia = Baladia::create(['dayra_id' => 108, 'ar_name' => 'بوفاريك', 'en_name' => '', 'zip_code' => '0920']);
        $Baladia = Baladia::create(['dayra_id' => 108, 'ar_name' => 'قرواو', 'en_name' => '', 'zip_code' => '0927']);
        // --- dayra_id=109 | dayra_name=بوقرة---//
        $Baladia = Baladia::create(['dayra_id' => 109, 'ar_name' => 'حمام ملوان', 'en_name' => '', 'zip_code' => '0912']);
        $Baladia = Baladia::create(['dayra_id' => 109, 'ar_name' => 'أولاد السلامة', 'en_name' => '', 'zip_code' => '0919']);
        $Baladia = Baladia::create(['dayra_id' => 109, 'ar_name' => 'بوقرة', 'en_name' => '', 'zip_code' => '0926']);
        // --- dayra_id=110 | dayra_name=العفرون---//
        $Baladia = Baladia::create(['dayra_id' => 110, 'ar_name' => 'العفرون', 'en_name' => '', 'zip_code' => '0910']);
        $Baladia = Baladia::create(['dayra_id' => 110, 'ar_name' => 'واد جر', 'en_name' => '', 'zip_code' => '0922']);
        // --- dayra_id=111 | dayra_name=مفتاح---//
        $Baladia = Baladia::create(['dayra_id' => 111, 'ar_name' => 'مفتاح', 'en_name' => '', 'zip_code' => '0918']);
        $Baladia = Baladia::create(['dayra_id' => 111, 'ar_name' => 'الجبابرة', 'en_name' => '', 'zip_code' => '0929']);
        // --- dayra_id=112 | dayra_name=موزاية---//
        $Baladia = Baladia::create(['dayra_id' => 112, 'ar_name' => 'الشفة', 'en_name' => '', 'zip_code' => '0911']);
        $Baladia = Baladia::create(['dayra_id' => 112, 'ar_name' => 'موزاية', 'en_name' => '', 'zip_code' => '0916']);
        $Baladia = Baladia::create(['dayra_id' => 112, 'ar_name' => 'عين الرمانة', 'en_name' => '', 'zip_code' => '0928	']);
        // --- dayra_id=113 | dayra_name=وادي العلايق---//
        $Baladia = Baladia::create(['dayra_id' => 113, 'ar_name' => 'وادي العلايق', 'en_name' => '', 'zip_code' => '0904']);
        $Baladia = Baladia::create(['dayra_id' => 113, 'ar_name' => 'بن خليل', 'en_name' => '', 'zip_code' => '0913']);
        $Baladia = Baladia::create(['dayra_id' => 113, 'ar_name' => 'بني تامو', 'en_name' => '', 'zip_code' => '0923']);
        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=10
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=114 | dayra_name=عين بسام---//
        $Baladia = Baladia::create(['dayra_id' => 114, 'ar_name' => 'عين بسام', 'en_name' => '', 'zip_code' => '10 024	']);
        $Baladia = Baladia::create(['dayra_id' => 114, 'ar_name' => 'عين العلوي', 'en_name' => '', 'zip_code' => '10 004	']);
        $Baladia = Baladia::create(['dayra_id' => 114, 'ar_name' => 'عين الحجر', 'en_name' => '', 'zip_code' => '10 034	']);
        // --- dayra_id=115 | dayra_name=بشلول---//
        $Baladia = Baladia::create(['dayra_id' => 115, 'ar_name' => 'بشلول', 'en_name' => '', 'zip_code' => '10 025']);
        $Baladia = Baladia::create(['dayra_id' => 115, 'ar_name' => 'الأصنام', 'en_name' => '', 'zip_code' => '10 005']);
        $Baladia = Baladia::create(['dayra_id' => 115, 'ar_name' => 'العجيبية', 'en_name' => '', 'zip_code' => '10 015']);
        $Baladia = Baladia::create(['dayra_id' => 115, 'ar_name' => 'أهل القصر', 'en_name' => '', 'zip_code' => '10 006']);
        $Baladia = Baladia::create(['dayra_id' => 115, 'ar_name' => 'أولاد راشد', 'en_name' => '', 'zip_code' => '10 006']);
        // --- dayra_id=116 | dayra_name=بئر غبالو---//
        $Baladia = Baladia::create(['dayra_id' => 116, 'ar_name' => 'بئر غبالو', 'en_name' => '', 'zip_code' => '10 002']);
        $Baladia = Baladia::create(['dayra_id' => 116, 'ar_name' => 'الروراوة', 'en_name' => '', 'zip_code' => '10 023']);
        $Baladia = Baladia::create(['dayra_id' => 116, 'ar_name' => 'الخبوزية', 'en_name' => '', 'zip_code' => '10 012']);
        // --- dayra_id=117 | dayra_name=برج أوخريص---//
        $Baladia = Baladia::create(['dayra_id' => 117, 'ar_name' => 'برج أوخريص', 'en_name' => '', 'zip_code' => '10 022']);
        $Baladia = Baladia::create(['dayra_id' => 117, 'ar_name' => 'مسدور', 'en_name' => '', 'zip_code' => '10 049']);
        $Baladia = Baladia::create(['dayra_id' => 117, 'ar_name' => 'تاقديت', 'en_name' => '', 'zip_code' => '10 049']);
        $Baladia = Baladia::create(['dayra_id' => 117, 'ar_name' => 'الحجرة الزرقاء', 'en_name' => '', 'zip_code' => '10 049']);
        // --- dayra_id=118 | dayra_name=البويرة---//
        $Baladia = Baladia::create(['dayra_id' => 118, 'ar_name' => 'البويرة', 'en_name' => '', 'zip_code' => '10 033']);
        $Baladia = Baladia::create(['dayra_id' => 118, 'ar_name' => 'عين الترك', 'en_name' => '', 'zip_code' => '10 013']);
        $Baladia = Baladia::create(['dayra_id' => 118, 'ar_name' => 'آيت لعزيز', 'en_name' => '', 'zip_code' => '10 013']);
        // --- dayra_id=119 | dayra_name=الهاشمية---//
        $Baladia = Baladia::create(['dayra_id' => 119, 'ar_name' => 'الهاشمية', 'en_name' => '', 'zip_code' => '10 001']);
        $Baladia = Baladia::create(['dayra_id' => 119, 'ar_name' => 'وادي البردي', 'en_name' => '', 'zip_code' => '10 051']);
        // --- dayra_id=120 | dayra_name=حيزر---//
        $Baladia = Baladia::create(['dayra_id' => 120, 'ar_name' => 'حيزر', 'en_name' => '', 'zip_code' => '10 050']);
        $Baladia = Baladia::create(['dayra_id' => 120, 'ar_name' => 'تاغزوت', 'en_name' => '', 'zip_code' => '10 050']);
        // --- dayra_id=121 | dayra_name=قادرية---//
        $Baladia = Baladia::create(['dayra_id' => 121, 'ar_name' => 'قادرية', 'en_name' => '', 'zip_code' => '10 029']);
        $Baladia = Baladia::create(['dayra_id' => 121, 'ar_name' => 'عمر', 'en_name' => '', 'zip_code' => '10 031']);
        $Baladia = Baladia::create(['dayra_id' => 121, 'ar_name' => 'الجباحية', 'en_name' => '', 'zip_code' => '10 030']);
        // --- dayra_id=122 | dayra_name=الأخضرية---//
        $Baladia = Baladia::create(['dayra_id' => 122, 'ar_name' => 'الأخضرية', 'en_name' => '', 'zip_code' => '10 020']);
        $Baladia = Baladia::create(['dayra_id' => 122, 'ar_name' => 'بوكرام', 'en_name' => '', 'zip_code' => '10 047']);
        $Baladia = Baladia::create(['dayra_id' => 122, 'ar_name' => 'معالة', 'en_name' => '', 'zip_code' => '10 037']);
        $Baladia = Baladia::create(['dayra_id' => 122, 'ar_name' => 'بودربالة', 'en_name' => '', 'zip_code' => '10 020']);
        $Baladia = Baladia::create(['dayra_id' => 122, 'ar_name' => 'الزبربر', 'en_name' => '', 'zip_code' => '10 047']);
        $Baladia = Baladia::create(['dayra_id' => 122, 'ar_name' => 'قرومة', 'en_name' => '', 'zip_code' => '10 037']);
        // --- dayra_id=123 | dayra_name=مشدا الله---//
        $Baladia = Baladia::create(['dayra_id' => 123, 'ar_name' => 'مشدا الله', 'en_name' => '', 'zip_code' => '10 040']);
        $Baladia = Baladia::create(['dayra_id' => 123, 'ar_name' => 'الصھاريج', 'en_name' => '', 'zip_code' => '10 018']);
        $Baladia = Baladia::create(['dayra_id' => 123, 'ar_name' => 'الشرفة', 'en_name' => '', 'zip_code' => '10 019']);
        $Baladia = Baladia::create(['dayra_id' => 123, 'ar_name' => 'الحانيف', 'en_name' => '', 'zip_code' => '10 019']);
        $Baladia = Baladia::create(['dayra_id' => 123, 'ar_name' => 'أغبالو', 'en_name' => '', 'zip_code' => '10 019']);
        $Baladia = Baladia::create(['dayra_id' => 123, 'ar_name' => 'آث منصور', 'en_name' => '', 'zip_code' => '10 019']);
        // --- dayra_id=124 | dayra_name=سوق الخميس---//
        $Baladia = Baladia::create(['dayra_id' => 124, 'ar_name' => 'سوق الخميس', 'en_name' => '', 'zip_code' => '10 017']);
        $Baladia = Baladia::create(['dayra_id' => 124, 'ar_name' => 'المقراني', 'en_name' => '', 'zip_code' => '10 028']);
        // --- dayra_id=125 | dayra_name=سور الغزلان---//
        $Baladia = Baladia::create(['dayra_id' => 125, 'ar_name' => 'سور الغزلان', 'en_name' => '', 'zip_code' => '10 044']);
        $Baladia = Baladia::create(['dayra_id' => 125, 'ar_name' => 'المعمورة', 'en_name' => '', 'zip_code' => '10 045']);
        $Baladia = Baladia::create(['dayra_id' => 125, 'ar_name' => 'ريدان', 'en_name' => '', 'zip_code' => '10 044']);
        $Baladia = Baladia::create(['dayra_id' => 125, 'ar_name' => 'الحاكمية', 'en_name' => '', 'zip_code' => '10 045']);
        $Baladia = Baladia::create(['dayra_id' => 125, 'ar_name' => 'الدشمية', 'en_name' => '', 'zip_code' => '10 044']);
        $Baladia = Baladia::create(['dayra_id' => 125, 'ar_name' => 'ديرة', 'en_name' => '', 'zip_code' => '10 045']);
        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=11
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=126 | dayra_name=أبلسة---//
        $Baladia = Baladia::create(['dayra_id' => 126, 'ar_name' => 'أبلسة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=127 | dayra_name=إن غار---//
        $Baladia = Baladia::create(['dayra_id' => 127, 'ar_name' => 'إن غار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=128 | dayra_name=تاظروك---//
        $Baladia = Baladia::create(['dayra_id' => 128, 'ar_name' => 'تاظروك', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 128, 'ar_name' => 'إدلس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=129 | dayra_name=تمنراست---//
        $Baladia = Baladia::create(['dayra_id' => 129, 'ar_name' => 'تمنراست', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 129, 'ar_name' => 'عين أمقل', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=130 | dayra_name=تين زاوتين---//
        $Baladia = Baladia::create(['dayra_id' => 130, 'ar_name' => 'تين زاوتين', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=131 | dayra_name=عين قزام---//
        $Baladia = Baladia::create(['dayra_id' => 131, 'ar_name' => 'عين قزام', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=12
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=132 | dayra_name=أم علي---//
        $Baladia = Baladia::create(['dayra_id' => 132, 'ar_name' => 'أم علي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 132, 'ar_name' => 'صفصاف الوسرى', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=133 | dayra_name=بئر العاتر---//
        $Baladia = Baladia::create(['dayra_id' => 133, 'ar_name' => 'العقلة المالحة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 133, 'ar_name' => 'بئر العاتر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=134 | dayra_name=بئر مقدم---//
        $Baladia = Baladia::create(['dayra_id' => 134, 'ar_name' => 'الحمامات', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 134, 'ar_name' => 'بئر مقدم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 134, 'ar_name' => 'قريقر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=135 | dayra_name=تبسة---//
        $Baladia = Baladia::create(['dayra_id' => 135, 'ar_name' => 'تبسة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=136 | dayra_name=تيارت---//
        $Baladia = Baladia::create(['dayra_id' => 136, 'ar_name' => 'تيارت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=137 | dayra_name=الشريعة---//
        $Baladia = Baladia::create(['dayra_id' => 137, 'ar_name' => 'الشريعة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 137, 'ar_name' => 'ثليجان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=138 | dayra_name=العقلة---//
        $Baladia = Baladia::create(['dayra_id' => 138, 'ar_name' => 'سطح قنطيس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 138, 'ar_name' => 'العقلة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 138, 'ar_name' => 'بجن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 138, 'ar_name' => 'المزرعة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=139 | dayra_name=العوينات---//
        $Baladia = Baladia::create(['dayra_id' => 139, 'ar_name' => 'العوينات', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 139, 'ar_name' => 'بوخضرة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=140 | dayra_name=الكويف---//
        $Baladia = Baladia::create(['dayra_id' => 140, 'ar_name' => 'الكويف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 140, 'ar_name' => 'بكارية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 140, 'ar_name' => 'بولحاف الدير', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=141 | dayra_name=الماء الأبيض---//
        $Baladia = Baladia::create(['dayra_id' => 141, 'ar_name' => 'الحويجبات', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 141, 'ar_name' => 'الماء الابيض', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=142 | dayra_name=مرسط---//
        $Baladia = Baladia::create(['dayra_id' => 142, 'ar_name' => 'مرسط', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 142, 'ar_name' => 'بئر الذهب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=143 | dayra_name=نقرين---//
        $Baladia = Baladia::create(['dayra_id' => 143, 'ar_name' => 'نقرين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 143, 'ar_name' => 'فركان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=144 | dayra_name=الونزة---//
        $Baladia = Baladia::create(['dayra_id' => 144, 'ar_name' => 'الونزة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 144, 'ar_name' => 'عين الزرقاء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 144, 'ar_name' => 'المريج', 'en_name' => '', 'zip_code' => '']);
        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=13
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=145 | dayra_name=تلمسان---//
        $Baladia = Baladia::create(['dayra_id' => 145, 'ar_name' => 'تلمسان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=146 | dayra_name=المنصورة---//
        $Baladia = Baladia::create(['dayra_id' => 146, 'ar_name' => 'تيرني بني ھديل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 146, 'ar_name' => 'عين غرابة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 146, 'ar_name' => 'المنصورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 146, 'ar_name' => 'بني مستار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=147 | dayra_name=شتوان---//
        $Baladia = Baladia::create(['dayra_id' => 147, 'ar_name' => 'شتوان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 147, 'ar_name' => 'عين فزة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 147, 'ar_name' => 'عمير', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=148 | dayra_name=أولاد ميمون---//
        $Baladia = Baladia::create(['dayra_id' => 148, 'ar_name' => 'أولاد ميمون', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 148, 'ar_name' => 'الواد الأخضر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 148, 'ar_name' => 'بني صميل', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=149 | dayra_name=عين تالوت---//
        $Baladia = Baladia::create(['dayra_id' => 149, 'ar_name' => 'عين تالوت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 149, 'ar_name' => 'عين نحالة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=150 | dayra_name=بن سكران---//
        $Baladia = Baladia::create(['dayra_id' => 150, 'ar_name' => 'بن سكران', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 150, 'ar_name' => 'سيدي العبدلي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=151 | dayra_name=الرمشي---//
        $Baladia = Baladia::create(['dayra_id' => 151, 'ar_name' => 'الرمشي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 151, 'ar_name' => 'بني ورسوس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 151, 'ar_name' => 'عين يوسف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 151, 'ar_name' => 'السبعة شيوخ', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 151, 'ar_name' => 'الفحول', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=152 | dayra_name=الحناية---//
        $Baladia = Baladia::create(['dayra_id' => 152, 'ar_name' => 'الحناية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 152, 'ar_name' => 'زناتة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 152, 'ar_name' => 'أولاد رياح', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=153 | dayra_name=الغزوات---//
        $Baladia = Baladia::create(['dayra_id' => 153, 'ar_name' => 'الغزوات', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 153, 'ar_name' => 'السواحلية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 153, 'ar_name' => 'تيانت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 153, 'ar_name' => 'دار يغمراسن', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=154 | dayra_name=ندرومة---//
        $Baladia = Baladia::create(['dayra_id' => 154, 'ar_name' => 'ندرومة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 154, 'ar_name' => 'جبالة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=155 | dayra_name=فلاوسن---//
        $Baladia = Baladia::create(['dayra_id' => 155, 'ar_name' => 'فلاوسن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 155, 'ar_name' => 'عين فتاح', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 155, 'ar_name' => 'عين الكبيرة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=156 | dayra_name=مغنية---//
        $Baladia = Baladia::create(['dayra_id' => 156, 'ar_name' => 'مغنية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 156, 'ar_name' => 'حمام بوغرارة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=157 | dayra_name=بني بوسعيد---//
        $Baladia = Baladia::create(['dayra_id' => 157, 'ar_name' => 'بني بوسعيد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 157, 'ar_name' => 'سيدي مجاهد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=158 | dayra_name=صبرة---//
        $Baladia = Baladia::create(['dayra_id' => 158, 'ar_name' => 'صبرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 158, 'ar_name' => 'بوحلو', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=159 | dayra_name=سبدو---//
        $Baladia = Baladia::create(['dayra_id' => 159, 'ar_name' => 'سبدو', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 159, 'ar_name' => 'القور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 159, 'ar_name' => 'العريشة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=160 | dayra_name=سيدي الجيلالي---//
        $Baladia = Baladia::create(['dayra_id' => 160, 'ar_name' => 'سيدي الجيلالي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 160, 'ar_name' => 'البويهي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=161 | dayra_name=بني سنوس---//
        $Baladia = Baladia::create(['dayra_id' => 161, 'ar_name' => 'بني سنوس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 161, 'ar_name' => 'العزايل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 161, 'ar_name' => 'بني بهدل', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=162 | dayra_name=باب العسة---//
        $Baladia = Baladia::create(['dayra_id' => 162, 'ar_name' => 'باب العسة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 162, 'ar_name' => 'السواني', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 162, 'ar_name' => 'سوق الثلاثاء', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=163 | dayra_name=مرسى بن مهيدي---//
        $Baladia = Baladia::create(['dayra_id' => 163, 'ar_name' => 'مرسى بن مهيدي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 163, 'ar_name' => 'مسيردة الفواقة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=164 | dayra_name=هنين---//
        $Baladia = Baladia::create(['dayra_id' => 164, 'ar_name' => 'هنين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 164, 'ar_name' => 'بني خلاد', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=14
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=165 | dayra_name=الرحوية---//
        $Baladia = Baladia::create(['dayra_id' => 165, 'ar_name' => 'الرحوية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 165, 'ar_name' => 'قرطوفة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=166 | dayra_name=السوقر---//
        $Baladia = Baladia::create(['dayra_id' => 166, 'ar_name' => 'السوقر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 166, 'ar_name' => 'سي عبد الغاني', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 166, 'ar_name' => 'توسنينة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 166, 'ar_name' => 'الفايجة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=167 | dayra_name=تيارت---//
        $Baladia = Baladia::create(['dayra_id' => 167, 'ar_name' => 'تيارت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=168 | dayra_name=حمادية---//
        $Baladia = Baladia::create(['dayra_id' => 168, 'ar_name' => 'حمادية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 168, 'ar_name' => 'الرشايقة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 168, 'ar_name' => 'بوقارة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=169 | dayra_name=دحموني---//
        $Baladia = Baladia::create(['dayra_id' => 169, 'ar_name' => 'الدحمونـــي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 169, 'ar_name' => 'عين بوشقيـف', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=170 | dayra_name=عين الذهب---//
        $Baladia = Baladia::create(['dayra_id' => 170, 'ar_name' => 'عين الذهب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 170, 'ar_name' => 'الشحيمة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 170, 'ar_name' => 'النعيمة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=171 | dayra_name=عين كرمس---//
        $Baladia = Baladia::create(['dayra_id' => 171, 'ar_name' => 'عين كرمس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 171, 'ar_name' => 'سي عبد الرحمان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 171, 'ar_name' => 'الرصفة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 171, 'ar_name' => 'مادنة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=172 | dayra_name=فرندة---//
        $Baladia = Baladia::create(['dayra_id' => 172, 'ar_name' => 'فرندة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 172, 'ar_name' => 'تاخمارت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 172, 'ar_name' => 'عين الحديد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=173 | dayra_name=قصر الشلالة---//
        $Baladia = Baladia::create(['dayra_id' => 173, 'ar_name' => 'قصر الشلالة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 173, 'ar_name' => 'سرغين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 173, 'ar_name' => 'الأمير عبد القادر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=174 | dayra_name=مدروسة---//
        $Baladia = Baladia::create(['dayra_id' => 174, 'ar_name' => 'مدروسة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 174, 'ar_name' => 'ملاكو', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 174, 'ar_name' => 'سيدي بختي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=175 | dayra_name=مشرع الصفاء---//
        $Baladia = Baladia::create(['dayra_id' => 175, 'ar_name' => 'مشرع الصفاء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 175, 'ar_name' => 'جيلالي بن عمار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 175, 'ar_name' => 'تاقدمت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=176 | dayra_name=مغيلة---//
        $Baladia = Baladia::create(['dayra_id' => 176, 'ar_name' => 'مغيلة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 176, 'ar_name' => 'سيد الحسنــــي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 176, 'ar_name' => 'السبـــت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=177 | dayra_name=مهدية---//
        $Baladia = Baladia::create(['dayra_id' => 177, 'ar_name' => 'مهدية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 177, 'ar_name' => 'عين دزاريت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 177, 'ar_name' => 'الناظورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 177, 'ar_name' => 'السبعين', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=178 | dayra_name=وادي ليلي---//
        $Baladia = Baladia::create(['dayra_id' => 178, 'ar_name' => 'واد ليلي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 178, 'ar_name' => 'سيدي علي ملال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 178, 'ar_name' => 'تيدة', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=15
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=179 | dayra_name=تيزي وزو---//
        $Baladia = Baladia::create(['dayra_id' => 179, 'ar_name' => 'تيزي وزو', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=180 | dayra_name=واسيف---//
        $Baladia = Baladia::create(['dayra_id' => 180, 'ar_name' => 'أيت بومهدي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 180, 'ar_name' => 'واسيف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 180, 'ar_name' => ' أيت تودرت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=181 | dayra_name=عين الحمام---//
        $Baladia = Baladia::create(['dayra_id' => 181, 'ar_name' => 'عين الحمام', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 181, 'ar_name' => 'اقبيل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 181, 'ar_name' => 'أيت يحيى', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 181, 'ar_name' => 'أبي يوسف', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=182 | dayra_name=عزازقة---//
        $Baladia = Baladia::create(['dayra_id' => 182, 'ar_name' => 'فريحة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 182, 'ar_name' => 'عزازقة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 182, 'ar_name' => 'إعــكورن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 182, 'ar_name' => 'زكري', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 182, 'ar_name' => 'إيفيغاء', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=183 | dayra_name=بوغني---//
        $Baladia = Baladia::create(['dayra_id' => 183, 'ar_name' => 'مشطراس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 183, 'ar_name' => 'بونوح', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 183, 'ar_name' => 'بوغني', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 183, 'ar_name' => 'أسي يوسف', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=184 | dayra_name=ذراع الميزان---//
        $Baladia = Baladia::create(['dayra_id' => 184, 'ar_name' => 'ذراع الميزان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 184, 'ar_name' => 'فريقات', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 184, 'ar_name' => 'عين الزاوية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 184, 'ar_name' => 'أيت يحي موسى', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=185 | dayra_name=واقنون---//
        $Baladia = Baladia::create(['dayra_id' => 185, 'ar_name' => 'تيمـيزار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 185, 'ar_name' => 'واقنون', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 185, 'ar_name' => 'أيت عيسى ميمون', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=186 | dayra_name=الأربعاء نايث إيراثن---//
        $Baladia = Baladia::create(['dayra_id' => 186, 'ar_name' => 'إيرجـــن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 186, 'ar_name' => 'الأربعاء نايث إيراثن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 186, 'ar_name' => 'أيت عقـواشة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=187 | dayra_name=ماكودة--- //
        $Baladia = Baladia::create(['dayra_id' => 187, 'ar_name' => 'ماكودة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 187, 'ar_name' => 'بوجيمة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=188 | dayra_name=أزفون---//
        $Baladia = Baladia::create(['dayra_id' => 188, 'ar_name' => 'أيت شافع', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 188, 'ar_name' => 'أزفون', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 188, 'ar_name' => 'أقرو', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 188, 'ar_name' => 'أغريب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=189 | dayra_name=ذراع بن خدة---//
        $Baladia = Baladia::create(['dayra_id' => 189, 'ar_name' => 'تادمايت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 189, 'ar_name' => 'سيدي نعمان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 189, 'ar_name' => 'ذراع بن خدة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 189, 'ar_name' => 'تيرمتين ', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=190 | dayra_name=تقزيرت---//
        $Baladia = Baladia::create(['dayra_id' => 190, 'ar_name' => 'تقزيرت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 190, 'ar_name' => 'إفليـــسن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 190, 'ar_name' => 'ميزرانـــة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=191 | dayra_name=بوزغن---//
        $Baladia = Baladia::create(['dayra_id' => 191, 'ar_name' => 'إيلولة أومـــالو', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 191, 'ar_name' => 'بوزغن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 191, 'ar_name' => 'بني زيكــي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 191, 'ar_name' => 'إيجــار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=192 | dayra_name=بني دوالة---//
        $Baladia = Baladia::create(['dayra_id' => 192, 'ar_name' => 'بني عيسي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 192, 'ar_name' => 'بنــــي زمنزار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 192, 'ar_name' => 'أيت محمود', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 192, 'ar_name' => 'بني دوالة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=193 | dayra_name=واضية---//
        $Baladia = Baladia::create(['dayra_id' => 193, 'ar_name' => 'واضية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 193, 'ar_name' => 'تيزي نثلاثة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 193, 'ar_name' => 'أقني قغران', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 193, 'ar_name' => 'أيت بــوادو', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=194 | dayra_name=المعاتقة---//
        $Baladia = Baladia::create(['dayra_id' => 194, 'ar_name' => 'المعاتقة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 194, 'ar_name' => 'سوق الإثنين', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=195 | dayra_name=مقلع---//
        $Baladia = Baladia::create(['dayra_id' => 195, 'ar_name' => 'صوامـــع', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 195, 'ar_name' => 'مقلع', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 195, 'ar_name' => 'أيت خليلي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=196 | dayra_name=بني يني---//
        $Baladia = Baladia::create(['dayra_id' => 196, 'ar_name' => 'يطــافن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 196, 'ar_name' => 'بني يني', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 196, 'ar_name' => 'إبودرارن', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=197 | dayra_name=تيزي راشد---//
        $Baladia = Baladia::create(['dayra_id' => 197, 'ar_name' => 'تيزي راشد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 197, 'ar_name' => 'أيت  أومالو', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=198 | dayra_name=إيفرحونن---//
        $Baladia = Baladia::create(['dayra_id' => 198, 'ar_name' => 'إيفرحونن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 198, 'ar_name' => 'إيلـيــلتـن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 198, 'ar_name' => 'إمســوحال', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=199 | dayra_name=تيزي غنيف---//
        $Baladia = Baladia::create(['dayra_id' => 199, 'ar_name' => 'تيزي غنيف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 199, 'ar_name' => 'مكيرة', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=16
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=200 | dayra_name=الحراش---//
        $Baladia = Baladia::create(['dayra_id' => 200, 'ar_name' => 'باش جراح', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 200, 'ar_name' => 'بوروبة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 200, 'ar_name' => 'الحراش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 200, 'ar_name' => 'وادي السمار', 'en_name' => 'Oued Smar', 'zip_code' => '']);
        // --- dayra_id=201 | dayra_name=الدار البيضاء---//
        $Baladia = Baladia::create(['dayra_id' => 201, 'ar_name' => 'عين طاية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 201, 'ar_name' => 'باب الزوار', 'en_name' => 'Bab Ezzouar', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 201, 'ar_name' => 'برج البحري', 'en_name' => 'Bordj El Bahri', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 201, 'ar_name' => 'برج الكيفان', 'en_name' => 'Bordj El Kiffan', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 201, 'ar_name' => 'الدار البيضاء', 'en_name' => 'Dar El Beïda', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 201, 'ar_name' => 'المرسى', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 201, 'ar_name' => 'المحمدية', 'en_name' => 'Mohammadia', 'zip_code' => '']);
        // --- dayra_id=202 | dayra_name=درارية---//
        $Baladia = Baladia::create(['dayra_id' => 202, 'ar_name' => 'بابا حسن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 202, 'ar_name' => 'دويرة', 'en_name' => 'Douera', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 202, 'ar_name' => 'الدرارية', 'en_name' => 'Draria', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 202, 'ar_name' => 'العاشور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 202, 'ar_name' => 'خرايسية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=203 | dayra_name=الرويبة---//
        $Baladia = Baladia::create(['dayra_id' => 203, 'ar_name' => 'هراوة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 203, 'ar_name' => 'الرغاية', 'en_name' => 'Reghaïa', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 203, 'ar_name' => 'الرويبة', 'en_name' => 'Rouïba', 'zip_code' => '']);
        // --- dayra_id=204 | dayra_name=الشراقة---//
        $Baladia = Baladia::create(['dayra_id' => 204, 'ar_name' => 'عين البنيان', 'en_name' => 'Aïn Benian', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 204, 'ar_name' => 'الشراقة', 'en_name' => 'Cheraga', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 204, 'ar_name' => 'دالي إبراهيم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 204, 'ar_name' => 'أولاد فايت', 'en_name' => 'Ouled Fayet', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 204, 'ar_name' => 'الحمامات', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=205 | dayra_name=بئر توتة---//
        $Baladia = Baladia::create(['dayra_id' => 205, 'ar_name' => 'بئر توتة', 'en_name' => 'Birtouta', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 205, 'ar_name' => 'أولاد شبل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 205, 'ar_name' => 'تسالة المرجة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=206 | dayra_name=بئر مراد رايس---//
        $Baladia = Baladia::create(['dayra_id' => 206, 'ar_name' => 'بئر مراد رايس', 'en_name' => 'Bir Mourad Raïs', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 206, 'ar_name' => 'بئر خادم', 'en_name' => 'Birkhadem', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 206, 'ar_name' => 'جسر قسنطينة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 206, 'ar_name' => 'حيدرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 206, 'ar_name' => 'سحاولة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=207 | dayra_name=باب الوادي---//
        $Baladia = Baladia::create(['dayra_id' => 207, 'ar_name' => 'باب الواد', 'en_name' => 'Bab El Oued', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 207, 'ar_name' => 'القصبة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 207, 'ar_name' => 'بولوغين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 207, 'ar_name' => 'واد قريش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 207, 'ar_name' => 'رايس حميدو', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=208 | dayra_name=براقي---//
        $Baladia = Baladia::create(['dayra_id' => 208, 'ar_name' => 'براقي', 'en_name' => 'Baraki', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 208, 'ar_name' => 'الكاليتوس', 'en_name' => 'Les Eucalyptus', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 208, 'ar_name' => 'سيدي موسى', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=209 | dayra_name=بوزريعة---//
        $Baladia = Baladia::create(['dayra_id' => 209, 'ar_name' => 'بن عكنون', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 209, 'ar_name' => 'بني مسوس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 209, 'ar_name' => 'بوزريعة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 209, 'ar_name' => 'الأبيار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=210 | dayra_name=حسين داي---//
        $Baladia = Baladia::create(['dayra_id' => 210, 'ar_name' => 'المقارية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 210, 'ar_name' => 'بلوزداد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 210, 'ar_name' => 'حسين داي', 'en_name' => 'Hussein Dey', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 210, 'ar_name' => 'القبة', 'en_name' => 'Kouba', 'zip_code' => '']);
        // --- dayra_id=211 | dayra_name=زرالدة---//
        $Baladia = Baladia::create(['dayra_id' => 211, 'ar_name' => 'المحالمة', 'en_name' => 'Mahelma', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 211, 'ar_name' => 'الرحمانية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 211, 'ar_name' => 'السويدانية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 211, 'ar_name' => 'سطاوالي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 211, 'ar_name' => 'زرالدة', 'en_name' => 'Zeralda', 'zip_code' => '']);
        // --- dayra_id=212 | dayra_name=سيدي امحمد---//
        $Baladia = Baladia::create(['dayra_id' => 212, 'ar_name' => 'الجزائر الوسطى', 'en_name' => 'Alger Centre', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 212, 'ar_name' => 'سيدي امحمد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 212, 'ar_name' => 'المدنية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 212, 'ar_name' => 'المرادية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=213 | dayra_name=الجزائر---//
        $Baladia = Baladia::create(['dayra_id' => 213, 'ar_name' => 'الجزائر', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=17
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=214 | dayra_name=أولاد دراج---//
        $Baladia = Baladia::create(['dayra_id' => 214, 'ar_name' => 'أولاد دراج', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=215 | dayra_name=أولاد سيدي إبراهيم---//
        $Baladia = Baladia::create(['dayra_id' => 215, 'ar_name' => 'أولاد سيدي إبراهيم', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=216 | dayra_name=الإدريسية---//
        $Baladia = Baladia::create(['dayra_id' => 216, 'ar_name' => 'الإدريسية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 216, 'ar_name' => 'دويس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 216, 'ar_name' => 'عين الشهداء', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=217 | dayra_name=البيرين---//
        $Baladia = Baladia::create(['dayra_id' => 217, 'ar_name' => 'بنهار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 217, 'ar_name' => 'البيرين', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=218 | dayra_name=الجلفة---//
        $Baladia = Baladia::create(['dayra_id' => 218, 'ar_name' => '', 'en_name' => 'الجلفة', 'zip_code' => '']);
        // --- dayra_id=219 | dayra_name=الشارف---//
        $Baladia = Baladia::create(['dayra_id' => 219, 'ar_name' => 'القديد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 219, 'ar_name' => 'الشارف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 219, 'ar_name' => 'بن يعقوب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=220 | dayra_name=حاسي بحبح---//
        $Baladia = Baladia::create(['dayra_id' => 220, 'ar_name' => 'حاسي بحبح', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 220, 'ar_name' => 'عين معبد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 220, 'ar_name' => 'حاسي العش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 220, 'ar_name' => 'زعفران', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=221 | dayra_name=حد الصحاري---//
        $Baladia = Baladia::create(['dayra_id' => 221, 'ar_name' => 'بويرة الأحداب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 221, 'ar_name' => 'حد الصحاري', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 221, 'ar_name' => 'عين فقه', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=222 | dayra_name=دار الشيوخ---//
        $Baladia = Baladia::create(['dayra_id' => 222, 'ar_name' => 'سيدي بايزيد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 222, 'ar_name' => 'مليليحة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 222, 'ar_name' => 'دار الشيوخ', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=223 | dayra_name=سيدي عيسى---//
        $Baladia = Baladia::create(['dayra_id' => 223, 'ar_name' => 'سيدي عيسى', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=224 | dayra_name=سيدي لعجال---//
        $Baladia = Baladia::create(['dayra_id' => 224, 'ar_name' => 'الخميس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 224, 'ar_name' => 'سيدي لعجال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 224, 'ar_name' => 'حاسي فدول', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=225 | dayra_name=عين الإبل---//
        $Baladia = Baladia::create(['dayra_id' => 225, 'ar_name' => 'مجبارة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 225, 'ar_name' => 'زكار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 225, 'ar_name' => 'عين الإبل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 225, 'ar_name' => 'تعظميت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=226 | dayra_name=عين وسارة---//
        $Baladia = Baladia::create(['dayra_id' => 226, 'ar_name' => 'قرنيني', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 226, 'ar_name' => 'عين وسارة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=227 | dayra_name=فيض البطمة---//
        $Baladia = Baladia::create(['dayra_id' => 227, 'ar_name' => 'فيض البطمة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 227, 'ar_name' => 'أم العظام', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 227, 'ar_name' => 'عمورة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=228 | dayra_name=مجدل---//
        $Baladia = Baladia::create(['dayra_id' => 228, 'ar_name' => 'مجدل', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=229 | dayra_name=مسعد---//
        $Baladia = Baladia::create(['dayra_id' => 229, 'ar_name' => 'مسعد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 229, 'ar_name' => 'قطارة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 229, 'ar_name' => 'سلمانة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 229, 'ar_name' => 'دلدول', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 229, 'ar_name' => 'سد الرحال', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=18
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=230 | dayra_name=جيجل---//
        $Baladia = Baladia::create(['dayra_id' => 230, 'ar_name' => 'جيجل', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=231 | dayra_name=السطارة---//
        $Baladia = Baladia::create(['dayra_id' => 231, 'ar_name' => '', 'en_name' => 'السطارة', 'zip_code' => '']);
        // --- dayra_id=232 | dayra_name=الشقفة---//
        $Baladia = Baladia::create(['dayra_id' => 232, 'ar_name' => 'الشقفة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 232, 'ar_name' => 'سيدي عبد العزيز', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=233 | dayra_name=الطاهير---//
        $Baladia = Baladia::create(['dayra_id' => 233, 'ar_name' => 'الطاهير', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 233, 'ar_name' => 'الامير عبد القادر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 233, 'ar_name' => 'الشحنة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 233, 'ar_name' => 'بوسيف أولاد عسكر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 233, 'ar_name' => 'وجانة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=234 | dayra_name=العنصر---//
        $Baladia = Baladia::create(['dayra_id' => 234, 'ar_name' => 'العنصر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 234, 'ar_name' => 'بوراوي بلهادف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 234, 'ar_name' => 'خيري واد عجول', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 234, 'ar_name' => 'الجمعة بني حبيبي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=235 | dayra_name=العوانة---//
        $Baladia = Baladia::create(['dayra_id' => 235, 'ar_name' => 'العوانة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 235, 'ar_name' => 'سلمى بن زيادة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=236 | dayra_name=الميلية---//
        $Baladia = Baladia::create(['dayra_id' => 236, 'ar_name' => 'الميلية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 236, 'ar_name' => 'أولاد يحيى خدروش', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=237 | dayra_name=تاكسنة---//
        $Baladia = Baladia::create(['dayra_id' => 237, 'ar_name' => 'تاكسنة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 237, 'ar_name' => 'قاوس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=238 | dayra_name=جيملة---//
        $Baladia = Baladia::create(['dayra_id' => 238, 'ar_name' => 'جيملة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 238, 'ar_name' => 'بودريعة بني  ياجيس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=239 | dayra_name=زيامة منصورية---//
        $Baladia = Baladia::create(['dayra_id' => 239, 'ar_name' => 'زيامة منصورية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 239, 'ar_name' => 'أراقن سويسي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=240 | dayra_name=سيدي معروف---//
        $Baladia = Baladia::create(['dayra_id' => 240, 'ar_name' => 'سيدي معروف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 240, 'ar_name' => 'أولاد رابح', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=19
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=241 | dayra_name=بني عزيز---//
        $Baladia = Baladia::create(['dayra_id' => 241, 'ar_name' => 'بني عزيز', 'en_name' => 'BENI AZIZ', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 241, 'ar_name' => 'عين السبت', 'en_name' => 'AIN SEBT', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 241, 'ar_name' => 'معاوية', 'en_name' => 'MAAOUIA', 'zip_code' => '']);
        // --- dayra_id=242 | dayra_name=العلمة---//
        $Baladia = Baladia::create(['dayra_id' => 242, 'ar_name' => 'العلمة', 'en_name' => 'EL EULMA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 242, 'ar_name' => 'بازر الصخرة', 'en_name' => 'BAZER SAKRA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 242, 'ar_name' => 'القلتة الزرقاء', 'en_name' => 'GUELTA ZERKA', 'zip_code' => '']);
        // --- dayra_id=243 | dayra_name=بئر العرش---//
        $Baladia = Baladia::create(['dayra_id' => 243, 'ar_name' => 'بئر العرش', 'en_name' => 'BIR EL ARCH', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 243, 'ar_name' => 'بلاعة', 'en_name' => 'BELLAA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 243, 'ar_name' => 'الولجة', 'en_name' => 'EL OULDJA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 243, 'ar_name' => 'تاشودة', 'en_name' => 'TACHOUDA', 'zip_code' => '']);
        // --- dayra_id=244 | dayra_name=بابور---//
        $Baladia = Baladia::create(['dayra_id' => 244, 'ar_name' => 'بابور', 'en_name' => 'BABOR', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 244, 'ar_name' => 'سرج الغول', 'en_name' => 'SERDJ EL GHOUL', 'zip_code' => '']);
        // --- dayra_id=245 | dayra_name=بني ورتيلان---//
        $Baladia = Baladia::create(['dayra_id' => 245, 'ar_name' => 'بني ورتيلان', 'en_name' => 'BENI OURTILANE', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 245, 'ar_name' => 'بني شبانة', 'en_name' => 'BENI CHEBANA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 245, 'ar_name' => 'بني محلي', 'en_name' => 'BENI MOUHLI', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 245, 'ar_name' => 'عين لقراج', 'en_name' => 'AIN LEGRADJ', 'zip_code' => '']);
        // --- dayra_id=246 | dayra_name=بوعنداس---//
        $Baladia = Baladia::create(['dayra_id' => 246, 'ar_name' => 'بوعنداس', 'en_name' => 'BOUANDAS', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 246, 'ar_name' => 'آيت نوال مزادة', 'en_name' => 'Ait Nawal Mzada', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 246, 'ar_name' => 'آيت تيزي', 'en_name' => 'AIT TIZI', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 246, 'ar_name' => 'بوسلام', 'en_name' => 'BOUSSELAM', 'zip_code' => '']);
        // --- dayra_id=247 | dayra_name=بوقاعة---//
        $Baladia = Baladia::create(['dayra_id' => 247, 'ar_name' => 'بوقاعة', 'en_name' => 'BOUGAA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 247, 'ar_name' => 'عين الروى', 'en_name' => 'AIN ROUA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 247, 'ar_name' => 'بني حسين', 'en_name' => 'BENI HOCINE', 'zip_code' => '']);
        // --- dayra_id=248 | dayra_name=جميلة---//
        $Baladia = Baladia::create(['dayra_id' => 248, 'ar_name' => '', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 248, 'ar_name' => '', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=249 | dayra_name=حمام السخنة---//
        $Baladia = Baladia::create(['dayra_id' => 249, 'ar_name' => 'حمام السخنة', 'en_name' => 'HAMMAM ESSOKHNA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 249, 'ar_name' => 'الطاية', 'en_name' => 'TAYA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 249, 'ar_name' => 'التلة', 'en_name' => 'TELLA', 'zip_code' => '']);
        // --- dayra_id=250 | dayra_name=حمام قرقور---//
        $Baladia = Baladia::create(['dayra_id' => 250, 'ar_name' => 'حمام قرقور', 'en_name' => 'HAMMAM GUERGOUR', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 250, 'ar_name' => 'ذراع قبيلة', 'en_name' => 'DRAA KEBILA', 'zip_code' => '']);
        // --- dayra_id=251 | dayra_name=سطيف---//
        $Baladia = Baladia::create(['dayra_id' => 251, 'ar_name' => 'سطيف', 'en_name' => 'SETIF', 'zip_code' => '19000']);
        // --- dayra_id=252 | dayra_name=صالح باي---//
        $Baladia = Baladia::create(['dayra_id' => 252, 'ar_name' => 'صالح باي', 'en_name' => 'SALAH BEY', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 252, 'ar_name' => 'بوطالب', 'en_name' => 'BOUTALEB', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 252, 'ar_name' => 'الحامة', 'en_name' => 'HAMMA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 252, 'ar_name' => 'أولاد تبان', 'en_name' => '	OULED TEBBEN', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 252, 'ar_name' => 'الرصفة', 'en_name' => 'ROSFA', 'zip_code' => '']);
        // --- dayra_id=253 | dayra_name=عموشة---//
        $Baladia = Baladia::create(['dayra_id' => 253, 'ar_name' => 'عموشة', 'en_name' => 'AMOUCHA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 253, 'ar_name' => 'واد البارد', 'en_name' => 'OUED EL BARAD', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 253, 'ar_name' => 'تيزي نبشار', 'en_name' => 'TIZI NBECHAR', 'zip_code' => '']);
        // --- dayra_id=254 | dayra_name=عين آزال---//
        $Baladia = Baladia::create(['dayra_id' => 254, 'ar_name' => 'عين آزال', 'en_name' => 'AIN AZAL', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 254, 'ar_name' => 'عين الحجر', 'en_name' => 'AIN LAHDJAR', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 254, 'ar_name' => 'بئر حدادة', 'en_name' => 'BIR HADDADA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 254, 'ar_name' => 'بيضاء برج', 'en_name' => 'BEIDHA BORDJ', 'zip_code' => '']);
        // --- dayra_id=255 | dayra_name=عين أرنات---//
        $Baladia = Baladia::create(['dayra_id' => 255, 'ar_name' => 'عين أرنات', 'en_name' => 'AIN ARNAT', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 255, 'ar_name' => 'مزلوق', 'en_name' => 'MEZLOUG', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 255, 'ar_name' => 'عين عباسة', 'en_name' => 'AIN ABESSA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 255, 'ar_name' => 'الأوريسية', 'en_name' => 'EL OURICIA', 'zip_code' => '']);
        // --- dayra_id=256 | dayra_name=عين الكبيرة---//
        $Baladia = Baladia::create(['dayra_id' => 256, 'ar_name' => 'عين الكبيرة', 'en_name' => 'AIN EL KEBIRA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 256, 'ar_name' => 'دهامشة', 'en_name' => 'DEHEMCHA', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 256, 'ar_name' => 'أولاد عدوان', 'en_name' => 'OULED ADDOUANE', 'zip_code' => '']);
        // --- dayra_id=257 | dayra_name=عين ولمان---//
        $Baladia = Baladia::create(['dayra_id' => 257, 'ar_name' => 'عين ولمان', 'en_name' => 'AIN OULMANE', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 257, 'ar_name' => 'قصر الأبطال', 'en_name' => 'KSAR EL ABTAL', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 257, 'ar_name' => 'قلال', 'en_name' => 'GUELLAL', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 257, 'ar_name' => 'أولاد سي أحمد', 'en_name' => 'OULED SI AHMED', 'zip_code' => '']);
        // --- dayra_id=258 | dayra_name=قجال---//
        $Baladia = Baladia::create(['dayra_id' => 258, 'ar_name' => 'قجال', 'en_name' => 'GUIDJEL', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 258, 'ar_name' => 'أولاد صابر', 'en_name' => 'OULED SABOR', 'zip_code' => '']);
        // --- dayra_id=259 | dayra_name=ماوكلان---//
        $Baladia = Baladia::create(['dayra_id' => 259, 'ar_name' => 'ماوكلان', 'en_name' => 'MAOUAKLANE', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 259, 'ar_name' => 'تالة ايفاسن', 'en_name' => 'TALAIFACENE', 'zip_code' => '']);
        // --- dayra_id=260 | dayra_name=قنزات---//
        $Baladia = Baladia::create(['dayra_id' => 260, 'ar_name' => 'قنزات', 'en_name' => 'GUENZET', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 260, 'ar_name' => 'حربيل', 'en_name' => 'HARBIL', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=20
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=261 | dayra_name=أولاد براهيم---//
        $Baladia = Baladia::create(['dayra_id' => 261, 'ar_name' => 'أولاد إبراهيم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 261, 'ar_name' => 'تيرسين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 261, 'ar_name' => 'عين السلطان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=262 | dayra_name=الحساسنة---//
        $Baladia = Baladia::create(['dayra_id' => 262, 'ar_name' => 'الحساسنة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 262, 'ar_name' => 'المعمورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 262, 'ar_name' => 'عين السخونة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=263 | dayra_name=سيدي بوبكر---//
        $Baladia = Baladia::create(['dayra_id' => 263, 'ar_name' => 'أولاد خالد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 263, 'ar_name' => 'هونت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 263, 'ar_name' => 'سيدي عمر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 263, 'ar_name' => 'سيدي بوبكر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=264 | dayra_name=عين الحجر---//
        $Baladia = Baladia::create(['dayra_id' => 264, 'ar_name' => 'عين الحجر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 264, 'ar_name' => 'مولاي العربي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 264, 'ar_name' => 'سيدي احمد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=265 | dayra_name=يوب---//
        $Baladia = Baladia::create(['dayra_id' => 265, 'ar_name' => 'دوي ثابت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 265, 'ar_name' => 'يوب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=266 | dayra_name=سعيدة---//
        $Baladia = Baladia::create(['dayra_id' => 266, 'ar_name' => 'سعيدة', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=21
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=267 | dayra_name=أم الطوب---//
        $Baladia = Baladia::create(['dayra_id' => 267, 'ar_name' => 'أم الطوب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=268 | dayra_name=الحدائق---//
        $Baladia = Baladia::create(['dayra_id' => 268, 'ar_name' => 'عين زويت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 268, 'ar_name' => 'الحدائق', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 268, 'ar_name' => 'بوشطاطة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=269 | dayra_name=الحروش---//
        $Baladia = Baladia::create(['dayra_id' => 269, 'ar_name' => 'الحروش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 269, 'ar_name' => 'زردازة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 269, 'ar_name' => 'أولاد حبابة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 269, 'ar_name' => 'مجاز الدشيش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 269, 'ar_name' => 'صالح بو الشعور', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=270 | dayra_name=القل---//
        $Baladia = Baladia::create(['dayra_id' => 270, 'ar_name' => 'القل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 270, 'ar_name' => 'بني زيد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 270, 'ar_name' => 'الشرايع', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=271 | dayra_name=بن عزوز---//
        $Baladia = Baladia::create(['dayra_id' => 271, 'ar_name' => 'بن عزوز', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 271, 'ar_name' => 'بكوش لخضر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 271, 'ar_name' => 'المرسى', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=272 | dayra_name=تمالوس---//
        $Baladia = Baladia::create(['dayra_id' => 272, 'ar_name' => 'الكركرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 272, 'ar_name' => 'تمالوس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 272, 'ar_name' => 'بين الويدان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=273 | dayra_name=رمضان جمال---//
        $Baladia = Baladia::create(['dayra_id' => 273, 'ar_name' => 'رمضان جمال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 273, 'ar_name' => 'بني بشير', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=274 | dayra_name=زيتونة---//
        $Baladia = Baladia::create(['dayra_id' => 274, 'ar_name' => 'زيتونة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 274, 'ar_name' => 'قنواع', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=275 | dayra_name=سكيكدة---//
        $Baladia = Baladia::create(['dayra_id' => 275, 'ar_name' => 'سكيكدة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 275, 'ar_name' => 'فلفلة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 275, 'ar_name' => 'حمادي كرومة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=276 | dayra_name=سيدي مزغيش---//
        $Baladia = Baladia::create(['dayra_id' => 276, 'ar_name' => 'سيدي مزغيش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 276, 'ar_name' => 'بني ولبان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 276, 'ar_name' => 'عين بوزيان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=277 | dayra_name=عزابة---//
        $Baladia = Baladia::create(['dayra_id' => 277, 'ar_name' => 'عزابة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 277, 'ar_name' => 'جندل سعدي محمد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 277, 'ar_name' => 'عين شرشار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 277, 'ar_name' => 'السبت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 277, 'ar_name' => 'الغدير', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=278 | dayra_name=عين قشرة---//
        $Baladia = Baladia::create(['dayra_id' => 278, 'ar_name' => 'عين قشرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 278, 'ar_name' => 'الولجة بولبلوط', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=279 | dayra_name=أولاد عطية---//
        $Baladia = Baladia::create(['dayra_id' => 279, 'ar_name' => 'أولاد عطية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 279, 'ar_name' => 'وادي الزهور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 279, 'ar_name' => 'خناق مايو', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=22
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=280 | dayra_name=بن باديس---//
        $Baladia = Baladia::create(['dayra_id' => 280, 'ar_name' => 'بضرابين المقراني', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 280, 'ar_name' => 'حاسي زهانة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 280, 'ar_name' => 'بن باديس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 280, 'ar_name' => 'شيطوان البلايلة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=281 | dayra_name=تسالة---//
        $Baladia = Baladia::create(['dayra_id' => 281, 'ar_name' => 'تسالة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 281, 'ar_name' => 'عين الثريد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 281, 'ar_name' => 'السهالة الثورة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=282 | dayra_name=تلاغ---//
        $Baladia = Baladia::create(['dayra_id' => 282, 'ar_name' => 'تلاغ', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 282, 'ar_name' => 'مزاورو', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 282, 'ar_name' => 'الضاية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 282, 'ar_name' => 'تغاليمت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=283 | dayra_name=تنيرة---//
        $Baladia = Baladia::create(['dayra_id' => 283, 'ar_name' => 'تنيرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 283, 'ar_name' => 'وادي سفيون', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 283, 'ar_name' => 'بن عشيبة شلية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 283, 'ar_name' => 'حاسي دحو', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=284 | dayra_name=رأس الماء---//
        $Baladia = Baladia::create(['dayra_id' => 284, 'ar_name' => 'راس الماء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 284, 'ar_name' => 'وادي السبع', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 284, 'ar_name' => 'رجم دموش', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=285 | dayra_name=سفيزف---//
        $Baladia = Baladia::create(['dayra_id' => 285, 'ar_name' => 'مسيد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 285, 'ar_name' => 'سفيزف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 285, 'ar_name' => 'عين أدن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 285, 'ar_name' => 'بوجبهة البرج', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=286 | dayra_name=سيدي بلعباس---//
        $Baladia = Baladia::create(['dayra_id' => 286, 'ar_name' => 'سيدي بلعباس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=287 | dayra_name=سيدي علي بن يوب---//
        $Baladia = Baladia::create(['dayra_id' => 287, 'ar_name' => 'سيدي علي بن يوب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 287, 'ar_name' => 'طابية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 287, 'ar_name' => 'بوخنفيس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=288 | dayra_name=سيدي علي بوسيدي---//
        $Baladia = Baladia::create(['dayra_id' => 288, 'ar_name' => 'لمطار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 288, 'ar_name' => 'سيدي علي بوسيدي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 288, 'ar_name' => 'عين قادة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 288, 'ar_name' => 'سيدي دحو الزاير', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=289 | dayra_name=سيدي لحسن---//
        $Baladia = Baladia::create(['dayra_id' => 289, 'ar_name' => 'العمارنة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 289, 'ar_name' => 'سيدي لحسن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 289, 'ar_name' => 'سيدي خالد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 289, 'ar_name' => 'سيدي يعقوب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=290 | dayra_name=عين البرد---//
        $Baladia = Baladia::create(['dayra_id' => 290, 'ar_name' => 'سيدي ابراهيم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 290, 'ar_name' => 'مكدرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 290, 'ar_name' => 'عين البرد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 290, 'ar_name' => 'سيدي حمادوش', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=291 | dayra_name=مرحوم---//
        $Baladia = Baladia::create(['dayra_id' => 291, 'ar_name' => 'مرحوم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 291, 'ar_name' => 'سيدي شعيب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 291, 'ar_name' => 'بئر الحمام', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=292 | dayra_name=مرين---//
        $Baladia = Baladia::create(['dayra_id' => 292, 'ar_name' => 'تفسور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 292, 'ar_name' => 'مرين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 292, 'ar_name' => 'وادي تاوريرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 292, 'ar_name' => 'تاودموت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=293 | dayra_name=مولاي سليسن---//
        $Baladia = Baladia::create(['dayra_id' => 293, 'ar_name' => 'مولاي سليسن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 293, 'ar_name' => 'الحصيبة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 293, 'ar_name' => 'عين تندمين', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=294 | dayra_name=مصطفى بن إبراهيم---//
        $Baladia = Baladia::create(['dayra_id' => 294, 'ar_name' => 'مصطفى بن ابراهيم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 294, 'ar_name' => 'تلموني', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 294, 'ar_name' => 'زروالة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 294, 'ar_name' => 'بلعربي', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=23
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=295 | dayra_name=البوني---//
        $Baladia = Baladia::create(['dayra_id' => 295, 'ar_name' => 'البوني', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=296 | dayra_name=الحجار---//
        $Baladia = Baladia::create(['dayra_id' => 296, 'ar_name' => 'الحجار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 296, 'ar_name' => 'سيدي عمار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=297 | dayra_name=برحال---//
        $Baladia = Baladia::create(['dayra_id' => 297, 'ar_name' => 'برحال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 297, 'ar_name' => 'واد العنب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 297, 'ar_name' => 'التريعات', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=298 | dayra_name=شطايبي---//
        $Baladia = Baladia::create(['dayra_id' => 298, 'ar_name' => 'شطايبي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=299 | dayra_name=عنابة---//
        $Baladia = Baladia::create(['dayra_id' => 299, 'ar_name' => 'سرايدي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 299, 'ar_name' => 'عنابة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=300 | dayra_name=الباردة---//
        $Baladia = Baladia::create(['dayra_id' => 300, 'ar_name' => 'الباردة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=301 | dayra_name=عين الباردة---//
        $Baladia = Baladia::create(['dayra_id' => 301, 'ar_name' => 'عين الباردة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 301, 'ar_name' => 'الشرفة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 301, 'ar_name' => 'العلمة', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=24
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=302 | dayra_name=بوشقوف---//
        $Baladia = Baladia::create(['dayra_id' => 302, 'ar_name' => 'وادي فراغة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 302, 'ar_name' => 'عين بن بيضاء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 302, 'ar_name' => 'بوشقوف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 302, 'ar_name' => 'مجاز الصفاء', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=303 | dayra_name=حمام النبايل---//
        $Baladia = Baladia::create(['dayra_id' => 303, 'ar_name' => 'الدهوارة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 303, 'ar_name' => 'حمام النبايل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 303, 'ar_name' => 'وادي الشحم', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=304 | dayra_name=حمام دباغ---//
        $Baladia = Baladia::create(['dayra_id' => 304, 'ar_name' => 'بوحمدان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 304, 'ar_name' => 'حمام دباغ', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 304, 'ar_name' => 'الركنية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=305 | dayra_name=عين مخلوف---//
        $Baladia = Baladia::create(['dayra_id' => 305, 'ar_name' => 'تاملوكة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 305, 'ar_name' => 'عين مخلوف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 305, 'ar_name' => 'عين العربي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=306 | dayra_name=قلعة بوصبع---//
        $Baladia = Baladia::create(['dayra_id' => 306, 'ar_name' => 'نشماية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 306, 'ar_name' => 'بلخير', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 306, 'ar_name' => 'بني مزلين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 306, 'ar_name' => 'قلعة بوصبع', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 306, 'ar_name' => 'بومهرة أحمد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 306, 'ar_name' => 'جبالة الخميسي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=307 | dayra_name=لخزارة---//
        $Baladia = Baladia::create(['dayra_id' => 307, 'ar_name' => 'عين صندل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 307, 'ar_name' => 'لخزارة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 307, 'ar_name' => 'بوحشانة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=308 | dayra_name=هيليوبوليس---//
        $Baladia = Baladia::create(['dayra_id' => 308, 'ar_name' => 'بوعاتي محمود', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 308, 'ar_name' => 'الفجوج', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 308, 'ar_name' => 'هيليوبوليس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=309 | dayra_name=وادي الزناتي---//
        $Baladia = Baladia::create(['dayra_id' => 309, 'ar_name' => 'وادي الزناتي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 309, 'ar_name' => 'عين رقادة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 309, 'ar_name' => 'برج صباط', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=310 | dayra_name=قالمة---//
        $Baladia = Baladia::create(['dayra_id' => 310, 'ar_name' => 'قالمة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 310, 'ar_name' => 'بن جراح', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=25
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=311 | dayra_name=قسنطينة---//
        $Baladia = Baladia::create(['dayra_id' => 311, 'ar_name' => 'قسنطينة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=312 | dayra_name=الخروب---//
        $Baladia = Baladia::create(['dayra_id' => 312, 'ar_name' => 'الخروب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 312, 'ar_name' => 'أولاد رحمون', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 312, 'ar_name' => 'عين السمارة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=313 | dayra_name=عين عبيد---//
        $Baladia = Baladia::create(['dayra_id' => 313, 'ar_name' => 'عين عبيد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 313, 'ar_name' => 'أبن باديس الهرية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=314 | dayra_name=زيغود يوسف---//
        $Baladia = Baladia::create(['dayra_id' => 314, 'ar_name' => 'زيغود يوسف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 314, 'ar_name' => 'بني حميدان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=315 | dayra_name=حامة بوزيان---//
        $Baladia = Baladia::create(['dayra_id' => 315, 'ar_name' => 'حامة بوزيان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 315, 'ar_name' => 'ديدوش مراد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=316 | dayra_name=ابن زياد---//
        $Baladia = Baladia::create(['dayra_id' => 316, 'ar_name' => 'ابن زياد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 316, 'ar_name' => 'بوجريو مسعود', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=26
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=317 | dayra_name=المدية---//
        $Baladia = Baladia::create(['dayra_id' => 317, 'ar_name' => 'المدية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 317, 'ar_name' => 'تمسقيدة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 317, 'ar_name' => 'ذراع السمار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=318 | dayra_name=وزرة---//
        $Baladia = Baladia::create(['dayra_id' => 318, 'ar_name' => 'وزرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 318, 'ar_name' => 'تيزي مهدي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 318, 'ar_name' => 'الحمدانية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 318, 'ar_name' => 'بن شكاو', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=319 | dayra_name=البرواقية---//
        $Baladia = Baladia::create(['dayra_id' => 319, 'ar_name' => 'البرواقية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 319, 'ar_name' => 'أولاد دايد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 319, 'ar_name' => 'الربعية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=320 | dayra_name=عوامري---//
        $Baladia = Baladia::create(['dayra_id' => 320, 'ar_name' => 'عوامري', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 320, 'ar_name' => 'حناشة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 320, 'ar_name' => 'وادي حربيل', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=321 | dayra_name=سغوان---//
        $Baladia = Baladia::create(['dayra_id' => 321, 'ar_name' => 'الزبيرية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 321, 'ar_name' => 'ثلاث دوائر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 321, 'ar_name' => 'سغوان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 321, 'ar_name' => 'مجبر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=322 | dayra_name=سي المحجوب---//
        $Baladia = Baladia::create(['dayra_id' => 322, 'ar_name' => 'سي المحجوب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 322, 'ar_name' => 'أولاد بوعشرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 322, 'ar_name' => 'بوعيشون', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=323 | dayra_name=العمارية---//
        $Baladia = Baladia::create(['dayra_id' => 323, 'ar_name' => 'العمارية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 323, 'ar_name' => 'أولاد إبراهيم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 323, 'ar_name' => 'بعطة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=324 | dayra_name=سيدي نعمان---//
        $Baladia = Baladia::create(['dayra_id' => 324, 'ar_name' => 'بوشراحيل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 324, 'ar_name' => 'خمس جوامع', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 324, 'ar_name' => 'سيدي نعمان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=325 | dayra_name=قصر البخاري---//
        $Baladia = Baladia::create(['dayra_id' => 325, 'ar_name' => 'سانق', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 325, 'ar_name' => 'قصر البخاري', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 325, 'ar_name' => 'المفاتحة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=326 | dayra_name=أولاد عنتر---//
        $Baladia = Baladia::create(['dayra_id' => 326, 'ar_name' => 'أولاد عنتر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 326, 'ar_name' => 'أولاد هلال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 326, 'ar_name' => 'بوغار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=327 | dayra_name=عزيز---//
        $Baladia = Baladia::create(['dayra_id' => 327, 'ar_name' => 'أم الجليل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 327, 'ar_name' => 'دراق', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 327, 'ar_name' => 'عزيز', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=328 | dayra_name=الشهبونية---//
        $Baladia = Baladia::create(['dayra_id' => 328, 'ar_name' => 'بو عيش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 328, 'ar_name' => 'بوغزول', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 328, 'ar_name' => 'الشهبونية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=329 | dayra_name=السواقي---//
        $Baladia = Baladia::create(['dayra_id' => 329, 'ar_name' => 'جواب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 329, 'ar_name' => 'السواقي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 329, 'ar_name' => 'سيدي زهار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 329, 'ar_name' => 'سيدي زيان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=330 | dayra_name=القلب الكبير---//
        $Baladia = Baladia::create(['dayra_id' => 330, 'ar_name' => 'بئر بن عابد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 330, 'ar_name' => 'سدراية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 330, 'ar_name' => 'القلب الكبير', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=331 | dayra_name=بني سليمان---//
        $Baladia = Baladia::create(['dayra_id' => 331, 'ar_name' => 'بني سليمان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 331, 'ar_name' => 'بوسكن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 331, 'ar_name' => 'سيدي الربيع', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=332 | dayra_name=تابلاط---//
        $Baladia = Baladia::create(['dayra_id' => 332, 'ar_name' => 'تابلاط', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 332, 'ar_name' => 'الحوضان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 332, 'ar_name' => 'العيساوية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 332, 'ar_name' => 'مزغنة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=333 | dayra_name=العزيزية---//
        $Baladia = Baladia::create(['dayra_id' => 333, 'ar_name' => 'العزيزية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 333, 'ar_name' => 'مغراوة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 333, 'ar_name' => 'ميهوب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=334 | dayra_name=شلالة العذاورة---//
        $Baladia = Baladia::create(['dayra_id' => 334, 'ar_name' => 'شلالة العذاورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 334, 'ar_name' => 'عين القصير', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 334, 'ar_name' => 'تافراوت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=335 | dayra_name=عين بوسيف---//
        $Baladia = Baladia::create(['dayra_id' => 335, 'ar_name' => 'أولاد معرف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 335, 'ar_name' => 'سيدي دامد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 335, 'ar_name' => 'العوينات', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 335, 'ar_name' => 'عين بوسيف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 335, 'ar_name' => 'لكاف الأخضر', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=27
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=336 | dayra_name=بوقيراط---//
        $Baladia = Baladia::create(['dayra_id' => 336, 'ar_name' => 'بوقيراط', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 336, 'ar_name' => 'سيرات', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 336, 'ar_name' => 'السوافلية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 336, 'ar_name' => 'صفصاف', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=337 | dayra_name=حاسي مماش---//
        $Baladia = Baladia::create(['dayra_id' => 337, 'ar_name' => 'ستيدية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 337, 'ar_name' => 'حاسي ماماش', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=338 | dayra_name=خير الدين---//
        $Baladia = Baladia::create(['dayra_id' => 338, 'ar_name' => 'صيادة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 338, 'ar_name' => 'خير الدين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 338, 'ar_name' => 'عين بودينار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=339 | dayra_name=مستغانم---//
        $Baladia = Baladia::create(['dayra_id' => 339, 'ar_name' => 'مستغانم', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=340 | dayra_name=سيدي علي---//
        $Baladia = Baladia::create(['dayra_id' => 340, 'ar_name' => 'سيدي علي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 340, 'ar_name' => 'أولاد مع الله', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 340, 'ar_name' => 'تزقايت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=341 | dayra_name=سيدي لخض---//
        $Baladia = Baladia::create(['dayra_id' => 341, 'ar_name' => 'بن عبد المالك رمضان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 341, 'ar_name' => 'حجاج', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 341, 'ar_name' => 'سيدي لخضر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=342 | dayra_name=عشعاشة---//
        $Baladia = Baladia::create(['dayra_id' => 342, 'ar_name' => 'نكمارية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 342, 'ar_name' => 'عشعاشة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 342, 'ar_name' => 'خضرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 342, 'ar_name' => 'أولاد بوغالم', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=343 | dayra_name=عين نويسي---//
        $Baladia = Baladia::create(['dayra_id' => 343, 'ar_name' => 'فرناقة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 343, 'ar_name' => 'عين نويسي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 343, 'ar_name' => 'الحسيان (بني ياحي)', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=344 | dayra_name=عين تادلس---//
        $Baladia = Baladia::create(['dayra_id' => 344, 'ar_name' => 'عين تادلس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 344, 'ar_name' => 'سور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 344, 'ar_name' => 'وادي الخير', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 344, 'ar_name' => 'سيدي بلعطار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=345 | dayra_name=ماسرة---//
        $Baladia = Baladia::create(['dayra_id' => 345, 'ar_name' => 'عين سيدي الشريف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 345, 'ar_name' => 'ماسرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 345, 'ar_name' => 'منصورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 345, 'ar_name' => 'الطواهرية', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=28
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=346 | dayra_name=المسيلة---//
        $Baladia = Baladia::create(['dayra_id' => 346, 'ar_name' => 'المسيلة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=347 | dayra_name=حمام الضلعة---//
        $Baladia = Baladia::create(['dayra_id' => 347, 'ar_name' => 'حمام الضلعة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 347, 'ar_name' => 'تارمونت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 347, 'ar_name' => 'ونوغة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 347, 'ar_name' => 'أولاد منصور', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=348 | dayra_name=أولاد دراج---//
        $Baladia = Baladia::create(['dayra_id' => 348, 'ar_name' => 'المعاضيد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 348, 'ar_name' => 'أولاد دراج', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 348, 'ar_name' => 'المطارفة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 348, 'ar_name' => 'أولاد عدي لقبالة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 348, 'ar_name' => 'السوامع', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=349 | dayra_name=سيدي عيسى---//
        $Baladia = Baladia::create(['dayra_id' => 349, 'ar_name' => 'سيدي عيسى', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 349, 'ar_name' => 'بوطي السايح', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 349, 'ar_name' => 'بني يلمان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=350 | dayra_name=عين الملح---//
        $Baladia = Baladia::create(['dayra_id' => 350, 'ar_name' => 'بئر فضة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 350, 'ar_name' => 'عين فارس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 350, 'ar_name' => 'سيدي امحمد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 350, 'ar_name' => 'عين الملح', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 350, 'ar_name' => 'عين الريش', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=351 | dayra_name=بن سرور---//
        $Baladia = Baladia::create(['dayra_id' => 351, 'ar_name' => 'بن سرور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 351, 'ar_name' => 'أولاد سليمان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 351, 'ar_name' => 'زرزور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 351, 'ar_name' => 'محمد بوضياف', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=352 | dayra_name=بوسعادة---//
        $Baladia = Baladia::create(['dayra_id' => 352, 'ar_name' => 'بوسعادة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 352, 'ar_name' => 'الهامل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 352, 'ar_name' => 'ولتام', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=353 | dayra_name=أولاد سيدي إبراهيم---//
        $Baladia = Baladia::create(['dayra_id' => 353, 'ar_name' => 'أولاد سيدي إبراهيم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 353, 'ar_name' => 'بن زوه', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=354 | dayra_name=سيدي عامر---//
        $Baladia = Baladia::create(['dayra_id' => 354, 'ar_name' => 'سيدي عامر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 354, 'ar_name' => 'تامسة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=355 | dayra_name=مقرة---//
        $Baladia = Baladia::create(['dayra_id' => 355, 'ar_name' => 'مقرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 355, 'ar_name' => 'برهوم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 355, 'ar_name' => 'عين الخضراء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 355, 'ar_name' => 'بلعايبة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 355, 'ar_name' => 'دهاهنة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=356 | dayra_name=شلال---//
        $Baladia = Baladia::create(['dayra_id' => 356, 'ar_name' => 'شلال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 356, 'ar_name' => 'أولاد ماضي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 356, 'ar_name' => 'معاريف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 356, 'ar_name' => 'خطوطي سد الجير', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=357 | dayra_name=خبانة---//
        $Baladia = Baladia::create(['dayra_id' => 357, 'ar_name' => 'خبانة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 357, 'ar_name' => 'مسيف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 357, 'ar_name' => 'الحوامد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=358 | dayra_name=امجدل---//
        $Baladia = Baladia::create(['dayra_id' => 358, 'ar_name' => 'امجدل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 358, 'ar_name' => 'مناعة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=359 | dayra_name=عين الحجل---//
        $Baladia = Baladia::create(['dayra_id' => 359, 'ar_name' => 'عين الحجل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 359, 'ar_name' => 'سيدي هجرس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=360 | dayra_name=جبل مساعد---//
        $Baladia = Baladia::create(['dayra_id' => 360, 'ar_name' => 'سليم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 360, 'ar_name' => 'جبل مساعد', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=29
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=361 | dayra_name=تيزي---//
        $Baladia = Baladia::create(['dayra_id' => 361, 'ar_name' => 'تيزي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 361, 'ar_name' => 'فروحة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 361, 'ar_name' => 'القرط', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=362 | dayra_name=البرج---//
        $Baladia = Baladia::create(['dayra_id' => 362, 'ar_name' => 'البرج', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 362, 'ar_name' => 'خلوية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 362, 'ar_name' => 'المنور', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=363 | dayra_name=المحمدية---//
        $Baladia = Baladia::create(['dayra_id' => 363, 'ar_name' => 'بلديـة المحمدية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 363, 'ar_name' => 'الغمري', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 363, 'ar_name' => 'سيدي عبد المومن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 363, 'ar_name' => 'فراقيق', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 363, 'ar_name' => 'سجرارةالغمري', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 363, 'ar_name' => 'مقطع الدوز', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=364 | dayra_name=الحشم---//
        $Baladia = Baladia::create(['dayra_id' => 364, 'ar_name' => 'الحشم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 364, 'ar_name' => 'زلامطة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 364, 'ar_name' => 'نسمط', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=365 | dayra_name=بوحنيفية---//
        $Baladia = Baladia::create(['dayra_id' => 365, 'ar_name' => 'بوحنيفية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 365, 'ar_name' => 'حسين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 365, 'ar_name' => 'القطنة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=366 | dayra_name=تيغنيف---//
        $Baladia = Baladia::create(['dayra_id' => 366, 'ar_name' => 'تيغنيف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 366, 'ar_name' => 'سيدي قادة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 366, 'ar_name' => 'السهايلية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=367 | dayra_name=زهانة---//
        $Baladia = Baladia::create(['dayra_id' => 367, 'ar_name' => 'القعدة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 367, 'ar_name' => 'زهانة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=368 | dayra_name=سيق---//
        $Baladia = Baladia::create(['dayra_id' => 368, 'ar_name' => 'سيق', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 368, 'ar_name' => 'بوهني', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 368, 'ar_name' => 'الشرفاء', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=369 | dayra_name=عقاز---//
        $Baladia = Baladia::create(['dayra_id' => 369, 'ar_name' => 'عقاز', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 369, 'ar_name' => 'العلايمية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 369, 'ar_name' => 'رأس عين عميروش', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=370 | dayra_name=عوف---//
        $Baladia = Baladia::create(['dayra_id' => 370, 'ar_name' => 'بنيان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 370, 'ar_name' => 'عوف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 370, 'ar_name' => 'غروس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=371 | dayra_name=غريس---//
        $Baladia = Baladia::create(['dayra_id' => 371, 'ar_name' => 'ماوسة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 371, 'ar_name' => 'غريس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 371, 'ar_name' => 'المطمور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 371, 'ar_name' => 'ماقضة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 371, 'ar_name' => 'سيدي بوسعيد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=372 | dayra_name=معسكر---//
        $Baladia = Baladia::create(['dayra_id' => 372, 'ar_name' => 'معسكر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=373 | dayra_name=وادي الأبطال---//
        $Baladia = Baladia::create(['dayra_id' => 373, 'ar_name' => 'وادي الأبطال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 373, 'ar_name' => 'عين فراح', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 373, 'ar_name' => 'سيدي عبد الجبار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=374 | dayra_name=وادي التاغية---//
        $Baladia = Baladia::create(['dayra_id' => 374, 'ar_name' => 'وادي التاغية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 374, 'ar_name' => 'قرجوم', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=375 | dayra_name=البرج---//
        $Baladia = Baladia::create(['dayra_id' => 375, 'ar_name' => 'البرج', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 375, 'ar_name' => 'خلوية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 375, 'ar_name' => 'المنور', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=376 | dayra_name=عين فارس---//
        $Baladia = Baladia::create(['dayra_id' => 376, 'ar_name' => 'عين فارس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 376, 'ar_name' => 'المأمونية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=377 | dayra_name=عين فكان---//
        $Baladia = Baladia::create(['dayra_id' => 377, 'ar_name' => 'عين فكان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 377, 'ar_name' => 'عين أفرص', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=30
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=378 | dayra_name=البرمة---//
        $Baladia = Baladia::create(['dayra_id' => 378, 'ar_name' => 'البرمة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=379 | dayra_name=النقوسة---//
        $Baladia = Baladia::create(['dayra_id' => 379, 'ar_name' => 'النقوسة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=380 | dayra_name=الحجيرة---//
        $Baladia = Baladia::create(['dayra_id' => 380, 'ar_name' => 'الحجيرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 380, 'ar_name' => 'العالية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=381 | dayra_name=الطيبات---//
        $Baladia = Baladia::create(['dayra_id' => 381, 'ar_name' => 'الطيبات', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 381, 'ar_name' => 'بن ناصر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 381, 'ar_name' => 'المنقر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=382 | dayra_name=تقرت---//
        $Baladia = Baladia::create(['dayra_id' => 382, 'ar_name' => 'تقرت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 382, 'ar_name' => 'تبسبست', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 382, 'ar_name' => 'النزلة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 382, 'ar_name' => 'الزاوية العابدية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=383 | dayra_name=تماسين---//
        $Baladia = Baladia::create(['dayra_id' => 383, 'ar_name' => 'تماسين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 383, 'ar_name' => 'بلدة اعمر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=384 | dayra_name=حاسي مسعود---//
        $Baladia = Baladia::create(['dayra_id' => 384, 'ar_name' => 'حاسي مسعود', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=385 | dayra_name=سيدي خويلد---//
        $Baladia = Baladia::create(['dayra_id' => 385, 'ar_name' => 'سيدي خويلد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 385, 'ar_name' => 'عين البيضاء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 385, 'ar_name' => 'حاسي بن عبد الله', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=386 | dayra_name=مقارين---//
        $Baladia = Baladia::create(['dayra_id' => 386, 'ar_name' => 'مقارين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 386, 'ar_name' => 'سيدي سليمان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=387 | dayra_name=ورقلة---//
        $Baladia = Baladia::create(['dayra_id' => 387, 'ar_name' => 'ورقلة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 387, 'ar_name' => 'الرويسات', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=31
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=388 | dayra_name=أرزيو---//
        $Baladia = Baladia::create(['dayra_id' => 388, 'ar_name' => 'أرزيو', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 388, 'ar_name' => 'سيدي بن يبقى', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=389 | dayra_name=بئر الجير---//
        $Baladia = Baladia::create(['dayra_id' => 389, 'ar_name' => 'بئر الجير', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 389, 'ar_name' => 'حاسي بونيف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 389, 'ar_name' => 'حاسي بن عقبة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=390 | dayra_name=بطيوة---//
        $Baladia = Baladia::create(['dayra_id' => 390, 'ar_name' => 'بطيوة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 390, 'ar_name' => 'مرسى الحجاج', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 390, 'ar_name' => 'عين البية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=391 | dayra_name=بوتليليس---//
        $Baladia = Baladia::create(['dayra_id' => 391, 'ar_name' => 'بوتليليس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 391, 'ar_name' => 'مسرغين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 391, 'ar_name' => 'عين الكرمة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=392 | dayra_name=السانية---//
        $Baladia = Baladia::create(['dayra_id' => 392, 'ar_name' => 'السانية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 392, 'ar_name' => 'سيدي الشحمي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 392, 'ar_name' => 'الكرمة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=393 | dayra_name=عين الترك---//
        $Baladia = Baladia::create(['dayra_id' => 393, 'ar_name' => 'عين الترك', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 393, 'ar_name' => 'المرسى الكبير', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 393, 'ar_name' => 'بوسفر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 393, 'ar_name' => 'العنصر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=394 | dayra_name=قديل---//
        $Baladia = Baladia::create(['dayra_id' => 394, 'ar_name' => 'قديل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 394, 'ar_name' => 'بن فريحة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 394, 'ar_name' => 'حاسي مفسوخ', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=395 | dayra_name=وادي تليلات---//
        $Baladia = Baladia::create(['dayra_id' => 395, 'ar_name' => 'وادي تليلات', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 395, 'ar_name' => 'طفراوي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 395, 'ar_name' => 'بوفاتيس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 395, 'ar_name' => 'البراية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=396 | dayra_name=وهران---//
        $Baladia = Baladia::create(['dayra_id' => 396, 'ar_name' => 'وهران', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=32
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=397 | dayra_name=الأبيض سيدي الشيخ---//
        $Baladia = Baladia::create(['dayra_id' => 397, 'ar_name' => 'الأبيض سيدي الشيخ', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=398 | dayra_name=بريزينة---//
        $Baladia = Baladia::create(['dayra_id' => 398, 'ar_name' => 'بريزينة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=399 | dayra_name=بوسمغون---//
        $Baladia = Baladia::create(['dayra_id' => 399, 'ar_name' => 'بوسمغون', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 399, 'ar_name' => 'البنود', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 399, 'ar_name' => 'كراكدة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 399, 'ar_name' => 'بوعلام', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 399, 'ar_name' => 'ستيتن', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=400 | dayra_name=بوعلام---//
        $Baladia = Baladia::create(['dayra_id' => 400, 'ar_name' => 'بريزينة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 400, 'ar_name' => 'اربوات', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 400, 'ar_name' => 'الشقيق', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=401 | dayra_name=بوقطب---//
        $Baladia = Baladia::create(['dayra_id' => 401, 'ar_name' => 'الخيثر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 401, 'ar_name' => 'الكاف الأحمر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 401, 'ar_name' => 'شلالة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 401, 'ar_name' => 'المحرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 401, 'ar_name' => 'الغاسول', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=402 | dayra_name=البيض---//
        $Baladia = Baladia::create(['dayra_id' => 402, 'ar_name' => 'البيض', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=403 | dayra_name=الرقاصة---//
        $Baladia = Baladia::create(['dayra_id' => 403, 'ar_name' => 'الرقاصة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 403, 'ar_name' => 'بوقطب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 403, 'ar_name' => 'سيدي طيفور', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=404 | dayra_name=الشلالة---//
        $Baladia = Baladia::create(['dayra_id' => 404, 'ar_name' => 'الشلالة', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=33
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=405 | dayra_name=إليزي---//
        $Baladia = Baladia::create(['dayra_id' => 405, 'ar_name' => 'إليزي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=406 | dayra_name=جانت---//
        $Baladia = Baladia::create(['dayra_id' => 406, 'ar_name' => 'جانت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 406, 'ar_name' => 'برج الحواس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=407 | dayra_name=إن أميناس---//
        $Baladia = Baladia::create(['dayra_id' => 407, 'ar_name' => 'إن أميناس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 407, 'ar_name' => 'برج عمر إدريس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 407, 'ar_name' => 'دبداب', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=34
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=408 | dayra_name=برج بوعريريج---//
        $Baladia = Baladia::create(['dayra_id' => 408, 'ar_name' => 'برج بوعريرج', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=409 | dayra_name=رأس الوادي---//
        $Baladia = Baladia::create(['dayra_id' => 409, 'ar_name' => 'رأس الوادي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 409, 'ar_name' => 'أولاد أبراهم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 409, 'ar_name' => 'عين تسرة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=410 | dayra_name=برج زمورة---//
        $Baladia = Baladia::create(['dayra_id' => 410, 'ar_name' => 'برج زمورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 410, 'ar_name' => 'أولاد دحمان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 410, 'ar_name' => 'تسامرت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=411 | dayra_name=المنصورة---//
        $Baladia = Baladia::create(['dayra_id' => 411, 'ar_name' => 'المنصورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 411, 'ar_name' => 'المهير', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 411, 'ar_name' => 'بن داود', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 411, 'ar_name' => 'أولاد سيدي ابراهيم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 411, 'ar_name' => 'حرازة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=412 | dayra_name=مجانة---//
        $Baladia = Baladia::create(['dayra_id' => 412, 'ar_name' => 'الياشير', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 412, 'ar_name' => 'مجانة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 412, 'ar_name' => 'ثنية النصر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 412, 'ar_name' => 'حسناوة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=413 | dayra_name=الحمادية---//
        $Baladia = Baladia::create(['dayra_id' => 413, 'ar_name' => 'الحمادية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 413, 'ar_name' => 'القصور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 413, 'ar_name' => 'العش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 413, 'ar_name' => 'الرابطة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=414 | dayra_name=عين تاغروت---//
        $Baladia = Baladia::create(['dayra_id' => 414, 'ar_name' => 'عين تاغروت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 414, 'ar_name' => 'تيكستار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=415 | dayra_name=بئر قاصد علي---//
        $Baladia = Baladia::create(['dayra_id' => 415, 'ar_name' => 'بئر قاصد علي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 415, 'ar_name' => 'سيدي أمبارك', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 415, 'ar_name' => 'خليل', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=416 | dayra_name=الجعافرة---//
        $Baladia = Baladia::create(['dayra_id' => 416, 'ar_name' => 'جعافرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 416, 'ar_name' => 'الماين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 416, 'ar_name' => 'تفرق', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 416, 'ar_name' => 'القلة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=417 | dayra_name=برج الغدير---//
        $Baladia = Baladia::create(['dayra_id' => 417, 'ar_name' => 'غيلاسة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 417, 'ar_name' => 'العناصر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 417, 'ar_name' => 'تقلعيت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 417, 'ar_name' => 'بليمور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 417, 'ar_name' => 'برج الغدير', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 417, 'ar_name' => '', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=35
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=418 | dayra_name=بومرداس---//
        $Baladia = Baladia::create(['dayra_id' => 418, 'ar_name' => 'بومرداس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 418, 'ar_name' => 'تيجلابين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 418, 'ar_name' => 'قورصو', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=419 | dayra_name=برج منايل---//
        $Baladia = Baladia::create(['dayra_id' => 419, 'ar_name' => 'زموري', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 419, 'ar_name' => 'لقاطة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 419, 'ar_name' => 'برج منايل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 419, 'ar_name' => 'جنات', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=420 | dayra_name=بودواو---//
        $Baladia = Baladia::create(['dayra_id' => 420, 'ar_name' => 'بودواو', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 420, 'ar_name' => 'بوزقزة قدارة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 420, 'ar_name' => 'بودواو البحري', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 420, 'ar_name' => 'أولاد هداج', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 420, 'ar_name' => 'الخروبة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=421 | dayra_name=دلس---//
        $Baladia = Baladia::create(['dayra_id' => 421, 'ar_name' => 'دلس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 421, 'ar_name' => 'بن شود', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 421, 'ar_name' => 'أعفير', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=422 | dayra_name=الثنية---//
        $Baladia = Baladia::create(['dayra_id' => 422, 'ar_name' => 'الثنية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 422, 'ar_name' => 'عمال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 422, 'ar_name' => 'بني عمران', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 422, 'ar_name' => 'سوق الحد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 422, 'ar_name' => '', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=423 | dayra_name=يسر---//
        $Baladia = Baladia::create(['dayra_id' => 423, 'ar_name' => 'يسر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 423, 'ar_name' => 'سي مصطفى', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 423, 'ar_name' => 'شعبة العامر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 423, 'ar_name' => 'تيمزريت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=424 | dayra_name=خميس الخشنة---//
        $Baladia = Baladia::create(['dayra_id' => 424, 'ar_name' => 'خميس الخشنة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 424, 'ar_name' => 'أولاد موسى', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 424, 'ar_name' => 'الاربعطاش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 424, 'ar_name' => 'حمادي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=425 | dayra_name=الناصرية---//
        $Baladia = Baladia::create(['dayra_id' => 425, 'ar_name' => 'الناصرية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 425, 'ar_name' => 'أولاد عيسى', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=426 | dayra_name=بغلية---//
        $Baladia = Baladia::create(['dayra_id' => 426, 'ar_name' => 'بغلية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 426, 'ar_name' => 'سيدي داود', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 426, 'ar_name' => 'تاورقة', 'en_name' => '', 'zip_code' => '']);
        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=36
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=427 | dayra_name=البسباس---//
        $Baladia = Baladia::create(['dayra_id' => 427, 'ar_name' => 'البسباس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 427, 'ar_name' => 'عصفور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 427, 'ar_name' => 'زريزر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=428 | dayra_name=بن مهيدي---//
        $Baladia = Baladia::create(['dayra_id' => 428, 'ar_name' => 'الشط', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 428, 'ar_name' => 'بريحان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 428, 'ar_name' => 'بن مهيدي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=429 | dayra_name=بوثلجة---//
        $Baladia = Baladia::create(['dayra_id' => 429, 'ar_name' => 'بوثلجة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 429, 'ar_name' => 'بحيرة الطيور', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 429, 'ar_name' => 'الشافية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=430 | dayra_name=بوحجار---//
        $Baladia = Baladia::create(['dayra_id' => 430, 'ar_name' => 'بوحجار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 430, 'ar_name' => 'عين الكرمة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 430, 'ar_name' => 'وادي الزيتون', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 430, 'ar_name' => 'حمام بني صالح', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=431 | dayra_name=الذرعان---//
        $Baladia = Baladia::create(['dayra_id' => 431, 'ar_name' => 'الذرعان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 431, 'ar_name' => 'شحاني', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 431, 'ar_name' => 'شبيطة مختار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=432 | dayra_name=الطارف---//
        $Baladia = Baladia::create(['dayra_id' => 432, 'ar_name' => 'الطارف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 432, 'ar_name' => 'بوقوس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 432, 'ar_name' => 'عين العسل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 432, 'ar_name' => 'الزيتونة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=433 | dayra_name=القالة---//
        $Baladia = Baladia::create(['dayra_id' => 433, 'ar_name' => 'القالة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 433, 'ar_name' => 'رمل السوق', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 433, 'ar_name' => 'العيون', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 433, 'ar_name' => 'السوارخ', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=37
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=434 | dayra_name=تيندوف---//
        $Baladia = Baladia::create(['dayra_id' => 434, 'ar_name' => 'تيندوف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 434, 'ar_name' => 'أم العسل', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=38
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=435 | dayra_name=الأزهرية---//
        $Baladia = Baladia::create(['dayra_id' => 435, 'ar_name' => 'الأزهرية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 435, 'ar_name' => 'الأربعاء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 435, 'ar_name' => 'بوقائد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=436 | dayra_name=برج الأمير عبد القادر---//
        $Baladia = Baladia::create(['dayra_id' => 436, 'ar_name' => 'برج الأمير عبد القادر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 436, 'ar_name' => 'اليوسفية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=437 | dayra_name=برج بونعامة---//
        $Baladia = Baladia::create(['dayra_id' => 437, 'ar_name' => 'بني لحسن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 437, 'ar_name' => 'سيدي سليمان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 437, 'ar_name' => 'بني شعيب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 437, 'ar_name' => 'برج بونعامة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=438 | dayra_name=تيسمسيلت---//
        $Baladia = Baladia::create(['dayra_id' => 438, 'ar_name' => 'تيسمسيلت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 438, 'ar_name' => 'أولاد بسام', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=439 | dayra_name=ثنية الأحد---//
        $Baladia = Baladia::create(['dayra_id' => 439, 'ar_name' => 'ثنية الأحد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 439, 'ar_name' => 'سيدي بوتوشنت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=440 | dayra_name=خميستي---//
        $Baladia = Baladia::create(['dayra_id' => 440, 'ar_name' => 'خميستي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 440, 'ar_name' => 'العيون', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=441 | dayra_name=عماري---//
        $Baladia = Baladia::create(['dayra_id' => 441, 'ar_name' => 'عماري', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 441, 'ar_name' => 'المعاصم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 441, 'ar_name' => 'سيدي عابد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=442 | dayra_name=لرجام---//
        $Baladia = Baladia::create(['dayra_id' => 442, 'ar_name' => 'لرجام', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 442, 'ar_name' => 'تملاحت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 442, 'ar_name' => 'الملعب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 442, 'ar_name' => 'سيدي العنتري', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=39
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=443 | dayra_name=اميه وانسة---//
        $Baladia = Baladia::create(['dayra_id' => 443, 'ar_name' => 'اميه وانسة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 443, 'ar_name' => 'وادي العلندة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=444 | dayra_name=البياضة---//
        $Baladia = Baladia::create(['dayra_id' => 444, 'ar_name' => 'البياضة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=445 | dayra_name=الدبيلة---//
        $Baladia = Baladia::create(['dayra_id' => 445, 'ar_name' => 'الدبيلة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 445, 'ar_name' => 'حساني عبد الكريم', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=446 | dayra_name=الرباح---//
        $Baladia = Baladia::create(['dayra_id' => 446, 'ar_name' => 'الرباح', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 446, 'ar_name' => 'العقلة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 446, 'ar_name' => 'النخلة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=447 | dayra_name=الرقيبة---//
        $Baladia = Baladia::create(['dayra_id' => 447, 'ar_name' => 'الرقيبة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 447, 'ar_name' => 'الحمراية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=448 | dayra_name=المقرن---//
        $Baladia = Baladia::create(['dayra_id' => 448, 'ar_name' => 'المقرن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 448, 'ar_name' => 'سيدي عون', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=449 | dayra_name=الوادي---//
        $Baladia = Baladia::create(['dayra_id' => 449, 'ar_name' => 'الوادي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 449, 'ar_name' => 'كوينين', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=450 | dayra_name=حاسي خليفة---//
        $Baladia = Baladia::create(['dayra_id' => 450, 'ar_name' => 'حاسي خليفة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 450, 'ar_name' => 'الطريفاوي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=451 | dayra_name=طالب العربي---//
        $Baladia = Baladia::create(['dayra_id' => 451, 'ar_name' => 'طالب العربي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 451, 'ar_name' => 'دوار الماء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 451, 'ar_name' => 'بن قشة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=452 | dayra_name=قمار---//
        $Baladia = Baladia::create(['dayra_id' => 452, 'ar_name' => 'قمار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 452, 'ar_name' => 'تغزوت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 452, 'ar_name' => 'ورماس', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=40
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=453 | dayra_name=أولاد رشاش---//
        $Baladia = Baladia::create(['dayra_id' => 453, 'ar_name' => 'أولاد رشاش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 453, 'ar_name' => 'المحمل', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=454 | dayra_name=الحامة---//
        $Baladia = Baladia::create(['dayra_id' => 454, 'ar_name' => 'الحامة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 454, 'ar_name' => 'بغاي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 454, 'ar_name' => 'طامزة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 454, 'ar_name' => 'انسيغة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=455 | dayra_name=بابار---//
        $Baladia = Baladia::create(['dayra_id' => 455, 'ar_name' => 'بابار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=456 | dayra_name=بوحمامة---//
        $Baladia = Baladia::create(['dayra_id' => 456, 'ar_name' => 'بوحمامة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 456, 'ar_name' => 'مصارة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 456, 'ar_name' => 'يابوس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=457 | dayra_name=خنشلة---//
        $Baladia = Baladia::create(['dayra_id' => 457, 'ar_name' => 'خنشلة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=458 | dayra_name=عين الطويلة---//
        $Baladia = Baladia::create(['dayra_id' => 458, 'ar_name' => 'عين الطويلة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 458, 'ar_name' => 'متوسة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=459 | dayra_name=قايس---//
        $Baladia = Baladia::create(['dayra_id' => 459, 'ar_name' => 'قايس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 459, 'ar_name' => 'تاوزيانت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 459, 'ar_name' => 'الرميلة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=460 | dayra_name=ششار---//
        $Baladia = Baladia::create(['dayra_id' => 460, 'ar_name' => 'ششار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 460, 'ar_name' => 'الولجة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 460, 'ar_name' => 'جلال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 460, 'ar_name' => 'خيران', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=41
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=461 | dayra_name=أم العظائم---//
        $Baladia = Baladia::create(['dayra_id' => 461, 'ar_name' => 'أم العظائم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 461, 'ar_name' => 'وادي الكبريت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 461, 'ar_name' => 'ترقالت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=462 | dayra_name=أولاد إدريس---//
        $Baladia = Baladia::create(['dayra_id' => 462, 'ar_name' => 'أولاد إدريس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 462, 'ar_name' => 'عين الزانة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=463 | dayra_name=بئر بوحوش---//
        $Baladia = Baladia::create(['dayra_id' => 463, 'ar_name' => 'بئر بوحوش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 463, 'ar_name' => 'سافل الويدان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 463, 'ar_name' => 'الزوابي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=464 | dayra_name=تاورة---//
        $Baladia = Baladia::create(['dayra_id' => 464, 'ar_name' => 'الزعرورية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 464, 'ar_name' => 'تاورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 464, 'ar_name' => 'الدريعة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=465 | dayra_name=الحدادة---//
        $Baladia = Baladia::create(['dayra_id' => 465, 'ar_name' => 'الحدادة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 465, 'ar_name' => 'الخضارة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 465, 'ar_name' => 'أولاد مومن', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=466 | dayra_name=سدراتة---//
        $Baladia = Baladia::create(['dayra_id' => 466, 'ar_name' => 'خميسة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 466, 'ar_name' => 'عين سلطان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 466, 'ar_name' => 'سدراتة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=467 | dayra_name=سوق أهراس---//
        $Baladia = Baladia::create(['dayra_id' => 467, 'ar_name' => 'سوق أهراس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=468 | dayra_name=مداوروش---//
        $Baladia = Baladia::create(['dayra_id' => 468, 'ar_name' => 'مداوروش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 468, 'ar_name' => 'تيفاش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 468, 'ar_name' => 'الراقوبة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=469 | dayra_name=المراهنة---//
        $Baladia = Baladia::create(['dayra_id' => 469, 'ar_name' => 'المراهنة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 469, 'ar_name' => 'سيدي فرج', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 469, 'ar_name' => 'سيدي فرج', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=470 | dayra_name=المشروحة---//
        $Baladia = Baladia::create(['dayra_id' => 470, 'ar_name' => 'المشروحة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 470, 'ar_name' => 'الحنانشة', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=42
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=471 | dayra_name=الداموس---//
        $Baladia = Baladia::create(['dayra_id' => 471, 'ar_name' => 'الأرهاط', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 471, 'ar_name' => 'الداموس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 471, 'ar_name' => 'بني ميلك', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=472 | dayra_name=القليعة---//
        $Baladia = Baladia::create(['dayra_id' => 472, 'ar_name' => 'القليعة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 472, 'ar_name' => 'الحطاطبة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 472, 'ar_name' => 'الشعيبة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=473 | dayra_name=بو إسماعيل---//
        $Baladia = Baladia::create(['dayra_id' => 473, 'ar_name' => 'بواسماعيل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 473, 'ar_name' => 'خميستي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 473, 'ar_name' => 'عين تاقورايت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 473, 'ar_name' => 'بوهارون', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=474 | dayra_name=تيبازة---//
        $Baladia = Baladia::create(['dayra_id' => 474, 'ar_name' => 'تيبازة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=475 | dayra_name=حجوط---//
        $Baladia = Baladia::create(['dayra_id' => 475, 'ar_name' => 'حجوط', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 475, 'ar_name' => 'مراد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=476 | dayra_name=حمر العين---//
        $Baladia = Baladia::create(['dayra_id' => 476, 'ar_name' => 'حمر العين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 476, 'ar_name' => 'سيدي راشد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 476, 'ar_name' => 'بورقيقة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=477 | dayra_name=سيدي اعمر---//
        $Baladia = Baladia::create(['dayra_id' => 477, 'ar_name' => 'سيدي اعمر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 477, 'ar_name' => 'مناصر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 477, 'ar_name' => 'سيدي عامر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 477, 'ar_name' => 'الناظور', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=478 | dayra_name=شرشال---//
        $Baladia = Baladia::create(['dayra_id' => 478, 'ar_name' => 'شرشال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 478, 'ar_name' => 'سيدي غيلاس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 478, 'ar_name' => 'سيدي سميان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 478, 'ar_name' => 'حجرة النص', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=479 | dayra_name=فوكة---//
        $Baladia = Baladia::create(['dayra_id' => 479, 'ar_name' => 'فوكة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 479, 'ar_name' => 'دواودة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=480 | dayra_name=قوراية---//
        $Baladia = Baladia::create(['dayra_id' => 480, 'ar_name' => 'قوراية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 480, 'ar_name' => 'أغبال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 480, 'ar_name' => 'مسلمون', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=43
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=481 | dayra_name=التلاغمة---//
        $Baladia = Baladia::create(['dayra_id' => 481, 'ar_name' => 'التلاغمة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 481, 'ar_name' => 'وادي سقان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 481, 'ar_name' => 'مشيرة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=482 | dayra_name=القرارم قوقة---//
        $Baladia = Baladia::create(['dayra_id' => 482, 'ar_name' => 'القرارم قوقة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 482, 'ar_name' => 'حمالة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=483 | dayra_name=الرواشد---//
        $Baladia = Baladia::create(['dayra_id' => 483, 'ar_name' => 'الرواشد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 483, 'ar_name' => 'تيبرقنت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=484 | dayra_name=بوحاتم---//
        $Baladia = Baladia::create(['dayra_id' => 484, 'ar_name' => 'بوحاتم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 484, 'ar_name' => 'دراحي بوصلاح', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=485 | dayra_name=تاجنانت---//
        $Baladia = Baladia::create(['dayra_id' => 485, 'ar_name' => 'تاجنانت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 485, 'ar_name' => 'بن يحي عبد الرحمن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 485, 'ar_name' => 'أولاد اخلوف', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=486 | dayra_name=ترعي باينان---//
        $Baladia = Baladia::create(['dayra_id' => 486, 'ar_name' => 'ترعي باينان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 486, 'ar_name' => 'اعميرة اراس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 486, 'ar_name' => 'تسالة لمطاعي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=487 | dayra_name=تسدان حدادة---//
        $Baladia = Baladia::create(['dayra_id' => 487, 'ar_name' => 'تسدان حدادة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 487, 'ar_name' => 'مينار زارزة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=488 | dayra_name=سيدي مروان---//
        $Baladia = Baladia::create(['dayra_id' => 488, 'ar_name' => 'سيدي مروان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 488, 'ar_name' => 'الشيقارة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=489 | dayra_name=فرجيوة---//
        $Baladia = Baladia::create(['dayra_id' => 489, 'ar_name' => 'فرجيوة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 489, 'ar_name' => 'يحي بني قشة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=490 | dayra_name=وادي النجاء---//
        $Baladia = Baladia::create(['dayra_id' => 490, 'ar_name' => 'وادي النجاء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 490, 'ar_name' => 'أحمد راشدي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=491 | dayra_name=شلغوم العيد---//
        $Baladia = Baladia::create(['dayra_id' => 491, 'ar_name' => 'شلغوم العيد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 491, 'ar_name' => 'عين الملوك', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 491, 'ar_name' => 'وادي العثمانية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=492 | dayra_name=عين البيضاء حريش---//
        $Baladia = Baladia::create(['dayra_id' => 492, 'ar_name' => 'عين البيضاء أحريش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 492, 'ar_name' => 'العياضي برباس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=493 | dayra_name=ميلة---//
        $Baladia = Baladia::create(['dayra_id' => 493, 'ar_name' => 'ميلة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 493, 'ar_name' => 'سيدي خليفة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 493, 'ar_name' => 'عين التين', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=44
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=494 | dayra_name=الروينة---//
        $Baladia = Baladia::create(['dayra_id' => 494, 'ar_name' => 'الروينة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 494, 'ar_name' => 'زدين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 494, 'ar_name' => 'الماين', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=495 | dayra_name=العامرة---//
        $Baladia = Baladia::create(['dayra_id' => 495, 'ar_name' => 'العامرة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 495, 'ar_name' => 'المخاطرية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 495, 'ar_name' => 'عريب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=496 | dayra_name=العبادية---//
        $Baladia = Baladia::create(['dayra_id' => 496, 'ar_name' => 'العبادية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 496, 'ar_name' => 'عين بويحيى', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 496, 'ar_name' => 'تاشتة زقاغة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=497 | dayra_name=العطاف---//
        $Baladia = Baladia::create(['dayra_id' => 497, 'ar_name' => 'العطاف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 497, 'ar_name' => 'تبركانين', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=498 | dayra_name=برج الأمير خالد---//
        $Baladia = Baladia::create(['dayra_id' => 498, 'ar_name' => 'برج الأمير خالد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 498, 'ar_name' => 'بئر ولد خليفة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 498, 'ar_name' => 'طارق بن زياد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=499 | dayra_name=بطحية---//
        $Baladia = Baladia::create(['dayra_id' => 499, 'ar_name' => 'بطحية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 499, 'ar_name' => 'الحسانية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 499, 'ar_name' => 'بلعاص', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=500 | dayra_name=بومدفع---//
        $Baladia = Baladia::create(['dayra_id' => 500, 'ar_name' => 'بومدفع', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 500, 'ar_name' => 'الحسينية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=501 | dayra_name=جليدة---//
        $Baladia = Baladia::create(['dayra_id' => 501, 'ar_name' => 'جليدة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 501, 'ar_name' => 'بوراشد', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 501, 'ar_name' => 'جمعة أولاد الشيخ', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=502 | dayra_name=جندل---//
        $Baladia = Baladia::create(['dayra_id' => 502, 'ar_name' => 'جندل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 502, 'ar_name' => 'بربوش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 502, 'ar_name' => 'وادي الشرفاء', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=503 | dayra_name=حمام ريغة---//
        $Baladia = Baladia::create(['dayra_id' => 503, 'ar_name' => 'حمام ريغة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 503, 'ar_name' => 'عين البنيان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 503, 'ar_name' => 'عين التركي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=504 | dayra_name=خميس مليانة---//
        $Baladia = Baladia::create(['dayra_id' => 504, 'ar_name' => 'خميس مليانة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=505 | dayra_name=عين الدفلة---//
        $Baladia = Baladia::create(['dayra_id' => 505, 'ar_name' => 'سيدي الأخضر', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=506 | dayra_name=عين لشياخ---//
        $Baladia = Baladia::create(['dayra_id' => 506, 'ar_name' => 'عين الأشياخ', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 506, 'ar_name' => 'واد الجمعة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 506, 'ar_name' => 'عين السلطان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=507 | dayra_name=مليانة---//
        $Baladia = Baladia::create(['dayra_id' => 507, 'ar_name' => 'مليانة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 507, 'ar_name' => 'بن علال', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=45
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=508 | dayra_name=المشرية---//
        $Baladia = Baladia::create(['dayra_id' => 508, 'ar_name' => 'المشرية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 508, 'ar_name' => 'عين بن خليل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 508, 'ar_name' => 'البيوض', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=509 | dayra_name=النعامة---//
        $Baladia = Baladia::create(['dayra_id' => 509, 'ar_name' => 'النعامة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=510 | dayra_name=صفيصيفة---//
        $Baladia = Baladia::create(['dayra_id' => 510, 'ar_name' => 'صفيصيفة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=511 | dayra_name=عسلة---//
        $Baladia = Baladia::create(['dayra_id' => 511, 'ar_name' => 'عسلة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=512 | dayra_name=عين الصفراء---//
        $Baladia = Baladia::create(['dayra_id' => 512, 'ar_name' => 'عين الصفراء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 512, 'ar_name' => 'تيوت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=513 | dayra_name=مغرار---//
        $Baladia = Baladia::create(['dayra_id' => 513, 'ar_name' => 'مغرار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 513, 'ar_name' => 'جنين بورزق', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=514 | dayra_name=مكمن بن عمار---//
        $Baladia = Baladia::create(['dayra_id' => 514, 'ar_name' => 'مكمن بن عمار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 514, 'ar_name' => 'القصدير', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=46
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=515 | dayra_name=العامرية---//
        $Baladia = Baladia::create(['dayra_id' => 515, 'ar_name' => 'العامرية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 515, 'ar_name' => 'بوزجار', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 515, 'ar_name' => 'أولاد بوجمعة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 515, 'ar_name' => 'حاسي الغلة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 515, 'ar_name' => 'المساعيد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=516 | dayra_name=المالح---//
        $Baladia = Baladia::create(['dayra_id' => 516, 'ar_name' => 'المالح', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 516, 'ar_name' => 'تارقة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 516, 'ar_name' => 'شعبة اللحم', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 516, 'ar_name' => 'أولاد الكيحل', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=517 | dayra_name=بني صاف---//
        $Baladia = Baladia::create(['dayra_id' => 517, 'ar_name' => 'بني صاف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 517, 'ar_name' => 'الأمير عبد القادر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 517, 'ar_name' => 'سيدي صافي', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=518 | dayra_name=حمام بوحجر---//
        $Baladia = Baladia::create(['dayra_id' => 518, 'ar_name' => 'حمام بوحجر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 518, 'ar_name' => 'الحساسنة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 518, 'ar_name' => 'شنتوف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 518, 'ar_name' => 'وادي برقش', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=519 | dayra_name=عين الاربعاء---//
        $Baladia = Baladia::create(['dayra_id' => 519, 'ar_name' => 'عين الاربعاء', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 519, 'ar_name' => 'تامزورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 519, 'ar_name' => 'سيدي بومدين', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 519, 'ar_name' => 'وادي الصباح', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=520 | dayra_name=عين الكيحل---//
        $Baladia = Baladia::create(['dayra_id' => 520, 'ar_name' => 'عين الكيحل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 520, 'ar_name' => 'أغلال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 520, 'ar_name' => 'عقب الليل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 520, 'ar_name' => 'عين الطلبة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=521 | dayra_name=عين تموشنت---//
        $Baladia = Baladia::create(['dayra_id' => 521, 'ar_name' => 'عين تموشنت', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 521, 'ar_name' => 'سيدي بن عدة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=522 | dayra_name=ولهاصة الغرابة---//
        $Baladia = Baladia::create(['dayra_id' => 522, 'ar_name' => 'ولهاصة الغرابة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 522, 'ar_name' => 'سيدي ورياش', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=47
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=523 | dayra_name=بريان---//
        $Baladia = Baladia::create(['dayra_id' => 523, 'ar_name' => 'بريان', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=524 | dayra_name=بونورة---//
        $Baladia = Baladia::create(['dayra_id' => 524, 'ar_name' => 'بونورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 524, 'ar_name' => 'العطف', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=525 | dayra_name=زلفانة---//
        $Baladia = Baladia::create(['dayra_id' => 525, 'ar_name' => 'زلفانة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=526 | dayra_name=ضاية بن ضحوة---//
        $Baladia = Baladia::create(['dayra_id' => 526, 'ar_name' => 'ضاية بن ضحوة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=527 | dayra_name=غرداية---//
        $Baladia = Baladia::create(['dayra_id' => 527, 'ar_name' => 'غرداية', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=528 | dayra_name=القرارة---//
        $Baladia = Baladia::create(['dayra_id' => 528, 'ar_name' => 'القرارة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=529 | dayra_name=متليلي---//
        $Baladia = Baladia::create(['dayra_id' => 529, 'ar_name' => 'متليلي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 529, 'ar_name' => 'سبسب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=530 | dayra_name=المنصورة---//
        $Baladia = Baladia::create(['dayra_id' => 530, 'ar_name' => 'المنصورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 530, 'ar_name' => 'حاسي الفحل', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=48
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=531 | dayra_name=الحمادنة---//
        $Baladia = Baladia::create(['dayra_id' => 531, 'ar_name' => 'الحمادنة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 531, 'ar_name' => 'وادي الجمعة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=532 | dayra_name=الرمكة---//
        $Baladia = Baladia::create(['dayra_id' => 532, 'ar_name' => 'الرمكة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 532, 'ar_name' => 'سوق الحد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=533 | dayra_name=المطمر---//
        $Baladia = Baladia::create(['dayra_id' => 533, 'ar_name' => 'المطمر', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 533, 'ar_name' => 'سيدي خطاب', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 533, 'ar_name' => 'سيدي امحمد بن عودة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=534 | dayra_name=جديوية---//
        $Baladia = Baladia::create(['dayra_id' => 534, 'ar_name' => 'جديوية', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 534, 'ar_name' => 'حمري', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 534, 'ar_name' => 'أولاد سيدي الميهوب', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=535 | dayra_name=زمورة---//
        $Baladia = Baladia::create(['dayra_id' => 535, 'ar_name' => 'زمورة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 535, 'ar_name' => 'بني درقن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 535, 'ar_name' => 'دار بن عبد الله', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=536 | dayra_name=سيدي امحمد بن علي---//
        $Baladia = Baladia::create(['dayra_id' => 536, 'ar_name' => 'سيدي امحمد بن علي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 536, 'ar_name' => 'مديونة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 536, 'ar_name' => 'بني زنطيس', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=537 | dayra_name=عمي موسى---//
        $Baladia = Baladia::create(['dayra_id' => 537, 'ar_name' => 'عمي موسى', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 537, 'ar_name' => 'أولاد يعيش', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 537, 'ar_name' => 'الحاسي', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 537, 'ar_name' => 'الولجة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=538 | dayra_name=عين طارق---//
        $Baladia = Baladia::create(['dayra_id' => 538, 'ar_name' => 'عين طارق', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 538, 'ar_name' => 'حد الشكالة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=539 | dayra_name=غليزان---//
        $Baladia = Baladia::create(['dayra_id' => 539, 'ar_name' => 'غليزان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 539, 'ar_name' => 'بن داود', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=540 | dayra_name=مازونة---//
        $Baladia = Baladia::create(['dayra_id' => 540, 'ar_name' => 'مازونة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 540, 'ar_name' => 'القطار', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=541 | dayra_name=منداس---//
        $Baladia = Baladia::create(['dayra_id' => 541, 'ar_name' => 'منداس', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 541, 'ar_name' => 'وادي السلام', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 541, 'ar_name' => 'سيدي لزرق', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=542 | dayra_name=وادي ارهيو---//
        $Baladia = Baladia::create(['dayra_id' => 542, 'ar_name' => 'وادي ارهيو', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 542, 'ar_name' => 'واريزان', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 542, 'ar_name' => 'لحلاف', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 542, 'ar_name' => 'مرجة سيدي عابد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=543 | dayra_name=يلل---//
        $Baladia = Baladia::create(['dayra_id' => 543, 'ar_name' => 'يلل', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 543, 'ar_name' => 'عين الرحمة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 543, 'ar_name' => 'القلعة', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 543, 'ar_name' => 'سيدي سعادة', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=49
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=544 | dayra_name=أوقروت---//
        $Baladia = Baladia::create(['dayra_id' => 544, 'ar_name' => 'أوقروت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=545 | dayra_name=تيميمون---//
        $Baladia = Baladia::create(['dayra_id' => 545, 'ar_name' => 'تيميمون', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=546 | dayra_name=تينركوك---//
        $Baladia = Baladia::create(['dayra_id' => 546, 'ar_name' => 'تينركوك', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=547 | dayra_name=شروين---//
        $Baladia = Baladia::create(['dayra_id' => 547, 'ar_name' => 'شروين', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=50
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=548 | dayra_name=برج باجي مختار---//
        $Baladia = Baladia::create(['dayra_id' => 548, 'ar_name' => 'برج باجي مختار', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=51
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=549 | dayra_name=سيدي خالد---//
        $Baladia = Baladia::create(['dayra_id' => 549, 'ar_name' => 'سيدي خالد', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=550 | dayra_name=أولاد جلال---//
        $Baladia = Baladia::create(['dayra_id' => 550, 'ar_name' => 'أولاد جلال', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 550, 'ar_name' => 'الدوسن', 'en_name' => '', 'zip_code' => '']);
        $Baladia = Baladia::create(['dayra_id' => 550, 'ar_name' => 'الشعيبة', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=52
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=551 | dayra_name=بني عباس---//
        $Baladia = Baladia::create(['dayra_id' => 551, 'ar_name' => 'بني عباس', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=53
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=552 | dayra_name=عين صالح---//
        $Baladia = Baladia::create(['dayra_id' => 552, 'ar_name' => 'عين صالح', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=553 | dayra_name=إن غار---//
        $Baladia = Baladia::create(['dayra_id' => 553, 'ar_name' => 'إن غار', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=54
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=554 | dayra_name=عين قزام---//
        $Baladia = Baladia::create(['dayra_id' => 554, 'ar_name' => 'عين قزام', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=555 | dayra_name=تين زاوتين---//
        $Baladia = Baladia::create(['dayra_id' => 555, 'ar_name' => 'تين زاوتين', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=55
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=556 | dayra_name=تقرت---//
        $Baladia = Baladia::create(['dayra_id' => 556, 'ar_name' => 'تقرت', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=557 | dayra_name=تماسين---//
        $Baladia = Baladia::create(['dayra_id' => 557, 'ar_name' => 'تماسين', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=558 | dayra_name=مقارين---//
        $Baladia = Baladia::create(['dayra_id' => 558, 'ar_name' => 'مقارين', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=559 | dayra_name=الطيبات---//
        $Baladia = Baladia::create(['dayra_id' => 559, 'ar_name' => 'الطيبات', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=560 | dayra_name=الحجيرة---//
        $Baladia = Baladia::create(['dayra_id' => 560, 'ar_name' => 'الحجيرة', 'en_name' => '', 'zip_code' => '']);
        // --- dayra_id=561 | dayra_name=البرمة---//
        $Baladia = Baladia::create(['dayra_id' => 561, 'ar_name' => 'البرمة', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=56
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=562 | dayra_name=جانت---//
        $Baladia = Baladia::create(['dayra_id' => 562, 'ar_name' => 'جانت', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=57
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=563 | dayra_name=المغير---//
        $Baladia = Baladia::create(['dayra_id' => 563, 'ar_name' => 'المغير', 'en_name' => '', 'zip_code' => '']);

        /*::::::::::::::::::::::::::::::::::::::
                      wilaya_id=58
        ::::::::::::::::::::::::::::::::::::::*/
        // --- dayra_id=564 | dayra_name=المنيعة---//
        $Baladia = Baladia::create(['dayra_id' => 564, 'ar_name' => 'المنيعة', 'en_name' => '', 'zip_code' => '']);
    }
}
