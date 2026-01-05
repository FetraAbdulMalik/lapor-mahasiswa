# 📋 APP FOLDER DOCUMENTATION

Complete documentation for all files dalam folder `app` dengan penjelasan lengkap struktur, relationships, dan functionality.

---

## 📂 FOLDER STRUCTURE

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Controller.php              # Base controller class
│   │   ├── HomeController.php          # ✅ Public pages (landing, about, FAQ, stats)
│   │   ├── ProfileController.php       # User profile management
│   │   ├── PublicReportController.php  # Public report viewing
│   │   ├── Admin/
│   │   │   ├── DashboardController.php # Admin dashboard & analytics
│   │   │   ├── ReportController.php    # Admin: manage reports
│   │   │   ├── CategoryController.php  # Admin: manage categories
│   │   │   ├── BuildingController.php  # Admin: manage buildings
│   │   │   ├── FacilityController.php  # Admin: manage facilities
│   │   │   ├── StudentController.php   # Admin: manage students
│   │   │   ├── DepartmentController.php
│   │   │   ├── FacultyController.php
│   │   │   ├── ActivityLogController.php
│   │   │   ├── AnalyticsController.php
│   │   │   ├── SettingsController.php
│   │   │   └── UserController.php
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── PasswordController.php
│   │   │   └── ... (7 more auth files)
│   │   └── Student/
│   │       ├── DashboardController.php # ✅ Student dashboard
│   │       ├── ReportController.php    # ✅ Student: CRUD reports
│   │       ├── ProfileController.php   # Student profile
│   │       └── NotificationController.php
│   ├── Middleware/
│   │   └── RoleMiddleware.php          # Authorization by role
│   └── Requests/
│       ├── ProfileUpdateRequest.php
│       ├── Auth/
│       │   └── LoginRequest.php
│       └── Admin/
│           └── ActivityLogFilterRequest.php
├── Models/  (13 models)
│   ├── User.php                        # ✅ Users (student/admin)
│   ├── Report.php                      # ✅ Laporan mahasiswa
│   ├── ReportCategory.php              # Kategori laporan
│   ├── ReportStatus.php                # Status history laporan
│   ├── ReportAttachment.php            # File attachments
│   ├── Comment.php                     # Comments on reports
│   ├── Notification.php                # ✅ User notifications
│   ├── Building.php                    # Gedung kampus
│   ├── Facility.php                    # Ruangan/fasilitas
│   ├── Department.php                  # Jurusan/departemen
│   ├── Faculty.php                     # Fakultas
│   ├── StudentProfile.php              # Profile mahasiswa detail
│   └── ActivityLog.php                 # User activity tracking
├── Providers/
│   └── AppServiceProvider.php          # Service provider config
├── Services/
│   └── (Empty for now)
└── View/
    └── Components/
        ├── AppLayout.php               # Main layout component
        └── GuestLayout.php             # Guest layout component
