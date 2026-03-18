<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookIssueController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookReturnController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LibraryCardController;
use App\Http\Controllers\BookIssueReturnController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\InventoryCategoryController;
use App\Http\Controllers\Backend\SuperAdminController;



Auth::routes(['reset' => true]);

// Homepage
Route::view('/', 'frontend.home');

// ==============================
// Authentication Routes
// ==============================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==============================
// Profile Routes (auth only)
// ==============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================
// Backend Dashboards (Role-based)
// ==============================
Route::prefix('backend')->middleware('auth')->group(function () {
    // SuperAdmin Dashboard
    Route::middleware('role:SuperAdmin')
        ->get('/superadmin/dashboard', fn() => view('backend.controlpanel.superadmin.dashboard'))
        ->name('backend.controlpanel.superadmin.dashboard');

    // Admin Dashboard
    Route::middleware('role:Admin')
        ->get('/admin/dashboard', fn() => view('backend.controlpanel.admin.dashboard'))
        ->name('backend.controlpanel.admin.dashboard');

    // Supervisor Dashboard
    // Route::middleware('role:Supervisor')
    //    ->get('/supervisor/dashboard', fn() => view('backend.controlpanel.supervisor.dashboard'))
    //  ->name('backend.controlpanel.supervisor.dashboard');

    // Editor Dashboard (for both Editor and Chief Editor)
    //Route::middleware('role:Editor|Chief Editor')
    //   ->get('/editor/dashboard', fn() => view('backend.controlpanel.editor.dashboard'))
    // ->name('backend.controlpanel.editor.dashboard');

    // BDO Dashboard
    //Route::middleware('role:BDO')
    //   ->get('/bdo/dashboard', fn() => view('backend.controlpanel.bdo.dashboard'))
    // ->name('backend.controlpanel.bdo.dashboard');
});
// Optional duplicate SuperAdmin controller dashboard


// ==============================
// Backend Resource Management
// ==============================


Route::prefix('backend/users')
    ->name('backend.users.')
    ->middleware(['auth'])
    ->group(function () {
        // Index & Create
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');

        // Bulk Delete
        Route::post('bulk-delete', [UserController::class, 'bulkDelete'])->name('bulk-delete');

        // Export & Print
        Route::get('/print', [UserController::class, 'print'])->name('print');
        Route::get('/export/pdf', [UserController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel', [UserController::class, 'exportExcel'])->name('export.excel');

        // Edit/Update/Delete/Show — MUST be last
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
    });





Route::prefix('backend/roles')->name('backend.roles.')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::get('create', [RoleController::class, 'create'])->name('create');
    Route::post('store', [RoleController::class, 'store'])->name('store');

    // Print and export routes - put these BEFORE dynamic {role} routes
    Route::get('print', [RoleController::class, 'print'])->name('print');
    Route::get('pdf', [RoleController::class, 'exportPdf'])->name('export.pdf');
    Route::get('RolesExport', [RoleController::class, 'exportExcel'])->name('export.excel');
    Route::delete('bulk-delete', [RoleController::class, 'bulkDelete'])->name('bulk-delete');

    // Dynamic routes come last

    Route::get('{role}/edit', [RoleController::class, 'edit'])->name('edit');
    Route::put('{role}', [RoleController::class, 'update'])->name('update');


    Route::delete('{role}', [RoleController::class, 'destroy'])->name('destroy');
    Route::get('{role}', [RoleController::class, 'show'])->name('show');
});


Route::prefix('backend/permissions')->name('backend.permissions.')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::get('create', [PermissionController::class, 'create'])->name('create');
    Route::post('store', [PermissionController::class, 'store'])->name('store');
    Route::get('{id}', [PermissionController::class, 'show'])->name('show');
    Route::get('{id}/edit', [PermissionController::class, 'edit'])->name('edit');
    Route::put('{id}', [PermissionController::class, 'update'])->name('update');
    Route::delete('{id}', [PermissionController::class, 'destroy'])->name('destroy');
    Route::post('bulk-delete', [PermissionController::class, 'bulkDelete'])->name('bulk-delete');
    Route::get('export/pdf', [PermissionController::class, 'exportPdf'])->name('export.pdf');
    Route::get('export/excel', [PermissionController::class, 'exportExcel'])->name('export.excel');
    Route::get('export/filtered/pdf', [PermissionController::class, 'exportFilteredPDF'])->name('export.filtered.pdf');
    Route::get('export/filtered/excel', [PermissionController::class, 'exportFilteredExcel'])->name('export.filtered.excel');
});



