<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Page;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title'           => 'من نحن',
                'slug'            => 'about-us',
                'description'     => "أهلاً بكم في FoodAlex - وجهتكم الأولى لأشهى المأكولات والمشروبات في الإسكندرية. نحن نحرص على تقديم أطباق محضرة بأعلى معايير الجودة والمذاق الأصيل باستخدام مكونات طازجة يومياً. هدفنا هو تقديم تجربة تناول طعام فريدة وسريعة سواء في صالة المطعم أو عبر خدمة التوصيل السريع لجميع أنحاء الإسكندرية.",
                'menu_section_id' => 2,
                'template_id'     => 0,
                'status'          => Status::ACTIVE,
            ],
            [
                'title'           => 'سياسة الخصوصية',
                'slug'            => 'privacy-policy',
                'description'     => "نحن في FoodAlex نلتزم بحماية خصوصية بياناتك ومعلوماتك الشخصية. يتم استخدام المعلومات التي نجمعها (مثل الاسم، ورقم الهاتف، وعنوان التوصيل) فقط لتقديم الخدمة وتوصيل طلباتكم وتأكيد الحجوزات. لا نقوم بمشاركة أي من بياناتك مع أي طرف ثالث دون موافقتك الصريحة.",
                'menu_section_id' => 2,
                'template_id'     => 0,
                'status'          => Status::ACTIVE,
            ],
            [
                'title'           => 'الشروط والأحكام',
                'slug'            => 'terms-conditions',
                'description'     => "باستخدامك لموقع وتطبيق FoodAlex، فإنك توافق على الالتزام بشروط الاستخدام المعمول بها. تشمل الشروط صحة البيانات المدخلة عند الطلب، ومواعيد التوصيل التقديرية، وسياسة إلغاء الطلبات واسترداد الأموال بما يضمن حقوق العميل والمطعم معاً.",
                'menu_section_id' => 2,
                'template_id'     => 0,
                'status'          => Status::ACTIVE,
            ],
            [
                'title'           => 'سياسة الكوكيز',
                'slug'            => 'cookies-policy',
                'description'     => "يستخدم موقع FoodAlex ملفات تعريف الارتباط (Cookies) لتحسين تجربة تصفحك وتذكر تفضيلاتك مثل اللغة وسلة المشتريات. يمكنك تعديل إعدادات المتصفح لإيقاف هذه الملفات في أي وقت.",
                'menu_section_id' => 2,
                'template_id'     => 0,
                'status'          => Status::ACTIVE,
            ],
            [
                'title'           => 'اتصل بنا',
                'slug'            => 'contact-us',
                'description'     => "يسعدنا دائماً تواصلكم معنا في FoodAlex. يمكنك الاتصال بنا مباشرة على الهاتف: 0123456789 أو مراسلتنا عبر البريد الإلكتروني: info@food-alex.kesug.com. فرعنا الرئيسي: سموحة، الإسكندرية، مصر.",
                'menu_section_id' => 2,
                'template_id'     => 1,
                'status'          => Status::ACTIVE,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