```

---

## 🎯 CONTROLLERS DOCUMENTATION

### **HomeController** ✅ DOCUMENTED
**File:** `Http/Controllers/HomeController.php`

Public pages controller untuk public access (tanpa login required).

#### Methods:
| Method | Purpose | Returns |
|--------|---------|---------|
| `index()` | Landing page | `view('landing')` |
| `about()` | About page | `view('pages.about')` |
| `howToReport()` | Report guide dengan kategori | `$categories` |
| `faq()` | FAQ list | Array of FAQs |
| `statistics()` | Public statistics dashboard | `$totalReports, $resolvedReports, $reportsByCategory, $reportsByMonth, $avgResponseTime` |
| `contact()` | Contact form | `view('pages.contact')` |
| `sendContact()` | Process contact form | Redirect with success |

---

### **Student Controllers**

#### **Student/DashboardController** ✅ DOCUMENTED
**File:** `Http/Controllers/Student/DashboardController.php`

Dashboard untuk mahasiswa dengan summary statistics.

#### Methods:
| Method | Purpose | Data Returned |
|--------|---------|---|
| `index()` | Student dashboard | `$totalReports, $pendingReports, $inProgressReports, $resolvedReports, $recentReports, $notifications` |

---

#### **Student/ReportController** ✅ DOCUMENTED
**File:** `Http/Controllers/Student/ReportController.php`

CRUD operations untuk laporan mahasiswa.

#### Methods:
| Method | Purpose |
|--------|---------|
| `index()` | List laporan dengan filter & search |
| `create()` | Show form membuat laporan |
| `store()` | Save laporan baru + file uploads |
| `show()` | Detail laporan |
| `edit()` | Show edit form (pending only) |
| `update()` | Update laporan (pending only) |
| `destroy()` | Delete laporan + files (pending only) |
| `addComment()` | Add comment pada laporan |
| `getFacilities()` | AJAX: load fasilitas by building |

---

#### **Student/ProfileController**
**File:** `Http/Controllers/Student/ProfileController.php`

Student profile management (CRUD profil mahasiswa detail).

#### Key Features:
- View profile
- Update profile info
- Upload avatar
- Change password

---

#### **Student/NotificationController**
**File:** `Http/Controllers/Student/NotificationController.php`

Notification management untuk student.

#### Methods:
- List notifications
- Mark as read
- Delete notifications

---

### **Admin Controllers**

#### **Admin/ReportController**
**File:** `Http/Controllers/Admin/ReportController.php`

Admin-side report management (view, update status, assign, resolve).

#### Key Methods:
- `index()` - List all reports dengan filter
- `show()` - Detail laporan
- `updateStatus()` - Change report status
- `assign()` - Assign report ke staff
- `resolve()` - Mark as resolved
- `reject()` - Reject laporan

---

#### **Admin/DashboardController**
**File:** `Http/Controllers/Admin/DashboardController.php`

Admin analytics dashboard dengan KPI & metrics.

#### Data:
- Total reports overview
- Status breakdown
- Category performance
- Top reporters
- Response time metrics
- Trend charts

---

#### **Admin/CategoryController**
**File:** `Http/Controllers/Admin/CategoryController.php`

CRUD untuk report categories.

#### Methods: CRUD (Create, Read, Update, Delete)

---

#### **Admin/BuildingController**
**File:** `Http/Controllers/Admin/BuildingController.php`

CRUD untuk buildings (gedung kampus).

---

#### **Admin/FacilityController**
**File:** `Http/Controllers/Admin/FacilityController.php`

CRUD untuk facilities (ruangan/fasilitas).

#### Key Relationship:
- Building → Many Facilities
- Facility belongs to Building

---

#### **Admin/StudentController**
**File:** `Http/Controllers/Admin/StudentController.php`

Admin management untuk student users.

#### Methods:
- List students
- View student profile
- Edit student info
- Activate/Deactivate students

---

### **Other Controllers**

#### **ProfileController** (Non-Admin)
**File:** `Http/Controllers/ProfileController.php`

General user profile management.

---

#### **PublicReportController**
**File:** `Http/Controllers/PublicReportController.php`

Public report viewing (public laporan yang bisa dilihat siapa saja).

---

### **Auth Controllers**

**Location:** `Http/Controllers/Auth/`

Standard Laravel authentication controllers:
- `LoginController.php`
- `RegisterController.php`
- `PasswordController.php`
- `PasswordResetLinkController.php`
- `AuthenticatedSessionController.php`
- `RegisteredUserController.php`
- `EmailVerificationPromptController.php`
- `EmailVerificationNotificationController.php`
- `VerifyEmailController.php`
- `ConfirmablePasswordController.php`

---

## 🗂️ MODELS DOCUMENTATION

### **User Model** ✅ DOCUMENTED
**File:** `Models/User.php`

Merepresentasikan users dalam sistem (student, admin, super_admin).

#### Properties:
- `name` - Nama user
- `email` - Email unik
- `password` - Hashed password
- `phone` - Nomor telepon
- `role` - student | admin | super_admin
- `is_active` - Boolean active flag

#### Relationships:
| Relation | Type | Description |
|----------|------|-------------|
| `studentProfile()` | HasOne | Profile detail mahasiswa |
| `reports()` | HasMany | Laporan yang dibuat user |
| `assignedReports()` | HasMany | Laporan yang assigned ke user |
| `comments()` | HasMany | Comments dari user |
| `notifications()` | HasMany | Notifications untuk user |
| `activityLogs()` | HasMany | Activity log user |

#### Query Scopes:
- `students()` - Filter role = 'student'
- `admins()` - Filter role IN ('admin', 'super_admin')
- `active()` - Filter is_active = true

#### Helper Methods:
- `isStudent()` - Check apakah student
- `isAdmin()` - Check apakah admin
- `isSuperAdmin()` - Check apakah super admin
- `getFullNameAttribute()` - Full name accessor
- `getAvatarAttribute()` - Avatar URL accessor

---

### **Report Model** ✅ DOCUMENTED
**File:** `Models/Report.php`

Merepresentasikan laporan mahasiswa.

#### Properties:
- `reference_number` - Unique ID (REP-YYYY-00001)
- `user_id` - Pembuat laporan
- `category_id` - Kategori laporan
- `title` - Judul laporan
- `description` - Detail deskripsi
- `status` - pending | in_review | in_progress | resolved | rejected
- `priority` - low | medium | high | urgent
- `visibility` - public | anonymous | private
- `is_anonymous` - Boolean anonymity flag
- `incident_date` - Kapan kejadian
- `assigned_to` - Staff yang handle
- `resolved_at` - Timestamp resolusi

#### Relationships:
| Relation | Type | Description |
|----------|------|-------------|
| `user()` | BelongsTo | Pembuat laporan |
| `category()` | BelongsTo | Kategori laporan |
| `building()` | BelongsTo | Gedung lokasi |
| `facility()` | BelongsTo | Fasilitas lokasi |
| `assignedTo()` | BelongsTo | Staff handler |
| `attachments()` | HasMany | File attachments |
| `statusHistory()` | HasMany | Status change history |
| `comments()` | HasMany | Comments thread |
| `notifications()` | HasMany | Related notifications |

#### Query Scopes:
- `pending()` - Status = pending
- `inReview()` - Status = in_review
- `inProgress()` - Status = in_progress
- `resolved()` - Status = resolved
- `rejected()` - Status = rejected
- `public()` - Visibility = public
- `recent()` - Order by created_at DESC
- `byCategory($id)` - Filter by kategori
- `byUser($id)` - Filter by user
- `assignedTo($id)` - Filter by assigned staff

#### Helper Methods:
- `getStatusBadgeColorAttribute()` - Status color untuk UI
- `getStatusLabelAttribute()` - Status name (Bahasa Indo)
- `getPriorityBadgeColorAttribute()` - Priority color
- `getPriorityLabelAttribute()` - Priority name
- `getReporterNameAttribute()` - Reporter name (handle anonymity)
- `getReporterAvatarAttribute()` - Reporter avatar
- `getDaysOpenAttribute()` - Days laporan terbuka
- `getFullLocationAttribute()` - Full location string
- `incrementViews()` - Increment view counter
- `isOwnedBy($user)` - Check ownership
- `canBeEditedBy($user)` - Check edit permission

#### Model Events:
- `creating()` - Auto-generate reference_number

---

### **ReportCategory Model**
**File:** `Models/ReportCategory.php`

Kategori laporan (Akademik, Fasilitas, Administrasi, dll).

#### Properties:
- `name` - Nama kategori
- `description` - Deskripsi kategori
- `icon` - Emoji icon
- `color` - Warna badge
- `is_active` - Boolean active flag

#### Relationships:
- `reports()` - HasMany kategori laporan

#### Scopes:
- `active()` - is_active = true

---

### **Building Model**
**File:** `Models/Building.php`

Gedung/bangunan di kampus.

#### Properties:
- `name` - Nama gedung
- `code` - Kode gedung
- `address` - Alamat
- `is_active` - Boolean active flag

#### Relationships:
- `facilities()` - HasMany fasilitas dalam gedung

#### Scopes:
- `active()` - is_active = true

---

### **Facility Model**
**File:** `Models/Facility.php`

Ruangan/fasilitas dalam gedung.

#### Properties:
- `building_id` - Foreign key ke building
- `name` - Nama fasilitas
- `code` - Kode fasilitas
- `type` - Tipe ruangan (classroom, lab, office, dll)
- `floor` - Lantai
- `capacity` - Kapasitas
- `is_active` - Boolean active flag

#### Relationships:
- `building()` - BelongsTo building
- `reports()` - HasMany laporan

#### Scopes:
- `active()` - is_active = true

---

### **ReportStatus Model**
**File:** `Models/ReportStatus.php`

History perubahan status laporan (audit trail).

#### Properties:
- `report_id` - Foreign key ke report
- `previous_status` - Status sebelumnya
- `new_status` - Status baru
- `notes` - Catatan perubahan
- `created_by` - User yang ubah

#### Relationships:
- `report()` - BelongsTo Report
- `createdBy()` - BelongsTo User

---

### **ReportAttachment Model**
**File:** `Models/ReportAttachment.php`

File attachments untuk laporan.

#### Properties:
- `report_id` - Foreign key ke report
- `file_name` - Nama file original
- `file_path` - Path di storage
- `file_type` - Extension (pdf, jpg, dll)
- `file_size` - Ukuran bytes
- `mime_type` - MIME type

#### Relationships:
- `report()` - BelongsTo Report

---

### **Comment Model**
**File:** `Models/Comment.php`

Comments/replies pada laporan untuk komunikasi user-staff.

#### Properties:
- `report_id` - Foreign key ke report
- `user_id` - Pembuat comment
- `comment` - Text komentar
- `is_official` - Boolean official staff reply flag

#### Relationships:
- `report()` - BelongsTo Report
- `user()` - BelongsTo User

---

### **Notification Model** ✅ DOCUMENTED
**File:** `Models/Notification.php`

Notifikasi untuk user tentang laporan.

#### Properties:
- `user_id` - Recipient user
- `type` - report_created | status_changed | assigned | comment_added | resolved | rejected
- `title` - Judul notifikasi
- `message` - Pesan detail
- `report_id` - Related report
- `data` - JSON additional data
- `is_read` - Boolean read flag
- `read_at` - Timestamp dibaca

#### Relationships:
- `user()` - BelongsTo User
- `report()` - BelongsTo Report

#### Scopes:
- `unread()` - is_read = false
- `read()` - is_read = true
- `recent()` - Order by created_at DESC

#### Methods:
- `markAsRead()` - Mark notifikasi as read
- `getIconAttribute()` - Icon emoji by type
- `getTypeNameAttribute()` - Type name (Bahasa Indo)

---

### **StudentProfile Model**
**File:** `Models/StudentProfile.php`

Detail profil mahasiswa.

#### Properties:
- `user_id` - Foreign key ke user
- `nim` - Nomor Induk Mahasiswa
- `faculty_id` - Faculty ID
- `department_id` - Department ID
- `year_of_admission` - Tahun masuk
- `avatar` - Path avatar
- `phone` - Nomor HP
- `address` - Alamat

#### Relationships:
- `user()` - BelongsTo User
- `faculty()` - BelongsTo Faculty
- `department()` - BelongsTo Department

---

### **ActivityLog Model**
**File:** `Models/ActivityLog.php`

Audit trail untuk tracking user activities.

#### Properties:
- `user_id` - User yang melakukan action
- `action` - Aksi (create, update, delete, view, dll)
- `subject` - Apa yang di-action (Report, Comment, dll)
- `subject_id` - ID subject
- `description` - Deskripsi
- `old_values` - Data sebelum perubahan
- `new_values` - Data sesudah perubahan
- `ip_address` - IP address user

#### Relationships:
- `user()` - BelongsTo User

---

### **Department & Faculty Models**
**Files:** `Models/Department.php`, `Models/Faculty.php`

Master data untuk organisasi struktur kampus.

#### Properties (Department):
- `name` - Nama jurusan
- `code` - Kode jurusan
- `faculty_id` - Faculty yang memiliki department

#### Properties (Faculty):
- `name` - Nama fakultas
- `code` - Kode fakultas
- `dean` - Nama dekan

---

## 🔐 MIDDLEWARE DOCUMENTATION

### **RoleMiddleware**
**File:** `Middleware/RoleMiddleware.php`

Middleware untuk check user role/permission.

#### Usage:
```php
'middleware' => 'role:student,admin'
```

#### Checks:
- Verify user memiliki required role
- Redirect ke unauthorized page jika tidak

---

## 📝 FORM REQUESTS DOCUMENTATION

### **LoginRequest**
**File:** `Requests/Auth/LoginRequest.php`

Validasi untuk login form.

#### Rules:
- `email` - required, email format
- `password` - required, string

---

### **ProfileUpdateRequest**
**File:** `Requests/ProfileUpdateRequest.php`

Validasi untuk update profile.

#### Rules:
- `name` - required, string
- `email` - required, email, unique
- `phone` - nullable, phone format

---

### **ActivityLogFilterRequest**
**File:** `Requests/Admin/ActivityLogFilterRequest.php`

Validasi filter untuk activity log dashboard.

---

## 🏗️ SERVICE PROVIDERS

### **AppServiceProvider**
**File:** `Providers/AppServiceProvider.php`

Main service provider untuk application configuration.

#### Responsibilities:
- Register services
- Bootstrap application
- Configure database connections
- Register custom commands

---

## 🎨 VIEW COMPONENTS

### **AppLayout Component**
**File:** `View/Components/AppLayout.php`

Main layout component untuk authenticated pages.

#### Features:
- Navigation
- Sidebar
- Footer
- Authentication check

---

### **GuestLayout Component**
**File:** `View/Components/GuestLayout.php`

Layout untuk guest/unauthenticated pages.

#### Features:
- Simple layout (no sidebar)
- Login/Register links
- Public pages styling

---

## 📊 CONTROLLER HIERARCHY

```
Controller (Base)
├── HomeController                    ← Public pages
├── ProfileController                 ← User profile
├── PublicReportController           ← Public viewing
├── Admin/
│   ├── DashboardController          ← Admin dashboard
│   ├── ReportController             ← Report management
│   ├── CategoryController           ← Category CRUD
│   ├── BuildingController           ← Building CRUD
│   ├── FacilityController           ← Facility CRUD
│   ├── StudentController            ← Student management
│   ├── DepartmentController         ← Department CRUD
│   ├── FacultyController            ← Faculty CRUD
│   ├── ActivityLogController        ← Activity tracking
│   ├── AnalyticsController          ← Analytics dashboard
│   ├── SettingsController           ← System settings
│   └── UserController               ← User management
├── Auth/
│   ├── LoginController
│   ├── RegisterController
│   ├── PasswordController
│   └── ... (7 more)
└── Student/
    ├── DashboardController          ← Student dashboard
    ├── ReportController             ← Report CRUD
    ├── ProfileController            ← Profile management
    └── NotificationController       ← Notification handling