Route::middleware(['web', 'auth'])
    ->prefix('backend/visitors')
    ->name('backend.visitors.')
    ->group(function () {

        Route::middleware('permission:view visitors')->get('/', [VisitorController::class, 'index'])->name('index');

        Route::middleware('permission:create visitors')->get('/create', [VisitorController::class, 'create'])->name('create');
        Route::middleware('permission:create visitors')->post('/', [VisitorController::class, 'store'])->name('store');

        Route::middleware('permission:view visitors')->get('/{visitor}', [VisitorController::class, 'show'])->name('show');

        Route::middleware('permission:edit visitors')->get('/{visitor}/edit', [VisitorController::class, 'edit'])->name('edit');
        Route::middleware('permission:edit visitors')->put('/{visitor}', [VisitorController::class, 'update'])->name('update');

        Route::middleware('permission:delete visitors')->delete('/{visitor}', [VisitorController::class, 'destroy'])->name('destroy');

        // Bulk + Export + Print
        Route::middleware('permission:delete visitors')->post('/bulk-delete', [VisitorController::class, 'bulkDelete'])->name('bulk-delete');
        Route::middleware('permission:export visitors')->get('/export-excel', [VisitorController::class, 'exportExcel'])->name('export.excel');
        Route::middleware('permission:export visitors')->get('/export-pdf', [VisitorController::class, 'exportPdf'])->name('export.pdf');
        Route::middleware('permission:print visitors')->get('/print', [VisitorController::class, 'print'])->name('print');
    });



Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return 'All cache cleared!';
});
Route::prefix('backend/enquiries')
    ->name('backend.enquiries.')
    ->middleware(['auth'])
    ->group(function () {

        // List & Create
        Route::get('/', [EnquiryController::class, 'index'])->name('index');
        Route::get('/create', [EnquiryController::class, 'create'])->name('create');
        Route::post('/', [EnquiryController::class, 'store'])->name('store');

        // Export & Print (must come before wildcard {enquiry})
        Route::get('/export-excel', [EnquiryController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-pdf', [EnquiryController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/print', [EnquiryController::class, 'print'])->name('print');

        // Bulk delete (must also come before wildcard)
        Route::delete('/bulk-delete', [EnquiryController::class, 'bulkDelete'])->name('bulkDelete');

        // Wildcard routes for individual enquiry
        Route::get('/{enquiry}', [EnquiryController::class, 'show'])->name('show');
        Route::get('/{enquiry}/edit', [EnquiryController::class, 'edit'])->name('edit');
        Route::put('/{enquiry}', [EnquiryController::class, 'update'])->name('update');
        Route::delete('/{enquiry}', [EnquiryController::class, 'destroy'])->name('destroy');
    });



Route::post('/contacts', [ContactController::class, 'store'])->name('frontend.contacts.store');




Route::prefix('backend/categories')
    ->name('backend.categories.')
    ->middleware(['auth', 'role:SuperAdmin|Librarian'])
    ->group(function () {

        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');

        Route::get('/export-excel', [CategoryController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-pdf', [CategoryController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/print', [CategoryController::class, 'print'])->name('print');

        Route::delete('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('bulkDelete');

        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });



Route::prefix('backend/books')
    ->name('backend.books.')
    ->middleware(['auth', 'role:SuperAdmin|Admin|Manager']) // Spatie role-based access
    ->group(function () {
        Route::get('/print', [BookController::class, 'print'])->name('print');
        // Core CRUD Routes
        Route::get('/', [BookController::class, 'index'])->name('index');
        Route::get('/create', [BookController::class, 'create'])->name('create');
        Route::post('/', [BookController::class, 'store'])->name('store');
        Route::get('/search/{bookId}', [BookController::class, 'searchByBookId'])->name('search');
        Route::get('/modal-preview/{bookId}', [BookController::class, 'modalPreview'])->name('modalPreview');
        Route::get('/{book}', [BookController::class, 'show'])->name('show');
        Route::get('/{book}/edit', [BookController::class, 'edit'])->name('edit');
        Route::put('/{book}', [BookController::class, 'update'])->name('update');
        Route::delete('/{book}', [BookController::class, 'destroy'])->name('destroy');

        // Export & Print Routes

        Route::get('/export/pdf', [BookController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel', [BookController::class, 'exportExcel'])->name('export.excel');

        // Bulk Actions
        Route::post('/bulk-delete', [BookController::class, 'bulkDelete'])->name('bulkDelete');
    });


Route::prefix('backend/authors')
    ->name('backend.authors.')
    ->middleware(['auth', 'role:SuperAdmin|Admin|Manager'])
    ->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('index');
        Route::get('/create', [AuthorController::class, 'create'])->name('create');
        // Export & Print
        Route::get('/print', [AuthorController::class, 'print'])->name('print');
        Route::get('/excel', [AuthorController::class, 'exportExcel'])->name('excel');
        Route::get('/pdf', [AuthorController::class, 'exportPdf'])->name('pdf');


        Route::post('/', [AuthorController::class, 'store'])->name('store');
        Route::get('/{author}', [AuthorController::class, 'show'])->name('show');
        Route::get('/{author}/edit', [AuthorController::class, 'edit'])->name('edit');
        Route::put('/{author}', [AuthorController::class, 'update'])->name('update');


        Route::delete('/bulk-delete', [AuthorController::class, 'bulkDelete'])->name('bulkDelete');
        Route::delete('/{author}', [AuthorController::class, 'destroy'])->name('destroy');



        // Bulk Delete

    });


Route::prefix('backend/publishers')
    ->name('backend.publishers.')
    ->middleware(['auth', 'role:SuperAdmin|Admin|Manager'])
    ->group(function () {
        Route::get('/', [PublisherController::class, 'index'])->name('index');
        Route::get('/create', [PublisherController::class, 'create'])->name('create');
        Route::get('/print', [PublisherController::class, 'print'])->name('print');
        Route::get('/excel', [PublisherController::class, 'exportExcel'])->name('excel');
        Route::get('/pdf', [PublisherController::class, 'exportPdf'])->name('pdf');
        Route::post('/', [PublisherController::class, 'store'])->name('store');
        Route::get('/{publisher}', [PublisherController::class, 'show'])->name('show');
        Route::get('/{publisher}/edit', [PublisherController::class, 'edit'])->name('edit');
        Route::put('/{publisher}', [PublisherController::class, 'update'])->name('update');
        Route::delete('/bulk-delete', [PublisherController::class, 'bulkDelete'])->name('bulkDelete');
        Route::delete('/{publisher}', [PublisherController::class, 'destroy'])->name('destroy');
    });



Route::prefix('backend/students')
    ->name('backend.students.')
    ->middleware(['auth', 'role:SuperAdmin|Admin|Manager'])
    ->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::get('/print', [StudentController::class, 'print'])->name('print');
        Route::get('/excel', [StudentController::class, 'exportExcel'])->name('excel');
        Route::get('/pdf', [StudentController::class, 'exportPdf'])->name('pdf');
        Route::post('/', [StudentController::class, 'store'])->name('store');
        Route::get('/search/{libraryId}', [StudentController::class, 'searchByLibraryId'])->name('search');
        Route::get('/modal-preview/{student_library_id}', [StudentController::class, 'modalPreview'])->name('modalPreview');
        Route::get('/{student}', [StudentController::class, 'show'])->name('show');
        Route::post('/check-duplicate', [StudentController::class, 'checkDuplicate'])->name('checkDuplicate');

        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::put('/{student}', [StudentController::class, 'update'])->name('update');
        Route::delete('/bulk-delete', [StudentController::class, 'bulkDelete'])->name('bulkDelete');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
    });





Route::prefix('backend/book-issues')
    ->as('backend.book-issues.')
    ->middleware(['auth', 'role:SuperAdmin|Admin|Manager'])
    ->group(function () {

        // 📚 CRUD Routes
        Route::get('/', [BookIssueController::class, 'index'])->name('index');
        Route::get('/create', [BookIssueController::class, 'create'])->name('create');
        Route::post('/', [BookIssueController::class, 'store'])->name('store');

        // ✅ Preview must be above `{issue}` route
        Route::get('/preview-by-book/{bookId}', [BookIssueController::class, 'previewIssueByBook'])->name('preview-by-book');

        Route::get('/{issue}', [BookIssueController::class, 'show'])->name('show');
        Route::get('/{bookIssue}/edit', [BookIssueController::class, 'edit'])->name('edit');
        Route::put('/{bookIssue}', [BookIssueController::class, 'update'])->name('update');
        Route::delete('/{issue}', [BookIssueController::class, 'destroy'])->name('destroy');

        // 🔄 Book Return Flow
        Route::get('/{issue}/return', [BookIssueController::class, 'returnForm'])->name('return.form');
        Route::put('/{issue}/return', [BookIssueController::class, 'returnUpdate'])->name('return.update');

        // 📦 Bulk Actions
        Route::delete('/bulk-delete', [BookIssueController::class, 'bulkDelete'])->name('bulkDelete');
        Route::post('/bulk-return', [BookIssueController::class, 'bulkReturn'])->name('bulkReturn');

        // 📤 Export
        Route::get('/print', [BookIssueController::class, 'print'])->name('print');
        Route::get('/excel', [BookIssueController::class, 'exportExcel'])->name('excel');
        Route::get('/pdf', [BookIssueController::class, 'exportPdf'])->name('pdf');

        // 🔄 AJAX APIs
        Route::get('/api/students/get-id-by-lib/{libraryId}', [StudentController::class, 'getIdByLibraryId']);
        Route::get('/api/books/get-id/{bookId}', [BookController::class, 'getIdByBookId']);
    });



// 🔍 Modal Previews (outside route group)
Route::get('/backend/students/search/{libraryId}', [StudentController::class, 'searchByLibraryId']);
Route::get('/backend/books/search/{bookId}', [BookController::class, 'searchByBookId']);





Route::prefix('backend/book-returns')
    ->as('backend.book-returns.')
    ->middleware(['auth', 'role:SuperAdmin|Admin|Manager'])
    ->group(function () {
        Route::get('/fetch-student/{libraryId}', [BookReturnController::class, 'fetchStudent']);
        Route::get('/fetch-issue-info/{bookId}', [BookReturnController::class, 'fetchIssueInfo']);

        Route::get('/{return}/preview', [BookReturnController::class, 'preview'])->name('preview');

        Route::resource('/', BookReturnController::class)->parameters(['' => 'book_return'])->names([
            'index' => 'index',
            'create' => 'create',
            'store' => 'store',
            'show' => 'show',
            'edit' => 'edit',
            'update' => 'update',
            'destroy' => 'destroy',
        ]);
        Route::get('/excel', [BookReturnController::class, 'exportExcel'])->name('excel');
        Route::get('/pdf', [BookReturnController::class, 'exportPdf'])->name('pdf');
        Route::get('/print', [BookReturnController::class, 'print'])->name('print');
    });


Route::prefix('backend/inventory-categories')
    ->as('backend.inventory-categories.')
    ->middleware(['auth', 'role:SuperAdmin|Admin|Manager'])
    ->group(function () {
        Route::get('/', [InventoryCategoryController::class, 'index'])->name('index');
        Route::get('/create', [InventoryCategoryController::class, 'create'])->name('create');
        Route::post('/', [InventoryCategoryController::class, 'store'])->name('store');
        Route::get('/{inventoryCategory}/edit', [InventoryCategoryController::class, 'edit'])->name('edit');
        Route::put('/{inventoryCategory}', [InventoryCategoryController::class, 'update'])->name('update');
        Route::delete('/{inventoryCategory}', [InventoryCategoryController::class, 'destroy'])->name('destroy');

        // ✅ Export Routes
        Route::get('/export/pdf', [InventoryCategoryController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel', [InventoryCategoryController::class, 'exportExcel'])->name('export.excel');
        Route::get('/print', [InventoryCategoryController::class, 'print'])->name('print');
    });


Route::prefix('backend/stocks')
    ->as('backend.stocks.')
    ->middleware(['auth', 'role:SuperAdmin|Admin|Manager'])
    ->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('index');
        Route::get('/create', [StockController::class, 'create'])->name('create');
        Route::post('/', [StockController::class, 'store'])->name('store');

        // ✅ Export and Print routes BEFORE dynamic {stock}
        Route::get('/export/pdf', [StockController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel', [StockController::class, 'exportExcel'])->name('export.excel');
        Route::get('/print', [StockController::class, 'print'])->name('print');
        Route::get('/{stock}/bill', [StockController::class, 'viewBill'])->name('viewBill');

        // ✅ Dynamic {stock} routes AFTER all fixed routes
        Route::get('/{stock}/edit', [StockController::class, 'edit'])->name('edit');
        Route::put('/{stock}', [StockController::class, 'update'])->name('update');
        Route::get('/{stock}', [StockController::class, 'show'])->name('show');
        Route::delete('/{stock}', [StockController::class, 'destroy'])->name('destroy');
    });




Route::prefix('backend/purchase-requests')
    ->as('backend.purchase-requests.')
    ->middleware(['auth', 'role:SuperAdmin|Admin|Manager'])
    ->group(function () {
        // Export & Print - Keep these BEFORE dynamic routes
        Route::get('/export/pdf', [PurchaseRequestController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel', [PurchaseRequestController::class, 'exportExcel'])->name('export.excel');
        Route::get('/print', [PurchaseRequestController::class, 'print'])->name('print');

        // CRUD routes
        Route::get('/', [PurchaseRequestController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseRequestController::class, 'create'])->name('create');
        Route::post('/', [PurchaseRequestController::class, 'store'])->name('store');
        Route::get('/{purchaseRequest}/edit', [PurchaseRequestController::class, 'edit'])->name('edit');
        Route::put('/{purchaseRequest}', [PurchaseRequestController::class, 'update'])->name('update');
        Route::delete('/{purchaseRequest}', [PurchaseRequestController::class, 'destroy'])->name('destroy');
        Route::get('/{purchaseRequest}', [PurchaseRequestController::class, 'show'])->name('show');

        // ✅ Approval routes (fixed)
        Route::put('{id}/approve', [PurchaseRequestController::class, 'approve'])->name('approve');
        Route::put('{id}/reject', [PurchaseRequestController::class, 'reject'])->name('reject');
    });


Route::prefix('backend/library-cards')
    ->as('backend.library-cards.')
    ->middleware(['auth', 'role:SuperAdmin|Admin|Manager'])
    ->group(function () {
        Route::get('/{libraryCard}/print', [LibraryCardController::class, 'print'])->name('print');
        Route::get('/export/pdf', [LibraryCardController::class, 'exportPdf'])->name('export.pdf'); // ✅ Corrected
        Route::post('/{libraryCard}/send-pdf', [LibraryCardController::class, 'sendPdf'])->name('send.pdf');

        Route::get('/', [LibraryCardController::class, 'index'])->name('index');
        Route::get('/create', [LibraryCardController::class, 'create'])->name('create');
        Route::post('/', [LibraryCardController::class, 'store'])->name('store');
        Route::get('/{libraryCard}', [LibraryCardController::class, 'show'])->name('show');
        Route::delete('/{libraryCard}', [LibraryCardController::class, 'destroy'])->name('destroy');
    });
