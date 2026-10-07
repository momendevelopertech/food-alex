<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Tax;
use App\Models\Page;
use App\Models\Branch;
use App\Models\Address;
use App\Models\User;
use App\Enums\TaxType;
use App\Enums\Status;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ensure Taxes (IDs 1 to 5)
        $taxes = [
            [
                'id'       => 1,
                'name'     => 'بدون ضريبة (معفى)',
                'code'     => 'VAT-0',
                'tax_rate' => 0,
                'type'     => TaxType::PERCENTAGE,
                'status'   => Status::ACTIVE,
            ],
            [
                'id'       => 2,
                'name'     => 'ضريبة القيمة المضافة (VAT 14%)',
                'code'     => 'VAT-14%',
                'tax_rate' => 14,
                'type'     => TaxType::PERCENTAGE,
                'status'   => Status::ACTIVE,
            ],
            [
                'id'       => 3,
                'name'     => 'ضريبة مخفضة (VAT 5%)',
                'code'     => 'VAT-5%',
                'tax_rate' => 5,
                'type'     => TaxType::PERCENTAGE,
                'status'   => Status::ACTIVE,
            ],
            [
                'id'       => 4,
                'name'     => 'ضريبة مبيعات (VAT 10%)',
                'code'     => 'VAT-10%',
                'tax_rate' => 10,
                'type'     => TaxType::PERCENTAGE,
                'status'   => Status::ACTIVE,
            ],
            [
                'id'       => 5,
                'name'     => 'خدمة صالة (Service 12%)',
                'code'     => 'SVC-12%',
                'tax_rate' => 12,
                'type'     => TaxType::PERCENTAGE,
                'status'   => Status::ACTIVE,
            ],
        ];

        foreach ($taxes as $tax) {
            Tax::updateOrCreate(['id' => $tax['id']], $tax);
        }

        // 2. Ensure Pages
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

        foreach ($pages as $p) {
            Page::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // 3. Localize Main Branch
        Branch::updateOrCreate(
            ['id' => 1],
            [
                'name'      => 'فرع الإسكندرية (الرئيسي)',
                'email'     => 'alex@food-alex.kesug.com',
                'phone'     => '0123456789',
                'latitude'  => 31.2000924,
                'longitude' => 29.9187382,
                'city'      => 'الإسكندرية',
                'state'     => 'الإسكندرية',
                'zip_code'  => '21500',
                'address'   => 'سموحة، أمام جرين بلازا، الإسكندرية، مصر',
                'status'    => Status::ACTIVE,
            ]
        );

        // 4. Ensure demo customer has a delivery address
        $customer = User::where('email', 'customer@example.com')->first();
        if ($customer) {
            Address::firstOrCreate([
                'user_id' => $customer->id,
                'label'   => 'المنزل',
            ], [
                'address'   => 'سموحة، الإسكندرية، مصر',
                'apartment' => 'عمارة 14، الدور الثالث، شقة 6',
                'latitude'  => '31.2001',
                'longitude' => '29.9187',
            ]);
        }

        // 5. Update settings defaults for branch and company
        $settingsUpdates = [
            'site' => [
                'site_default_branch'          => 1,
                'site_default_currency'        => 1,
                'site_default_currency_symbol' => 'ج.م',
            ],
            'company' => [
                'company_name'         => 'FoodAlex - Restaurant Food Ordering & Delivery App',
                'company_email'        => 'info@food-alex.kesug.com',
                'company_phone'        => '0123456789',
                'company_website'      => 'https://food-alex.kesug.com',
                'company_city'         => 'الإسكندرية',
                'company_state'        => 'الإسكندرية',
                'company_country_code' => 'EG',
                'company_zip_code'     => '21500',
                'company_address'      => 'سموحة، الإسكندرية، مصر',
            ]
        ];

        foreach ($settingsUpdates as $group => $items) {
            foreach ($items as $k => $val) {
                DB::table('settings')->updateOrInsert(
                    ['group' => $group, 'key' => $k],
                    ['payload' => json_encode($val)]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