```

---

## 🔗 MODEL RELATIONSHIPS DIAGRAM

```
User (1)
├─→ StudentProfile (1)
│   ├─→ Faculty (1)
│   └─→ Department (1)
├─→ Reports (M) ─→ Report
│   ├─→ ReportCategory (1)
│   ├─→ Building (1)
│   ├─→ Facility (1)
│   ├─→ ReportStatus (M) - History
│   ├─→ ReportAttachment (M) - Files
│   ├─→ Comment (M) - Thread
│   └─→ Notification (M)
├─→ AssignedReports (M) ─→ Report
├─→ Comments (M) ─→ Comment
├─→ Notifications (M) ─→ Notification
└─→ ActivityLogs (M) ─→ ActivityLog

Report (1)
├─→ User (1) - Creator
├─→ User (1) - AssignedTo
├─→ ReportCategory (1)
├─→ Building (1)
├─→ Facility (1)
├─→ ReportStatus (M) - History
├─→ ReportAttachment (M) - Files
├─→ Comment (M) - Thread
└─→ Notification (M)

Building (1)
└─→ Facility (M)
    └─→ Report (M)

Faculty (1)
└─→ Department (M)
    └─→ StudentProfile (M)
```

---

## 🚀 KEY WORKFLOWS

### Report Creation Flow:
```
1. Student → Student/ReportController::create()
   ↓
