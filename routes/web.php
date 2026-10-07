<?php

use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\RootController;
use App\Http\Controllers\Installer\InstallerController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Tax;
use App\Models\Page;
use App\Models\Branch;
use App\Models\Address;
use App\Enums\TaxType;
use App\Enums\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('install')->name('installer.')->middleware(['web'])->group(function () {
    Route::get('/', [InstallerController::class, 'index'])->name('index');
    Route::get('/requirement', [InstallerController::class, 'requirement'])->name('requirement');
    Route::get('/permission', [InstallerController::class, 'permission'])->name('permission');
    Route::get('/license', [InstallerController::class, 'license'])->name('license');
    Route::post('/license', [InstallerController::class, 'licenseStore'])->name('licenseStore');
    Route::get('/site', [InstallerController::class, 'site'])->name('site');
    Route::post('/site', [InstallerController::class, 'siteStore'])->name('siteStore');
    Route::get('/database', [InstallerController::class, 'database'])->name('database');
    Route::post('/database', [InstallerController::class, 'databaseStore'])->name('databaseStore');
    Route::get('/final', [InstallerController::class, 'final'])->name('final');
    Route::get('/final-store', [InstallerController::class, 'finalStore'])->name('finalStore');
});

Route::get('/', [RootController::class, 'index'])->middleware(['installed'])->name('home');
Route::prefix('payment')->name('payment.')->middleware(['installed'])->group(function () {
    Route::get('/{order}/pay', [PaymentController::class, 'index'])->name('index');
    Route::post('/{order}/pay', [PaymentController::class, 'payment'])->name('store');
    Route::match(['get', 'post'], '/{paymentGateway:slug}/{order}/success', [PaymentController::class, 'success'])->name('success');
    Route::match(['get', 'post'], '/{paymentGateway:slug}/{order}/fail', [PaymentController::class, 'fail'])->name('fail');
    Route::match(['get', 'post'], '/{paymentGateway:slug}/{order}/cancel', [PaymentController::class, 'cancel'])->name('cancel');
    Route::get('/successful/{order}', [PaymentController::class, 'successful'])->name('successful');
});

Route::get('/system/sync-live-data', function (\Illuminate\Http\Request $request) {
    if ($request->query('key') !== env('VITE_API_KEY', 'FoodAlexAPIKey2026')) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    // 1. Update Admin User and Country codes
    User::where('email', 'admin@example.com')
        ->orWhere('id', 1)
        ->update([
            'name'         => 'مدحت (المدير)',
            'phone'        => '0123456789',
            'country_code' => '+20',
            'status'       => Status::ACTIVE
        ]);

    User::where('country_code', '+880')
        ->update(['country_code' => '+20']);

    // 2. Sync Taxes
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

    // 3. Sync Legal and Info Pages
    $pages = [
        [
            'title'           => 'من نحن (About Us)',
            'slug'            => 'about-us',
            'description'     => "أهلاً بكم في FoodAlex - وجهتكم الأولى لأشهى المأكولات والمشروبات في الإسكندرية. نحن نحرص على تقديم أطباق محضرة بأعلى معايير الجودة والمذاق الأصيل باستخدام مكونات طازجة يومياً. هدفنا هو تقديم تجربة تناول طعام فريدة وسريعة سواء في صالة المطعم أو عبر خدمة التوصيل السريع لجميع أنحاء الإسكندرية.",
            'menu_section_id' => 2,
            'template_id'     => 0,
            'status'          => Status::ACTIVE,
        ],
        [
            'title'           => 'سياسة الخصوصية (Privacy Policy)',
            'slug'            => 'privacy-policy',
            'description'     => "نحن في FoodAlex نلتزم بحماية خصوصية بياناتك ومعلوماتك الشخصية. يتم استخدام المعلومات التي نجمعها (مثل الاسم، ورقم الهاتف، وعنوان التوصيل) فقط لتقديم الخدمة وتوصيل طلباتكم وتأكيد الحجوزات. لا نقوم بمشاركة أي من بياناتك مع أي طرف ثالث دون موافقتك الصريحة.",
            'menu_section_id' => 2,
            'template_id'     => 0,
            'status'          => Status::ACTIVE,
        ],
        [
            'title'           => 'الشروط والأحكام (Terms & Conditions)',
            'slug'            => 'terms-conditions',
            'description'     => "باستخدامك لموقع وتطبيق FoodAlex، فإنك توافق على الالتزام بشروط الاستخدام المعمول بها. تشمل الشروط صحة البيانات المدخلة عند الطلب، ومواعيد التوصيل التقديرية، وسياسة إلغاء الطلبات واسترداد الأموال بما يضمن حقوق العميل والمطعم معاً.",
            'menu_section_id' => 2,
            'template_id'     => 0,
            'status'          => Status::ACTIVE,
        ],
        [
            'title'           => 'سياسة ملفات تعريف الارتباط (Cookies Policy)',
            'slug'            => 'cookies-policy',
            'description'     => "يستخدم موقع FoodAlex ملفات تعريف الارتباط (Cookies) لتحسين تجربة تصفحك وتذكر تفضيلاتك مثل اللغة وسلة المشتريات. يمكنك تعديل إعدادات المتصفح لإيقاف هذه الملفات في أي وقت.",
            'menu_section_id' => 2,
            'template_id'     => 0,
            'status'          => Status::ACTIVE,
        ],
        [
            'title'           => 'اتصل بنا (Contact Us)',
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

    // 4. Localize Branch 1
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

    // 5. Ensure Demo Customer Address
    $customer = User::where('email', 'customer@example.com')->first();
    if ($customer) {
        Address::updateOrCreate([
            'user_id' => $customer->id,
            'label'   => 'المنزل',
        ], [
            'address'   => 'سموحة، الإسكندرية، مصر',
            'apartment' => 'عمارة 14، الدور الثالث، شقة 6',
            'latitude'  => '31.2001',
            'longitude' => '29.9187',
        ]);
    }

    // 6. Update Settings
    $settingsUpdates = [
        'site' => [
            'site_default_branch'          => '1',
            'site_default_currency'        => '1',
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

    // 7. Currencies table
    DB::table('currencies')
        ->where('code', 'EGP')
        ->update(['symbol' => 'ج.م']);

    // 8. Clear cache
    try {
        Artisan::call('optimize:clear');
    } catch (\Throwable $e) {}

    return response()->json([
        'status'  => true,
        'message' => 'Taxes, Pages, Branch, Customer Address, and Settings successfully synchronized!'
    ]);
});

Route::get('/{any}', [RootController::class, 'index'])->middleware(['installed'])->where(['any' => '.*']);