2. Form display dengan categories, buildings
   ↓
3. Student submit → store()
   ↓
4. Validate input
   ↓
5. Create Report record + FileUploads
   ↓
6. Create ReportStatus history (pending)
   ↓
7. Create Notification untuk admin
   ↓
8. Redirect ke show page dengan success message
```

### Report Processing Flow:
```
1. Admin → Admin/ReportController::show()
   ↓
2. Display report detail + comments
   ↓
3. Admin action → updateStatus()
   ↓
4. Update status (in_review → in_progress → resolved)
   ↓
5. Create ReportStatus history
   ↓
6. Send Notification ke student
   ↓
7. Log activity di ActivityLog
```

### Notification Flow:
```
1. Report action triggered
   ↓
2. Create Notification record
   ↓
3. Student receive notification
   ↓
4. Display in Student/NotificationController
   ↓
5. Student mark as read → markAsRead()
```

---

## 📖 TESTING GUIDE

### Key Files to Test:
- ✅ **HomeController** - Public pages
- ✅ **Student/ReportController** - CRUD operations
- ✅ **Admin/ReportController** - Status management
- ✅ **Report Model** - Business logic
- ✅ **User Model** - Authentication

### Test Cases:
1. User registration & authentication
2. Create report dengan validasi
3. File upload handling
4. Status update & notification
5. Anonymity handling
6. Permission checks

---

## 🔒 SECURITY FEATURES

1. **Authentication** - Laravel Fortify/Sanctum
2. **Authorization** - RoleMiddleware checks
3. **Validation** - Form Requests
4. **Database** - Relationships + Scopes
5. **File Upload** - Validation + Storage
6. **Password** - Hash + Verify
7. **Activity Log** - Audit trail

---

## 🎯 SUMMARY

| Component | Count | Status |
|-----------|-------|--------|
| Controllers | 23 | 2 documented ✅ |
| Models | 13 | 3 documented ✅ |
| Middleware | 1 | Not documented |
| Requests | 3 | Not documented |
| Components | 2 | Not documented |
| **Total** | **42** | **5 documented** ✅ |

---

**Last Updated:** January 6, 2026
**Documentation Status:** In Progress (5/42 files documented with detailed # comments)
